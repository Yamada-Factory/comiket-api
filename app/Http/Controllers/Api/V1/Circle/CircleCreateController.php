<?php

namespace App\Http\Controllers\Api\V1\Circle;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Circle\CircleRegisterRequest;
use App\Models\Circle;
use App\Models\CircleLink;
use App\Repositories\CircleRepository;
use App\Services\CircleService;
use Illuminate\Http\Request;

class CircleCreateController extends Controller
{
    public function __construct(private CircleRepository $circleRepository, private CircleService $circleService)
    {
    }

    /**
     * サークル作成.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $params = $request->all();

        $circle = new Circle([
            'name' => $params['name'],
            'author' => $params['author'],
            'circle_ms_id' => $params['circle_ms_id'],
        ]);

        $circleLinkModelArray = [];
        foreach ($params['links'] as $type => $url) {
            $circleLinkModelArray[] = new CircleLink([
                'type' => $type,
                'url' => $url,
            ]);
        }

        $circle = $this->circleRepository->save($circle);
        $circle = $this->circleRepository->saveLinks($circle, $circleLinkModelArray);

        $circle = $this->circleService->findById($circle->id);

        return $this->success($circle, 200);
    }
}
