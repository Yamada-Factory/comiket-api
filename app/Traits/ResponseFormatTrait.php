<?php

declare(strict_types=1);

namespace App\Traits;

use Carbon\Carbon;

trait ResponseFormatTrait
{
    public function formatDateTime(Carbon $datetime): string
    {
        return $datetime->format('Y-m-d H:i:s');
    }
}