<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\V1\Auth\UserFavotiteCircleResource;
use App\Models\UserFavoriteCircle;
use App\Repositories\UserFavoriteCircleRepository;
use Illuminate\Http\Request;

class UserFavoriteUpdateController extends Controller
{
    public function __construct(private UserFavoriteCircleRepository $repository)
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
        $queryParams = array_filter([
            'user_id' => $user->id,
            'circle_id' => $params['circle_id'],
        ]);

        /** @var UserFavoriteCircle $userFavoriteCircle */
        $userFavoriteCircle = $this->repository->search($queryParams)->latest()->first();
        if (!$userFavoriteCircle) {
            return $this->success([], 404);
        }

        $userFavoriteCircle->fill([
            'color' => $params['color'],
        ]);

        $userFavoriteCircle = $this->repository->save($userFavoriteCircle);

        return $this->success((new UserFavotiteCircleResource($userFavoriteCircle))->toArray($request), 200);
    }
}
