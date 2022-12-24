<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\UserFavoriteCircle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserFavoriteCircleRepository
{
    const DEFAULT_LIMIT = 50;

    public function __construct(private UserFavoriteCircle $model)
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

        if (!empty($params['circle_id'])) {
            $query->where('circle_id', '=', $params['circle_id']);
        }

        if (!empty($params['user_id'])) {
            $query->where('user_id', '=', $params['user_id']);
        }
        $page = !empty($params['page']) ? (int)$params['page'] : 1;
        $limit = !empty($params['limit']) ? (int)$params['limit'] : self::DEFAULT_LIMIT;

        $query->paginate($limit, ['*'], 'page', $page);

        return $query;
    }

    public function findById(int $id): ?UserFavoriteCircle
    {
        return $this->search(['id' => $id])->first();
    }

    /**
     * 保存
     *
     * @param UserFavoriteCircle $model
     * @return UserFavoriteCircle
     */
    public function save(UserFavoriteCircle $model): UserFavoriteCircle
    {
        $model->save();

        return $model->refresh();
    }
}
