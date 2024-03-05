<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondWithJson(array $content, int $status = 200, array $headers = [], int $options = 0): JsonResponse
    {
        $response = [
            'data' => $content,
        ];

        return response()->json($response, $status, $headers, $options);
    }

    protected function respondWithJsonError(
        Throwable $e,
        array $headers = [],
        int $options = 0
    ): JsonResponse {
        $code = $e->getCode() ?? Response::HTTP_BAD_REQUEST;
        $message = $e->getMessage() ?? 'An error occurred!';
        $status = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        $content = [
            'message' => $message,
            'errors' => [
                'code' => $code,
            ],
        ];

        return response()->json($content, $status, $headers, $options);
    }
}
