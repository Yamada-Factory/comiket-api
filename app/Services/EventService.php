<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use Carbon\Carbon;

class EventService
{
    public function __construct(private EventRepository $eventRepository)
    {
    }

    public function findById(int $id): array
    {
        $event = $this->eventRepository->findById($id);
        if (!$event) {
            return [];
        }

        return $this->makeEventResponse($event);
    }

    /**
     * サークル一覧取得
     *
     * @return array
     */
    public function getEventList(array $params = []): array
    {
        $events = $this->eventRepository->paginate($params);

        $response = [];

        /** @var Event $event */
        foreach($events as $event) {
            $response[] = $this->makeEventResponse($event);
        };

        return $response;
    }

    public function makeEventResponse(Event $event): array
    {
        return [
            'id' => $event->id,
            'name' => $event->name,
            'location' => $this->makeLocationData($event),
            'date' => $this->makeDateData($event),
            'created_at' => $this->formatDateTime($event->created_at),
            'updated_at' => $this->formatDateTime($event->updated_at),
        ];
    }

    private function makeLocationData(Event $event) {
        return [
            'facility' => $event->location_facility,
            'address' => $event->location_address,
            'longitude' => $event->location_longitude,
            'latitude' => $event->location_latitude,
            'googlemap' => $event->location_googlemap,
        ];
    }

    private function makeDateData(Event $event) {
        return [
            'from' => $this->formatDateTime($event->from_at),
            'to' => $this->formatDateTime($event->to_at),
        ];
    }

    private function formatDateTime(Carbon $datetime): string
    {
        return $datetime->format('Y-m-d H:i:s');
    }
}
