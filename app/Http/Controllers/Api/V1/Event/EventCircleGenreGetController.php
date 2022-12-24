<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\Http\Controllers\Controller;
use App\Repositories\EventCircleRepository;
use Illuminate\Http\Request;

class EventCircleGenreGetController extends Controller
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
        $genres = $this->repository->getGenre($params);

        $response = $genres->map(function ($genre) {
            return $genre->genre;
        });

        return $this->success($response->toArray(), 200);
    }
}
