<?php

namespace App\Http\Responses\Api\V1\Circle;

use App\Models\Circle;
use App\Models\CircleLink;
use App\Traits\ResponseFormatTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CircleResource extends JsonResource
{
    use ResponseFormatTrait;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'circle_ms_id' => $this->circle_ms_id,
            'name' => $this->name,
            'author' => $this->author,
            'links' => $this->makeCircleLinkArray($this->getLinks()),
            'created_at' => $this->formatDateTime($this->created_at),
            'updated_at' => $this->formatDateTime($this->updated_at),
        ];
    }

    private function makeCircleLinkArray(Collection $links): array
    {
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
}
