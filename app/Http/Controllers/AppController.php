<?php

namespace App\Http\Controllers;

use App\Models\PagesSeo;
use App\Models\Tags;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function get(Request $request)
    {
        $pageName = str_replace(env('APP_URL'), '', url()->current());
        $page = 'home';
        if (!empty($pageName)) {
            $pageName = explode('/', $pageName);
            $page = [];
            if (preg_match('/^[a-zA-Z0-9-_]+$/', $pageName[1])) {
                $page = $pageName[1];
            }
        }

        $tags = $this->_getTags($page);
        return view('app', ['tags' => $tags]);
    }

    /**
     * @param $pageName
     * @return array
     */
    private function _getTags($pageName) {
        if ($pageName) {
            $pages = PagesSeo::where('name', $pageName)->where('status', PagesSeo::STATUS_ACTIVATE)->get()->toArray();
            $pageDefault = PagesSeo::where('name', 'default')->where('status', PagesSeo::STATUS_ACTIVATE)->first();
            $tags = Tags::where('page_id', $pageDefault->id)->get();
            if ($pages) {
                $tags = Tags::where('page_id', $pages[0]['id'])->get();
            }
            return $tags;
        }
        return [];
    }
}
