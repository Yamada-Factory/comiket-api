<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Circle;
use App\Models\CircleLink;
use App\Repositories\CircleRepository;
use App\Repositories\EventRepository;
use Carbon\Carbon;

class CircleEventService
{
    public function __construct(private CircleRepository $circleRepository, private EventRepository $eventRepository)
    {
    }

    private function makeCircleLinkArray(Circle $circle): array
    {
        $links = $circle->getLinks();

        $response = [];
        /** @var CircleLink $link */
        foreach ($links as $link) {
            $response[] = [
                'type' => $link->type,
                'url' => $link->url,
            ];
        }

        return $response;
    }

    private function formatDateTime(Carbon $datetime): string
    {
        return $datetime->format('Y-m-d H:i:s');
    }

    public function makeEventCircleResponse(Circle $circle): array
    {
        return [
            'id' => $circle->id,
            'circle_ms_id' => $circle->circle_ms_id,
            'name' => $circle->name,
            'author' => $circle->author,
            'links' => $this->makeCircleLinkArray($circle),
            'created_at' => $this->formatDateTime($circle->created_at),
            'updated_at' => $this->formatDateTime($circle->updated_at),
        ];
    }

    public function makeEventCircleInfoReponse(array $circleEventInfo)
    {
        return [
            'circle_id' => $circleEventInfo['circle_id'],
            'event_id' => $circleEventInfo['event_id'],
            'circle_event_id' => $circleEventInfo['id'],
            'hall' => $circleEventInfo['hall'],
            'day' => $circleEventInfo['day'],
            'block' => $circleEventInfo['block'],
            'space' => $circleEventInfo['space'],
            'genre' => $circleEventInfo['genre'],
            'description' => $circleEventInfo['description'],
            'images' => $circleEventInfo['images'],
            'other' => $circleEventInfo['other'],
        ];
    }

    public function makeEventCircleInfoArray(Circle $circle): array
    {
        return array_map(fn($info) => $this->makeEventCircleInfoReponse($info), $circle->getEvnetCircle()->toArray());
    }
}
