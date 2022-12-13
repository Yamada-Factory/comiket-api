<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventCreateController extends Controller
{
    public function __construct(private EventRepository $repository, private EventService $service)
    {
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $params = $request->all();

        $event = new Event([
            'name' => $params['name'],
            'location_facility' => $params['location']['facility'],
            'location_address' => $params['location']['address'],
            'location_googlemap' => $params['location']['googlemap'],
            'location_latitude' => $params['location']['latitude'],
            'location_longitude' => $params['location']['longitude'],
            'from_at' => $params['date']['from'],
            'to_at' => $params['date']['to'],
        ]);

        $event = $this->repository->save($event);
        $event = $this->service->makeEventResponse($event);

        return $this->success($event, 200);
    }
}
