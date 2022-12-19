<?php

namespace App\Http\Controllers\Api\V1\Circle;

use App\Http\Controllers\Controller;
use App\Services\CircleService;
use Illuminate\Http\Request;

class CircleGetListController extends Controller
{
    public function __construct(private CircleService $circleService)
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
        $circles = $this->circleService->getCircleList($request->all());

        return $this->success($circles, 200);
    }
}
