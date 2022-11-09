<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class response extends Controller
{
    public function response($status = 'success', $message = 'success', $result = true, $code = 200)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'result' => $result,
        ], $code);
    }
}
