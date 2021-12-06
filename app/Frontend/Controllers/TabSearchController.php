<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\TabSearch;

class TabSearchController extends Controller
{
    /**
     * getAll
     *
     * @return void
     */
    public function list()
    {
        $tabList = TabSearch::select('id', 'name')->where('status', TabSearch::ACTIVE)->get();
        if ($tabList) {
            return $this->response(200, 'Get list station success', $tabList, true);
        }

        return $this->response(422, 'Get list station fail', []);
    }
}