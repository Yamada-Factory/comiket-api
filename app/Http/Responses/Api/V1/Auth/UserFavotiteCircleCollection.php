<?php

namespace App\Http\Responses\Api\V1\Auth;

// use App\Traits\ResourceFormatter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavotiteCircleCollection extends JsonResource
{
    public function toArray($request): array
    {
        return UserFavotiteCircleResource::collection($this->resource)->toArray($request);
    }
}
