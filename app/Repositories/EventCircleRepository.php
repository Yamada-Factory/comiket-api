<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\EventCircle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EventCircleRepository
{
    const DEFAULT_LIMIT = 50;

    public function __construct(private EventCircle $model)
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

        if (!empty($params['name'])) {
            $query->where('name', 'like', '%' . $params['name'] . '%');
        }

        if (!empty($params['id'])) {
            $query->where('id', '=', $params['id']);
        }

        if (!empty($params['event_id'])) {
            $query->where('event_id', '=', $params['event_id']);
        }

        if (!empty($params['circle_id'])) {
            $query->where('circle_id', '=', $params['circle_id']);
        }

        if (!empty($params['circle_ids']) && is_array($params['circle_ids'])) {
            $query->whereIn('circle_id', $params['circle_ids']);
        }

        if (!empty($params['hall'])) {
            $query->where('hall', '=', $params['hall']);
        }

        if (!empty($params['day'])) {
            $query->where('day', '=', $params['day']);
        }

        if (!empty($params['block'])) {
            $query->where('block', '=', $params['block']);
        }

        if (!empty($params['space'])) {
            $query->where('space', '=', $params['space']);
        }

        if (!empty($params['genre'])) {
            $query->where('genre', '=', $params['genre']);
        }

        $page = !empty($params['page']) ? (int)$params['page'] : 1;
        $limit = !empty($params['limit']) ? (int)$params['limit'] : self::DEFAULT_LIMIT;

        $query->paginate($limit, ['*'], 'page', $page);

        return $query;
    }

    public function findById(int $id): ?EventCircle
    {
        return $this->search(['id' => $id])->first();
    }

    public function getByEventId(array $params = []): Collection
    {
        return $this->search($params)->get();
    }

    public function getDistinctByColumn(string $column, array $params = []): ?Collection
    {
        $params['limit'] = 9999999;
        return $this->search($params)->orderBy($column, 'asc')->select($column)->get()->unique($column)->values();
    }

    /**
     * 保存
     *
     * @param EventCircle $event
     * @return EventCircle
     */
    public function save(EventCircle $event): EventCircle
    {
        $event->save();

        return $event->refresh();
    }
}
