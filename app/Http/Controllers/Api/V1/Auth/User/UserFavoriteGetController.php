<?php

namespace App\Http\Controllers\Api\V1\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Responses\Api\V1\Auth\UserFavotiteCircleResourceItem;
use App\Repositories\UserFavoriteCircleRepository;
use App\Services\UserFavoriteEventCircleService;
use Illuminate\Http\Request;

class UserFavoriteGetController extends Controller
{
    public function __construct(private UserFavoriteCircleRepository $userFavoriteCircleRepository, private UserFavoriteEventCircleService $userFavoriteEventCircleService)
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

        $events = $this->userFavoriteEventCircleService->getEventCirlces($user, null, $params)->first();

        return (new UserFavotiteCircleResourceItem($events))->toArray($request);
    }
}
