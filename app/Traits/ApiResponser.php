<?php

namespace App\Traits;

trait ApiResponser
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            'status'=> 'Success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function error($message = null, $code = 500)
    {
        return response()->json([
            'status'=>'Error',
            'message' => $message,
        ], $code);
    }
}
