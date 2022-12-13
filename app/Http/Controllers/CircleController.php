<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\Circle\CircleRegisterRequest;
use App\Models\Circle;
use App\Models\CircleLink;
use App\Repositories\CircleRepository;
use App\Services\CircleService;
use Illuminate\Http\Request;

class CircleController extends Controller
{
    //

    public function __construct(private CircleRepository $circleRepository, private CircleService $circleService)
    {

    }

    public function index(Request $request)
    {
        $filter = $request->all();

        $circles = $this->circleService->getCircleList($filter);

        // // return $circles;


        $circle = new Circle([
            'name' => 'テストサークル_1',
            'author' => 'テスト作家',
            'circle_ms_id' => 13013043
        ]);

        $circleLinks = [
            'twitter_1' => 'https://twitter.com/xxxxxx1',
            'twitter_2' => 'https://twitter.com/xxxxxx2',
            'twitter_3' => 'https://twitter.com/xxxxxx3',
            'pixiv_1' => 'https://pixiv.com/xxxxxx1',
            'website_1' => 'https://example.com/',
        ];

        $circleLinkModelArray = [];

        foreach ($circleLinks as $type => $url) {
            $circleLinkModelArray[] = new CircleLink([
                // 'circle_id' => $circle->id,
                'type' => $type,
                'url' => $url,
            ]);
        }

        $circle = $this->circleRepository->save($circle);
        $circle = $this->circleRepository->saveLinks($circle, $circleLinkModelArray);

        // return $circle->getLinks();


        // return [
        //     'ok' => 'success'
        // ];

        return view('page.circle.index', compact('circles'));
    }

    public function register(CircleRegisterRequest $request)
    {
        $request->validated();
    }
}
