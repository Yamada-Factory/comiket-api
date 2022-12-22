<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\V1\Auth\UserFavotiteCircleResource;
use App\Repositories\UserFavoriteCircleRepository;
use Illuminate\Http\Request;

class UserFavoriteGetController extends Controller
{
    public function __construct(private UserFavoriteCircleRepository $userFavoriteCircleRepository)
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

        $params = [
            'user_id' => $user->id,
            'circle_id' => $id,
        ];

        $userFavoriteCircles = $this->userFavoriteCircleRepository->search($params)->latest()->first();

        return $this->success((new UserFavotiteCircleResource($userFavoriteCircles))->toArray($request), 200);
    }
}
