<?php

namespace App\Api\V1\Responses;

use Illuminate\Http\JsonResponse;

class Response
{
    /**
     * @param array $data
     * @param array $message
     * @param bool $result
     * @param int $statusCode
     * @param array $errors
     * @return JsonResponse
     */
    public static function get($data = [], $message = [], $result = true, $statusCode = 200, $errors = [])
    {
        return response()
            ->json([
                'result' => $result,
                'status_code' => $statusCode,
                'message' => $message,
                'errors' => $errors,
                'data' => $data,
            ]);
    }

    /**
     * @param array $message
     * @param int $statusCode
     * @param array $errors
     * @param array $data
     * @return JsonResponse
     */
    public static function error($message = [], $statusCode = 200, $errors = [], $data = [])
    {
        return self::get($data, $message, false, $statusCode, $errors);
    }
}