<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EventRepository
{
    const DEFAULT_LIMIT = 10;

    public function __construct(private Event $model)
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

        if (!empty($params['ids']) && is_array($params['ids'])) {
            $query->whereIn('id', $params['ids']);
        }

        return $query;
    }

    public function findById(int $id): ?Event
    {
        return $this->search(['id' => $id])->first();
    }

    public function getByIds(array $ids = []): Collection
    {
        return $this->search(['ids' => $ids])->get();

    }

    /**
     * 保存
     *
     * @param Event $event
     * @return Event
     */
    public function save(Event $event): Event
    {
        $event->save();

        return $event->refresh();
    }
}
