<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Models\Circle;
use App\Repositories\CircleRepository;
use App\Repositories\EventRepository;
use App\Services\CircleService;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventCircleGetController extends Controller
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

        $circleIds = [];
        foreach ($event->getEvnetCircle() as $circle) {
            $circleIds[] = $circle['circle_id'];
        }

        $circles = $this->circleRepository->getByIds($circleIds);

        $response = [];

        /** @var Circle $circle */
        foreach ($circles as $circle) {
            $eventCircle = $circle->getEvnetCircle()->first()->toArray() ?? [];
            $circleInfo = $this->circleService->makeCircleResponse($circle);
            $response[] = array_merge($circleInfo, $eventCircle);

        }

        return $this->success($response, 200);
    }
}
