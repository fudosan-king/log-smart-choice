<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use App\Models\Estates;
use App\Models\Station;
use Illuminate\Http\Response;

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

        $resultData = array(
            'pageSEOInfo' => '',
            'dataInfo' => $estate
        );

        return response()->json($resultData, Response::HTTP_OK);
    }

    public function getMetaCodeSearch(Request $request)
    {
        $searchCode = $request->get('search_code') ?? '';
        $district = District::select('name')
            ->where('status', District::STATUS_ACTIVATE)
            ->where('code', $searchCode)->first();
        if ($district) {
            return $this->response(Response::HTTP_OK, 'Get Disctrict Success', $district, true);
        } else {
            $station = Station::select('tran_company_short_name')->where('tran_company_code', $searchCode)->first();
            $data = ['name' => $station->tran_company_short_name];
            if ($station) {
                return $this->response(Response::HTTP_OK, 'Get Station Success', $data, true);
            }
        }
        return $this->response(Response::HTTP_NOT_FOUND, 'Search Code Error', [], false);
    }
}
