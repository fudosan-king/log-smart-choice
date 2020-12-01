<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Estate;
use App\Models\EstateInformation;
use App\Models\Groups;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class EstateController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->get('keyword') : '';
        $priceFrom = $request->has('price_from') ? $request->get('price_from') : '';
        $priceTo = $request->has('price_to') ? $request->get('price_to') : '';
        $metreSquare = $request->has('metre_square') ? $request->get('metre_square') : '';
        $limit = 10;
        $validator = Validator::make($request->all(), [
            'keyword'      => 'max:100',
            'metre_square' => 'numeric',
            'price_from'   => 'numeric',
            'price_to'     => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $estates = Estate::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke',
            'land_space', 'homepage');
        if ($keyword) {
            $estates->where('estate_name', "like", "%" . $keyword . "%");
        }

        if ($priceFrom) {
            $estates->where('price', '>=', $priceFrom);
        }

        if ($priceTo) {
            $estates->where('price', '<=', $priceTo);
        }

        if ($metreSquare) {
            $getMetreSquare = $this->_getConditionMetreSquard($metreSquare);
            $estates->where('tatemono_menseki', '>=', (int)$getMetreSquare[0]);
            $estates->where('tatemono_menseki', '<=', (int)$getMetreSquare[1]);
        }

        $data = $estates->paginate($limit)->toArray();

        if ($data) {
            $data = $this->_getEstateInformation($data['data']);
        }

        return view('frontend.estate.search', ['data' => $data]);
    }

    /**
     * Get Detail Estate & List Estate Recommend
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail($id)
    {
        $estateRecommend = [];
        $listEstateRecommend = [];
        $estate = Estate::select(['address', 'allow_kyakutuke', 'area_bldg_name', 'balcony_space'])
            ->where('_id', $id)
            ->get()->toArray();

        $estateInfo = EstateInformation::where('estate_id', $id)->get()->toArray();

        // get group
        $groupEstate = Groups::where('group_code', Groups::ESTATE_RECOMMEND)->get();
        if ($groupEstate) {
            $estateRecommend = array_column($groupEstate[0]->estate_list, 'estate_id');
        }

        // get estate recommend
        $getEstatesRecommend = Estate::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke',
            'land_space', 'homepage')->whereIn('_id', $estateRecommend)->get()->toArray();

        if ($getEstatesRecommend) {
            $listEstateRecommend = $this->_getEstateInformation($getEstatesRecommend);
        }

        if ($estate) {
            if ($estateInfo) {
                $estate[0]['information'] = $estateInfo;
            }
            return view('frontend.estate.detail', ['estateDetail' => $estate, 'estateRecommend' => $listEstateRecommend]);
        }
        return view('frontend.estate.detail', ['data' => []]);
    }

    /**
     * @param $metreSquare
     * @return array
     */
    private function _getConditionMetreSquard($metreSquare)
    {
        $lengthOfString = strlen($metreSquare);
        $numberFrom = '';
        $numberTo = '';
        for ($i = 1; $i < $lengthOfString; $i++) {
            $numberFrom .= '0';
            $numberTo .= '9';
        }

        $firstPartNumber = substr($metreSquare, 0, 1);

        $fromMetreSquare = $firstPartNumber . $numberFrom;
        $toMetreSquare = $firstPartNumber . $numberTo;
        return [$fromMetreSquare, $toMetreSquare];
    }

    /**
     * Get Estate Information
     *
     * @param $estates
     * @return mixed
     */
    private function _getEstateInformation($estates)
    {
        foreach ($estates as $key => $estate) {
            $estateInformation = EstateInformation::where('estate_id', $estates[$key]['_id'])->get()->toArray();
            $estates[$key]['estate_information'] = $estateInformation;
        }

        return $estates;
    }
}