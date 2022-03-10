<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class PagePostController extends Controller
{

    public function updatePagePost(Request $request) {
        try {
            $pageList = json_encode($request->all());
            $fileNameToStore = 'page_list.' . 'json';
            Storage::put('public/pages/'.$fileNameToStore, $pageList);
            return $this->response(Response::HTTP_OK, 'Update page post success', [], true);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->response(Response::HTTP_BAD_REQUEST, 'Get list district fail', []);
        }
    }

    public function getPostImage(Request $request) {
        $pagePost = $request->get('page_post', '');
        if ($pagePost) {
            $post = Post::where('page_post', $pagePost)->where('status', Post::STATUS_ACTIVE)->get();
            if ($post) {
                return $this->response(Response::HTTP_OK, 'Get list successful', $post, true);
            }
            return $this->response(Response::HTTP_BAD_REQUEST, 'Get list fail', [], false);
        }
        return $this->response(Response::HTTP_BAD_REQUEST, 'Page post is required', [], false);
    }

}