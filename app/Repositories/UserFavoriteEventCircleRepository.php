<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserFavoriteCircle;
use App\Models\UserFavoriteEventCircle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class UserFavoriteEventCircleRepository
{
    const DEFAULT_LIMIT = 50;

    public function __construct(private UserFavoriteEventCircle $model)
    {
    }

    public function all(): Collection
    {
        return $this->search()->get();
    }

    public function paginate(array $params = [])
    {
        $page = !empty($params['page']) ? (int)$params['page'] : 1;
        $limit = !empty($params['limit']) ? (int)$params['limit'] : self::DEFAULT_LIMIT;

        return $this->search($params)->paginate($limit, ['*'], 'page', $page);
    }

    public function search(array $params = []): Builder
    {
        $query = $this->model::query();

        if (!empty($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        if (!empty($params['favorite_circle_id'])) {
            $query->where('favorite_circle_id', '=', $params['favorite_circle_id']);
        }

        if (!empty($params['user_id'])) {
            $query->where('user_id', '=', $params['user_id']);
        }

        if (!empty($params['event_id'])) {
            $query->where('event_id', '=', $params['event_id']);
        }

        if (!empty($params['e-commerce_flag'])) {
            $query->where('e-commerce_flag', '=', (bool) $params['e-commerce_flag']);
        }

        if (!empty($params['sort_by_priority'])) {
            $query->orderBy('priority', $params['sort_by_priority']);
        }

        if ($params['is_auth_user'] ?? false) {
            $userId = Auth::user()->id;
            $query->where('user_id', '=', $userId);
        }

        return $query;
    }

    public function findById(int $id): ?UserFavoriteEventCircle
    {
        return $this->search(['id' => $id])->first();
    }

    public function getByUserId(array $params = []): Collection
    {
        return $this->search($params)->get();
    }

    /**
     * 保存
     *
     * @param UserFavoriteEventCircle $model
     * @return UserFavoriteEventCircle
     */
    public function save(UserFavoriteEventCircle $model): UserFavoriteEventCircle
    {
        $model->save();

        return $model->refresh();
    }
}
