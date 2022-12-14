<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Circle;
use App\Models\CircleLink;
use App\Repositories\CircleRepository;
use Carbon\Carbon;

class CircleService
{
    public function __construct(private CircleRepository $circleRepository)
    {
    }

    public function findById(int $id): array
    {
        $circle = $this->circleRepository->findById($id);
        if (!$circle) {
            return [];
        }

        return $this->makeCircleResponse($circle);
    }

    /**
     * サークル一覧取得
     *
     * @return array
     */
    public function getCircleList(array $params = []): array
    {
        $circles = $this->circleRepository->paginate($params);

        $response = [];

        /** @var Circle $circle */
        foreach($circles as $circle) {
            $response[] = $this->makeCircleResponse($circle);
        };

        return $response;
    }

    public function makeCircleResponse(Circle $circle): array
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
}
