<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Models\UserFavoriteCircle;
use App\Models\UserFavoriteEventCircle;
use App\Repositories\EventCircleRepository;
use App\Repositories\EventRepository;
use App\Repositories\UserFavoriteCircleRepository;
use App\Repositories\UserFavoriteEventCircleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserFavoriteCircleEventUpdateController extends Controller
{
    public function __construct(
        private UserFavoriteEventCircleRepository $userFavoriteEventCircleRepository,
        private UserFavoriteCircleRepository $userFavoriteCircleRepository,
        private EventCircleRepository $eventCircleRepository,
        private EventRepository $eventRepository,
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

        if (empty($params['circle_id'])) {
            return $this->success([
                'error' => 'Bad Request',
            ], Response::HTTP_BAD_REQUEST);
        }

        // それ以前にイベントの有無
        $event = $this->eventRepository->findById($id);
        if (!$event) {
            return $this->success([
                'error' => "イベントID=${id} は存在しません",
            ], Response::HTTP_BAD_REQUEST);
        }

        // そもそも指定のイベントにサークルがあるかチェック
        $eventCircle = $this->eventCircleRepository->search([
            'event_id' => $id,
            'circle_id' => $params['circle_id'],
        ])->latest()->first();
        if (!$eventCircle) {
            return $this->success([
                'error' => "イベントID=${id} に指定されたサークルは参加しません",
            ], Response::HTTP_BAD_REQUEST);
        }

        $userFavoriteCircle = $this->userFavoriteCircleRepository->search([
            'circle_id' => $params['circle_id'],
            'user_id' => $user->id,
        ])->latest()->first();

        // サークルがなければお気に入りに追加する
        if (!$userFavoriteCircle) {
            $userFavoriteCircle = new UserFavoriteCircle([
                'user_id' => $user->id,
                'circle_id' => $params['circle_id'],
                'color' => $params['color'] ?? UserFavoriteCircle::DEFAULT_COLOR,
            ]);

            $userFavoriteCircle = $this->userFavoriteCircleRepository->save($userFavoriteCircle);
        }

        /** @var UserFavoriteEventCircle $userEventFavoriteCircle */
        $userEventFavoriteCircle = $this->userFavoriteEventCircleRepository->search([
            'favorite_circle_id' => $userFavoriteCircle->id,
            'user_id' => $user->id,
            'event_id' => $id,
        ])->latest()->first();
        if (!$userEventFavoriteCircle) {
            return $this->success([], 404);
        }

        $userEventFavoriteCircle->fill([
            'favorite_circle_id' => $userFavoriteCircle->id,
            'priority' => $params['priority'] ?? 0,
            'e-commerce_flag' => boolval($params['e-commerce_flag'] ?? false),
            'price' => intval($params['price'] ?? 0),
            'comment' => $params['comment'] ?? '',
        ]);

        $userEventFavoriteCircle = $this->userFavoriteEventCircleRepository->save($userEventFavoriteCircle);

        return $this->success($userEventFavoriteCircle->toArray(), 200);
    }
}
