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

    public function getByTransportCompany(Request $request)
    {
        $companyCode = $request->get('companyCode') ?? '';
    }

    public function getParentStation()
    {
        $stationParents = [
            'JR' => Station::STATION_PARENT_1, '東京メトロ' => Station::STATION_PARENT_2, '西武鉄道' => Station::STATION_PARENT_3,
            '東武鉄道' => Station::STATION_PARENT_4, '東急電鉄' => Station::STATION_PARENT_5, '都営地下鉄' => Station::STATION_PARENT_6,
            '京王電鉄' => Station::STATION_PARENT_7, '京成電鉄' => Station::STATION_PARENT_8, '京浜急行電鉄' => Station::STATION_PARENT_9,
            '小田急電鉄' => Station::STATION_PARENT_10, '東京臨海高速鉄道' => Station::STATION_PARENT_11, '東京モノレール' => Station::STATION_PARENT_12,
            'ゆりかもめ' => Station::STATION_PARENT_13, 'つくばエクスプレス' => Station::STATION_PARENT_14, '成田スカイアクセス' => Station::STATION_PARENT_15,
        ];
        $stationList = [];
        foreach ($stationParents as $key => $value) {
            $stations = Station::select('tran_company_short_name', 'parent_flag', 'tran_company_code', 'old_name')
                ->whereIn('tran_company_code', $value)
                ->groupBy('tran_company_full_name')
                ->get();

            foreach ($stations as $index => $station) {
                $stationChild = $this->getChildStation($station->tran_company_code);
                $stations[$index]['child'] = $stationChild;
            }
            $stationList[$key] = $stations;
        }

        if ($stationList) {
            return $this->response(200, 'Get list station success', $stationList, true);
        }

        return $this->response(422, 'Get list station fail', []);
    }

    private function getChildStation($tranCompanyCode)
    {
        $stations = Station::select('name', 'old_name')
            ->where('tran_company_code', $tranCompanyCode)
            ->get();
        return $stations ?: [];
   }
}
