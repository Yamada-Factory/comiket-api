<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param array $data
     * @param int $status
     * @param array $headers
     * @param int $option
     * @return JsonResponse
     */
    protected function success(
        array $data = [],
        int $status = 200,
        array $headers = [],
        int $option = 0
    ): JsonResponse
    {
        return response()->json($data, $status, $headers, $option);
    }
}
