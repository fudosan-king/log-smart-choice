<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\TabSearch;
use Illuminate\Http\Response;

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
            return $this->response(Response::HTTP_OK, 'Get list station success', $tabList, true);
        }

        return $this->response(Response::HTTP_BAD_REQUEST, 'Get list station fail', []);
    }
}