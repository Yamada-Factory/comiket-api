<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\V1\Auth\UserFavotiteEventCircleCollection;
use App\Repositories\UserFavoriteEventCircleRepository;
use App\Services\UserFavoriteEventCircleService;
use Illuminate\Http\Request;

class UserFavoriteCircleEventGetController extends Controller
{
    public function __construct(private UserFavoriteEventCircleRepository $userFavoriteEventCircleRepository, private UserFavoriteEventCircleService $userFavoriteEventCircleService)
    {
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, int $id)
    {
        $user = $request->user();

        $userEventFavoriteCircles = $this->userFavoriteEventCircleService->getEventCirlces($user, $id, $request->all());

        return $this->success((new UserFavotiteEventCircleCollection($userEventFavoriteCircles))->toArray($request), 200);
    }
}
