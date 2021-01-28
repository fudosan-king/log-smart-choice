<?php

namespace App\Http\Traits;

use App\Models\PagesSeo;

trait PagesSeoList {

    /**
     * @return array
     */
    protected function getPagesSeo() {
        $page = PagesSeo::where('status', PagesSeo::STATUS_ACTIVATE)->get()->toArray();
        $count = count($page);
        $pageList = [];
        $allPage = [];
        for ($i = 0; $i < $count; $i++) {
            $pageList = array_merge($pageList, [$page[$i]['id'] => $page[$i]['name']]);
            $allPage[$page[$i]['id']] = $pageList[$i];
        }
        return $allPage;
    }
}