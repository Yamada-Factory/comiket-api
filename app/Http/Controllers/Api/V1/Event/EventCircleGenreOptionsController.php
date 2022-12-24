<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Repositories\EventCircleRepository;
use Illuminate\Http\Request;

class EventCircleGenreOptionsController extends Controller
{
    public function __construct(private EventCircleRepository $repository)
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
        $params = $request->all();
        $column = $params['column'];
        $uniqueCollection = $this->repository->getDistinctByColumn($column, $params);

        $response = $uniqueCollection->map(function ($unique) use ($column) {
            return $unique->$column;
        });

        return $this->success($response->toArray(), 200);
    }
}
