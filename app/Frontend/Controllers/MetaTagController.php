<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estates;
use App\Models\PagesSeo;

class MetaTagController extends Controller
{

    public function getMetaTags(Request $request) {
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
        $estate = Estates::select('estate_name', 'address', 'tatemono_menseki',
            'structure','room_floor', 'total_price'
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
}
