<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PagePostController extends Controller
{

    public function updatePagePost(Request $request) {
        try {
            $pageList = json_encode($request->all());
            $fileNameToStore = 'page_list.' . 'json';
            Storage::put('public/pages/'.$fileNameToStore, $pageList);
            return $this->response(200, 'Update page post success', [], true);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $this->response(422, 'Get list district fail', []);
        }
    }

    public function getPostImage(Request $request) {
        $pagePost = $request->get('page_post', '');
        if ($pagePost) {
            $post = Post::where('page_post', $pagePost)->where('status', Post::STATUS_ACTIVE)->get();
            if ($post) {
                return $this->response('200', 'Get list successful', $post, true);
            }
            return $this->response('422', 'Get list fail', [], false);
        }
        return $this->response('422', 'Page post is required', [], false);
    }

}