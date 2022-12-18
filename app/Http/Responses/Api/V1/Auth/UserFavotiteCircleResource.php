<?php

namespace App\Http\Responses\Api\V1\Auth;

// use App\Traits\ResourceFormatter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavotiteCircleResource extends JsonResource
{
    public function toArray($request): array
    {
        $cielc = $this->getCircle();

        return [
            'id' => $cielc->id,
            'name' => $cielc->name,
            'author' => $cielc->author,
            'color' => $this->color,
        ];
    }
}
