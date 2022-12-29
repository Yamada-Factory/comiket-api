<?php

namespace App\Http\Responses\Api\V1\Auth;

use App\Http\Responses\Api\V1\Circle\CircleResource;
use App\Http\Responses\Api\V1\Event\EventCollection;
use App\Http\Responses\Api\V1\Event\EventResource;
use App\Models\UserFavoriteCircle;
use App\Models\UserFavoriteEventCircle;
use App\Traits\ResponseFormatTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavotiteEventCircleResource extends JsonResource
{
    use ResponseFormatTrait;

    public function toArray($request): array
    {
        $favoriteCircle = $this->getCircle();
        /** @var Collection $events */
        $events = $this->event;

        $circle = (new CircleResource($favoriteCircle))->toArray($request);
        $circle['circle_id'] = $circle['id'];
        $circle['color'] = $this->color;

        $circleEvents = $events->map(function ($event) use ($request) {
            /** @var UserFavoriteEventCircle $event */
            $eventModel = $event->getEvent();
            $eventInfo = (new EventResource($eventModel))->toArray($request);

            $circleModel = $event->circle()->getResults();
            $eventInfo['info'] = $circleModel->evnetCircle()->where('event_id', '=', $eventModel->id)->first()->toArray();
            $eventInfo['priority'] = $event->priority;
            $eventInfo['e-commerce_flag'] = $event['e-commerce_flag'];
            $eventInfo['comment'] = $event->comment;
            $eventInfo['price'] = $event->price ?? 0;

            return $eventInfo;
        });
        $event = $circleEvents->toArray()[0] ?? [];
        $event['event_name'] = $event['name'];
        unset($event['name']);

        return array_merge($circle, $event);
    }
}
