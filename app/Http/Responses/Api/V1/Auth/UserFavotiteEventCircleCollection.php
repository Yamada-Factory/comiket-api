<?php

namespace App\Http\Responses\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFavotiteEventCircleCollection extends JsonResource
{
    public function toArray($request): array
    {
        return UserFavotiteEventCircleResource::collection($this->resource)->toArray($request);
    }
}
