<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * response
     *
     * @param  mixed $code
     * @param  mixed $messages
     * @param  mixed $data
     * @param  mixed $flag : true is success and false is error
     * @return void
     */
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
