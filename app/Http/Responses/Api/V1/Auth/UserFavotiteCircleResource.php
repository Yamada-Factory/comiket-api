<?php

namespace App\Http\Responses\Api\V1\Auth;

use App\Traits\ResponseFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavotiteCircleResource extends JsonResource
{
    use ResponseFormatTrait;

    public function toArray($request): array
    {
        $circle = $this->getCircle();

        return [
            'id' => $circle->id,
            'name' => $circle->name,
            'author' => $circle->author,
            'links' => $circle->getLinks(),
            'color' => $this->color,
            'event' => $circle->getEvnetCircle(),
        ];
    }
}
