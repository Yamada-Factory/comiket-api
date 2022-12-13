<?php

namespace App\Http\Controllers\Api\V1\Circle;

use App\Http\Controllers\Controller;
use App\Services\CircleService;
use Illuminate\Http\Request;

class CircleGetController extends Controller
{
    public function __construct(private CircleService $circleService)
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
        $circle = $this->circleService->findById($id);

        return $this->success($circle, 200);
    }
}
