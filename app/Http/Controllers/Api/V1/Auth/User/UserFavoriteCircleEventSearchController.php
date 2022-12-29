<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\V1\Auth\UserFavotiteEventCircleCollection;
use App\Http\Responses\Api\V1\Circle\CircleResource;
use App\Http\Responses\Api\V1\Event\EventResource;
use App\Models\UserFavoriteEventCircle;
use App\Repositories\EventCircleRepository;
use App\Repositories\UserFavoriteEventCircleRepository;
use App\Services\UserFavoriteEventCircleService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class UserFavoriteCircleEventSearchController extends Controller
{
    public function __construct(
        private UserFavoriteEventCircleRepository $userFavoriteEventCircleRepository,
        private UserFavoriteEventCircleService $userFavoriteEventCircleService,
        private EventCircleRepository $eventCircleRepository,
    ) {
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, int $id)
    {
        $user = $request->user();
        $params = $request->all();

        $userEventFavoriteCircles = $this->userFavoriteEventCircleService->getEventCirlces($user, $id, $params);

        $userEventFavoriteCirclesCollection = $userEventFavoriteCircles->map(function ($userEventFavoriteCircle) use ($request) {
            $favoriteCircle = $userEventFavoriteCircle->getCircle();
            /** @var Collection $events */
            $events = $userEventFavoriteCircle->event;

            $circle = (new CircleResource($favoriteCircle))->toArray($request);
            $circle['circle_id'] = $circle['id'];
            $circle['color'] = $userEventFavoriteCircle->color;

            $circleEvents = $events->map(function ($event) use ($request) {
                /** @var UserFavoriteEventCircle $event */
                $eventModel = $event->getEvent();
                $eventInfo = (new EventResource($eventModel))->toArray($request);

                $circleModel = $event->circle()->getResults();
                $eventInfo['info'] = $circleModel->evnetCircle()->where('event_id', '=', $eventModel->id)->first()->toArray();
                $eventInfo['priority'] = $event->priority;
                $eventInfo['e-commerce_flag'] = $event['e-commerce_flag'];
                $eventInfo['comment'] = $event->comment ?? '';
                $eventInfo['price'] = $event->price ?? 0;

                // アプリ側がobjectとstringの配列をパースできないため，アプリはオブジェクト削除
                $params = $request->all();
                if ($params['is_app'] ?? 0 === 1) {
                    $tmpImages = [];
                    foreach ($eventInfo['info']['images'] as $image) {
                        if (is_string($image)) {
                            $tmpImages[] = $image;
                        }
                    }
                    $eventInfo['info']['images'] = $tmpImages;
                }

                return $eventInfo;
            });
            $event = $circleEvents->toArray()[0] ?? [];
            $event['event_name'] = $event['name'];
            unset($event['name']);

            return collect(array_merge($event, $circle));
        });

        // ECサイトフラグでフィルター
        if (isset($params['e-commerce_flag'])) {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->filter(fn($userEventFavoriteCircle) => $userEventFavoriteCircle['e-commerce_flag'] === boolval($params['e-commerce_flag']));
        }

        // hallでフィルター
        if (!empty($params['hall'])) {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->filter(fn($userEventFavoriteCircle) => $userEventFavoriteCircle['info']['hall'] === $params['hall']);
        }

        // blockでフィルター
        if (!empty($params['block'])) {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->filter(fn($userEventFavoriteCircle) => $userEventFavoriteCircle['info']['block'] === $params['block']);
        }

        // spaceでフィルター
        if (!empty($params['space'])) {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->filter(fn($userEventFavoriteCircle) => $userEventFavoriteCircle['info']['space'] === $params['space']);
        }

        // genreでフィルター
        if (!empty($params['genre'])) {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->filter(fn($userEventFavoriteCircle) => $userEventFavoriteCircle['info']['genre'] === $params['genre']);
        }

        // dayでフィルター
        if (!empty($params['day'])) {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->filter(fn($userEventFavoriteCircle) => $userEventFavoriteCircle['info']['day'] === $params['day']);
        }

        // colorでフィルター
        if (!empty($params['color'])) {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->filter(fn($userEventFavoriteCircle) => $userEventFavoriteCircle['color'] === $params['color']);
        }

        // 優先度順でソート
        $sortOrderKey = $params['sort_by_priority'] ?? 'desc';
        if ($sortOrderKey === 'desc') {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->sortByDesc('priority', SORT_NATURAL)->values();
        } else {
            $userEventFavoriteCirclesCollection = $userEventFavoriteCirclesCollection->sortBy('priority', SORT_NATURAL)->values();
        }

        return $this->success($userEventFavoriteCirclesCollection->toArray(), 200);
    }
}
