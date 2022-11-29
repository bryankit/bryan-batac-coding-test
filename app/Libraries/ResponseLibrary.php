<?php

namespace App\Libraries;

use Illuminate\Http\JsonResponse;

class ResponseLibrary
{
    /**
     * SuccessResponse
     * @param null   $data
     * @param string $message
     * @return array
     */
    public static function SuccessResponse($data = null, $message = ''): array
    {
        return [
            'code' => 201,
            'message' => $message,
            'data' => $data
        ];
    }
    /**
     * ErrorResponse
     * @param int    $code
     * @param null   $data
     * @param string $message
     * @return array
     */
    public static function ErrorResponse($message = '', $data = null, $code = 500): array
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
    }

    /**
     * Get Response
     * @param array $result
     * @return array
     */
    public static function GetResponse(array $result) : JsonResponse
    {
        return response()->json(
            [
                'message' => $result['message'],
                'data'    => $result['data']
            ], $result['code']);
    }
}
