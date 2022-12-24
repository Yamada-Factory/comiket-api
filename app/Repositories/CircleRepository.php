<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Circle;
use App\Models\CircleLink;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CircleRepository
{
    const DEFAULT_LIMIT = 50;

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

        if (!empty($params['circle_ms_id'])) {
            $query->where('circle_ms_id', '=', $params['circle_ms_id']);
        }

        if (!empty($params['links'])) {
            $query->whereHas('links', function (Builder $query) use ($params) {
                $query->where('circle_link.url', '=', $params['links']);
            });
        }

        if (!empty($params['ids']) && is_array($params['ids'])) {
            $query->whereIn('id', $params['ids']);
        }

        return $query;
    }

    public function findById(int $id): ?Circle
    {
        return $this->search(['id' => $id])->first();
    }

    public function getByIds(array $ids = []): Collection
    {
        return $this->search(['ids' => $ids])->get();

    }

    public function findByCirclMsId(int $id): ?Circle
    {
        return $this->search(['circle_ms_id' => $id])->first();
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
