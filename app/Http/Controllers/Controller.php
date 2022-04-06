<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($code, $data)
    {
        return response()->json([
                'code' => $code,
                'data' => $data,
            ])->header('Content-Type', 'Application/json');
    }

    public function error($code, $message)
    {
        return response()->json([
                'code' => $code,
                'message' => $message,
            ])->header('Content-Type', 'Application/json');
    }

    public function done($code, $message)
    {
        return response()->json([
                'code' => $code,
                'message' => $message,
            ])->header('Content-Type', 'Application/json');
    }

}
