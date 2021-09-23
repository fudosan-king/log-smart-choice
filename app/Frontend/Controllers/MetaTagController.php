<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Estates;
use App\Models\PagesSeo;
use App\Models\Station;

class MetaTagController extends Controller
{

    public function getMetaTags(Request $request)
    {
        /**
         * type 
         * estateID
         * districtCode
         * companyCode
         * 
         */
        // if($companyCode) {
        //     return $this->response(200, 'Success!', $companyCode, true);
        // }

        // return $this->response(422, 'Get list Transport company failed', []);
        $estateID = $request->get('estateID') ?? '';
        $estate = Estates::select(
            'estate_name',
            'address',
            'tatemono_menseki',
            'structure',
            'room_floor',
            'price'
        )
            ->where('_id', $estateID)
            ->get()->first()->toArray();

        // $pageSEO = PagesSeo::select('*')
        //     ->get()->first();

        $resultData = array(
            'pageSEOInfo' => '',
            'dataInfo' => $estate
        );

        return response()->json($resultData, 200);
    }

    public function getMetaCodeSearch(Request $request)
    {
        $searchCode = $request->get('search_code') ?? '';
        $district = District::select('name')
            ->where('status', District::STATUS_ACTIVATE)
            ->where('code', $searchCode)->first();
        if ($district) {
            return $this->response(200, 'Get Disctrict Success', $district, true);
        } else {
            $station = Station::select('name')->where('tran_company_code', $searchCode)->first();
            if ($station) {
                return $this->response(200, 'Get Station Success', $station, true);
            }
        }
        return $this->response(422, 'Search Code Error', [], false);
    }
}
