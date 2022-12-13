<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Repositories\EventRepository;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventGetController extends Controller
{
    public function __construct(private EventRepository $repository,private EventService $service)
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
        $event = $this->repository->findById($id);
        if (!$event) {
            return $this->success([], 404);
        }

        return $this->success($this->service->makeEventResponse($event), 200);
    }
}
