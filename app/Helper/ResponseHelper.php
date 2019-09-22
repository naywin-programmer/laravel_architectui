<?php

namespace App\Helper;

class ResponseHelper
{
    public static function success($data = [], $message = 'success')
    {
        return response()->json([
            'result' => 1,
            'message' => $message,
            'data' => $data
        ]);
    }

    public static function fail($data = [], $message = 'fail')
    {
        return response()->json([
            'result' => 0,
            'message' => $message,
            'data' => $data
        ]);
    }
}
