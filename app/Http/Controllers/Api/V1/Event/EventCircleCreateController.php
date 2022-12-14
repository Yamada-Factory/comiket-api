<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\CircleLink;
use App\Models\EventCircle;
use App\Repositories\CircleRepository;
use App\Repositories\EventRepository;
use App\Services\CircleService;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventCircleCreateController extends Controller
{
    public function __construct(private EventRepository $eventRepository, private EventService $eventService, private CircleRepository $circleRepository, private CircleService $circleService)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, int $id)
    {
        $event = $this->eventRepository->findById($id);
        if (!$event) {
            return $this->success([], 404);
        }

        $params = $request->all();

        $circle = $this->circleRepository->findByCirclMsId((int) $params['circle_ms_id']);
        if ($circle) {
            return $this->success([
                'error' => 'circle_ms_id=' . $params['circle_ms_id'] . 'is alredy registerd.'
            ], 409);
        }

        $circle = new Circle([
            'name' => $params['name'],
            'author' => $params['author'],
            'circle_ms_id' => $params['circle_ms_id'],
        ]);

        $circleLinkModelArray = [];
        foreach ($params['links'] as $type => $url) {
            $circleLinkModelArray[] = new CircleLink([
                'type' => $type,
                'url' => $url,
            ]);
        }

        // サークル情報保存
        $circle = $this->circleRepository->save($circle);
        $circle = $this->circleRepository->saveLinks($circle, $circleLinkModelArray);

        // サークルイベント参加情報保存
        $eventCircle = new EventCircle([
            'circle_id' => $circle->id,
            'event_id' => $event->id,
            'hall' => $params['hall'],
            'day' => $params['day'],
            'block' => $params['block'],
            'space' => $params['space'],
            'genre' => $params['genre'],
            'description' => $params['description'],
            'images' => $params['images'],
            'other' => $params['other'],
        ]);

        $eventCircle->save();

        $eventCircle->refresh();

        return $this->success($eventCircle->toArray(), 200);
    }
}
