<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\V1\Auth\UserFavotiteCircleCollection;
use App\Repositories\UserFavoriteCircleRepository;
use Illuminate\Http\Request;

class UserFavoriteListController extends Controller
{
    public function __construct(private UserFavoriteCircleRepository $userFavoriteCircleRepository)
    {
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $params = $request->all();
        $params['user_id'] = $user->id;

        $userFavoriteCircles = $this->userFavoriteCircleRepository->search($params)->get();

        return $this->success((new UserFavotiteCircleCollection($userFavoriteCircles))->toArray($request), 200);
    }
}
