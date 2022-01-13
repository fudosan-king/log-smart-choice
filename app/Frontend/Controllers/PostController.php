<?php

namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TagPost;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPosts(Request $request) {
        $pagePost = $request->get('page_post', '');
        if ($pagePost) {
            $posts = Post::with('postImages')->where('status', Post::STATUS_ACTIVE)->get()->toArray();
            $string = ["'", "\\r", "\\n"];
            if ($posts) {
                foreach ($posts as $key => $post) {
                    $tagPostId = explode(',', $post['tag_post_id']);
                    $tagPosts = TagPost::select('name')->where('status', TagPost::STATUS_ACTIVE)->whereIn('id', $tagPostId)->get()->toArray();
                    $posts[$key]['tag_posts'] = $tagPosts;
                    $posts[$key]['content'] = str_replace($string, "", $posts[$key]['content']);
                }
                return $this->response('200', 'Get list successful', $posts, true);
            }
            return $this->response('200', 'Get list fail', [], true);
        }
        return $this->response('422', 'Page post is required', [], false);
    }

    public function getPost(Request $request) {
        $post = Post::where('status', Post::STATUS_ACTIVE)->find($request->get('post_id'));
        if ($post) {
            return $this->response('200', 'Get post successful', $post, true);
        }
        return $this->response('422', 'Get post fail', [], false);
    }
}