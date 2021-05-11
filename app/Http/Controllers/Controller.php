<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($code, $messages = [], $data = [], $flag = false)
    {
        $response = [
            "code" => $code,
            'data'       => $data,
        ];
        if ($flag) {
            $response['success'] = ['messages' => [$messages]];
        } else {
            $response['errors'] = ['messages' => [$messages]];
        }
        return response()->json($response, $code);
    }
}
