<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PagePostController extends Controller
{

    public function updatePagePost(Request $request) {
        try {
            $pageList = json_encode($request->all());
            $fileNameToStore = 'page_list' . '-' . date('Y-m-d') . '.' . 'json';
            Storage::put('public/pages/pages/'.$fileNameToStore, $pageList);
            return $this->response(200, 'Update page post success', [], true);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Get list district fail', []);
        }
    }

}