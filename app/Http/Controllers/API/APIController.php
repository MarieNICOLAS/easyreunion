<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class APIController extends Controller
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($message = null, $code = 500)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
        ], $code);
    }
}
