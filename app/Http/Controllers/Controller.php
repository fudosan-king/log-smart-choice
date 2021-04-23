<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($message = '', $module, $errorCode, $errorMessages = []) {
        $response = [
                "message" => $message,
                'errors'  => [
                    $module => $errorMessages,
                ]
            ];
        return response()->json($response, $errorCode);
    }
}
