<?php

namespace App\Http\Controllers;

use App\Models\PagesSeo;
use App\Models\Tags;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class AppController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function get(Request $request)
    {
//        $ssr = $this->render();
//        return view('app', ['ssr' => $ssr]);
        $pageName = str_replace(env('APP_URL'), '', url()->current());
        $page = 'home';
        if (!empty($pageName)) {
            $pageName = explode('/', $pageName);
            $page = $pageName[1];
        }
        $tags = $this->_getTags($page);
        return view('app', ['tags' => $tags]);
    }

    private function _render()
    {
        $rendererSource = File::get(base_path('node_modules/vue-server-renderer/basic.js'));
        $appSource = File::get(public_path('js/entry-server.js'));
        $v8 = new \V8Js();
        ob_start();
        $v8->executeString('var process = { env: { VUE_ENV: "server", NODE_ENV: "production" }}; this.global = { process: process };');
        $v8->executeString($rendererSource);
//        $v8->executeString($appSource);
        return ob_get_clean();
    }

    /**
     * @param $pageName
     * @return array
     */
    private function _getTags($pageName) {
        $pages = PagesSeo::where('name', $pageName)->where('status', PagesSeo::STATUS_ACTIVATE)->get()->toArray();
        if ($pages) {
            $tags = Tags::where('page_id', $pages[0]['id'])->get();
            if ($tags->isEmpty()) {
                $pageDefault = PagesSeo::where('name', 'default')->where('status', PagesSeo::STATUS_ACTIVATE)->first();
                if ($pageDefault) {
                    $tags = Tags::where('page_id', $pageDefault->id)->get();
                }
            }

            return $tags ? $tags : [];
        }
        return [];
    }
}
