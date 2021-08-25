<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{

    /**
     * getAll
     *
     * @return void
     */
    public function getAll()
    {
        $stations = Station::get();
        if ($stations) {
            return $this->response(200, 'Get list station success', $stations, true);
        }

        return $this->response(422, 'Get list station fail', []);
    }

    public function getTransportCompany() {
        $transportCompanies = Station::select(['tran_company_code', 'tran_company_full_name', 'tran_company_short_name'])
                ->distinct('tran_company_code')
                ->where('count_estates', '>', 0)
                ->groupBy('tran_company_code')
                ->get('tran_company_code', 'tran_company_full_name', 'tran_company_short_name');
        if($transportCompanies) {
            return $this->response(200, 'Success!', $transportCompanies, true);
        }

        return $this->response(422, 'Get list Transport company failed', []);
        
    }

    public function getByTransportCompany(Request $request) {
        $companyCode = $request->get('companyCode') ?? '';
    }
}
