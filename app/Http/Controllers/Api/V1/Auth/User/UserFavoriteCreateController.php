<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\V1\Auth\UserFavotiteCircleResource;
use App\Models\UserFavoriteCircle;
use App\Repositories\UserFavoriteCircleRepository;
use Illuminate\Http\Request;

class UserFavoriteCreateController extends Controller
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

        $userFavoriteCircle = $this->repository->search($queryParams)->latest()->first();
        if ($userFavoriteCircle) {
            return $this->success([
                'error' => 'circle_id=' . $params['circle_id'] . ' is alredy registerd.'
            ], 409);
        }

        $userFavoriteCircle = new UserFavoriteCircle([
            'user_id' => $user->id,
            'circle_id' => $params['circle_id'],
            'color' => $params['color'] ?? UserFavoriteCircle::DEFAULT_COLOR,
        ]);

        $userFavoriteCircle = $this->repository->save($userFavoriteCircle);

        return $this->success((new UserFavotiteCircleResource($userFavoriteCircle))->toArray($request), 200);
    }
}
