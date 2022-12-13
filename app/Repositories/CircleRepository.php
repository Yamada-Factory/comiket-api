<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Circle;
use App\Models\CircleLink;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CircleRepository
{
    const DEFAULT_LIMIT = 10;

    public function __construct(private Circle $model)
    {
    }

    public function all(): Collection
    {
        return $this->model::with(['links'])->get();
    }

    public function paginate(array $params = [])
    {
        $page = !empty($params['page']) ? (int)$params['page'] : 1;
        $limit = !empty($params['limit']) ? (int)$params['limit'] : self::DEFAULT_LIMIT;

        return $this->search($params)->paginate($limit, ['*'], 'page', $page);
    }

    public function search(array $params = []): Builder
    {
        $query = $this->model::query()->with('links');

        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        if (!empty($params['author'])) {
            $query->where('author', 'like', '%' . $params['author'] . '%');
        }

        if (!empty($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        return $query;
    }

    public function findById(int $id): ?Circle
    {
        return $this->search(['id' => $id])->first();
    }

    /**
     * 保存
     *
     * @param Circle $circle
     * @return Circle
     */
    public function save(Circle $circle): Circle
    {
        $circle->save();

        return $circle->refresh();
    }

    /**
     * SNSリンク保存
     *
     * @param Circle $circle
     * @param CircleLink $circleLinks[]
     * @return Circle
     */
    public function saveLinks(Circle $circle, array $circleLinks = []): Circle
    {
        $circle->links()->saveMany($circleLinks);

        return $circle->refresh();
    }
}