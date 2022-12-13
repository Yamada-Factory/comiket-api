<?php

namespace App\Http\Controllers\Api\V1\Circle;

use App\Http\Controllers\Controller;
use App\Repositories\CircleRepository;
use Illuminate\Http\Request;

class CircleDeleteController extends Controller
{
    public function __construct(private CircleRepository $circleRepository)
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
        $circle = $this->circleRepository->findById($id);

        if (empty($circle)) {
            return $this->success([], 404);
        }

        $circle->delete();

        return $this->success([], 204);
    }
}
