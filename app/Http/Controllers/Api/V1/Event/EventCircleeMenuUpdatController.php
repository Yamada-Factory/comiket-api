<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Models\CircleLink;
use App\Models\EventCircle;
use App\Repositories\CircleRepository;
use App\Repositories\EventCircleRepository;
use App\Repositories\EventRepository;
use App\Services\CircleService;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventCircleeMenuUpdatController extends Controller
{
    public function __construct(
        private EventRepository $eventRepository,
        private EventService $eventService,
        private CircleRepository $circleRepository,
        private EventCircleRepository $eventCircleRepository,
        private CircleService $circleService,
    ) {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, int $id, int $circleId)
    {
        $event = $this->eventRepository->findById($id);
        if (!$event) {
            return $this->success([
                'message' => 'this event not found.',
            ], 404);
        }

        $circle = $this->circleRepository->findById($circleId);
        if (!$circle) {
            return $this->success([
                'message' => 'this circle not found.',
            ], 404);
        }

        $eventCircle = $this->eventCircleRepository->search([
            'event_id' => $id,
            'circle_id' => $circleId,
        ])->latest()->first();

        if (!$eventCircle) {
            return $this->success([
                'message' => 'this event circle not found.',
            ], 404);
        }

        $params = $request->all();
        $eventCircle->fill([
            'menu' => $params['menu'],
        ]);

        $eventCircle->save();

        $eventCircle->refresh();

        return $this->success($eventCircle->toArray(), 200);
    }
}
