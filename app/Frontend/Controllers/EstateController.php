<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Estates;
use App\Models\EstateInformation;
use App\Models\Groups;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class EstateController extends Controller
{
    private $linkS3 = 'https://fdk-production.s3-ap-northeast-1.amazonaws.com/';
    /**
     * Search Estate
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $keyword = $request->has('keyword') ? $request->get('keyword') : '';
        $priceFrom = $request->has('price_from') ? $request->get('price_from') : '';
        $priceTo = $request->has('price_to') ? $request->get('price_to') : '';
        $metreSquare = $request->has('metre_square') ? $request->get('metre_square') : '';
        $limit = $request->has('limit') ? intval($request->get('limit')) : 9;
        $page = $request->has('page') ? intval($request->get('page')) : 1;
        $validator = Validator::make($request->all(), [
            'keyword'      => 'max:100',
            'metre_square' => 'numeric',
            'price_from'   => 'numeric',
            'price_to'     => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $estates = Estates::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke',
            'land_space', 'homepage', 'photos');
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
            $getMetreSquare = $this->_getConditionMetreSquare($metreSquare);
            $estates->where('tatemono_menseki', '>=', (int)$getMetreSquare[0]);
            $estates->where('tatemono_menseki', '<=', (int)$getMetreSquare[1]);
        }
        $total = count($estates->paginate()->toArray()['data']);
        $data = $estates->paginate($limit, $page)->toArray();

        if ($data) {
            $data = $this->_getEstateInformation($data['data']);
        }

        return response()->json(['data' => $data, 'total' => $total], 200);
    }

    /**
     * Get Detail Estate & List Estate Recommend
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function detail(Request $request)
    {
        $id = $request->has('id') ? $request->get('id') : '';
        if (!$id){
            return response()->json(['data' => []], 200);
        }
        $estateRecommend = [];
        $listEstateRecommend = [];
        $estate = Estates::select(
            'address', 'price', 'transports', 'custom_field',
            'room_count', 'room_kind', 'tatemono_menseki', 'photos',
            'balcony_space', 'structure', 'room_floor', 'built_date',
            'renovation_done_date', 'house_status', 'delivery_date_type',
            'management_company', 'land_rights', 'trade_type', 'date_last_modified')
            ->where('_id', $id)
            ->get()->toArray();

        if ($estate) {
            $estate = $this->_getEstateInformation($estate);
        }

        if ($estate) {
            return response()->json([
                'data' => [
                    'estate' => $estate
                ],
            ], 200);
        }

        return response()->json(['data' => []], 200);
    }

    /**
     * Get Condition Metre Square
     *
     * @param $metreSquare
     * @return array
     */
    private function _getConditionMetreSquare($metreSquare)
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
            $estateInformation = EstateInformation::where('estate_id', $estates[$key]['_id'])->get()->first();
            $estates[$key]['estate_information'] = $estateInformation;
            $estates[$key]['photo_first'] = $this->_getFirstPhotos($estate);
            $estates[$key]['photos'] = $this->_getPhotosAll($estate);
        }

        return $estates;
    }

    private function _getFirstPhotos($estate){
        if (!isset($estate['photos'])){
            return null;
        }
        $photo = $estate['photos'][0];
        $photo_first = null;
        if ($photo && $photo['photo']) {
            $photo_first = $this->linkS3 . substr($estate['_id'], -2) . '/' . $estate['_id'] . '/' . $photo['photo'] . '.jpeg';
        }
        return $photo_first;
    }

    private function _getPhotosAll($estate){
        if (!isset($estate['photos'])){
            return array();
        }
        $photos_s3 = array();
        $photos = $estate['photos'];
        foreach ($photos as $photo) {
            if ($photo['photo']){
                $photo['photo'] = $this->linkS3 . substr($estate['_id'], -2) . '/' . $estate['_id'] . '/' . $photo['photo'] . '.jpeg';
                array_push($photos_s3, $photo);
            }
        }
        return $photos_s3;
    }
}