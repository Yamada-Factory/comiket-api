<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventGetListController extends Controller
{
    public function __construct(private EventRepository $repository, private EventService $service)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $events = $this->repository->all();

        $response = [];
        $response = $events->map(
            fn($event) => $this->service->makeEventResponse($event)
        );

        return $this->success($response->toArray(), 200);
    }
}
