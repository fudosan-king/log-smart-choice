<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estates;
use App\Models\EstateInformation;
use App\Models\WishLists;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        $address = $request->get('address') ?? '';
        $priceFrom = $request->get('price_from') ?? '';
        $priceTo = $request->get('price_to') ?? '';
        $metreSquare = $request->get('metre_square') ?? '';
        $roomTypeFrom = $request->get('room_type_from') ?? '';
        $roomTypeTo = $request->get('room_type_to') ?? '';
        $station = $request->get('station') ?? '';
        $email = $request->get('email') ?? '';
        $isSocial = $request->get('isSocial') ?? '';

        $limit = $request->has('limit') ? intval($request->get('limit')) : 9;
        $page = $request->has('page') ? intval($request->get('page')) : 1;
        $validator = Validator::make($request->all(), [
            'keyword'      => 'max:100',
            'metre_square' => 'numeric',
            'price_from'   => 'numeric',
            'price_to'     => 'numeric',
            'totalPrice'   => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $estates = Estates::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke', 'room_count', 'room_kind',
            'room_floor', 'land_space', 'homepage', 'photos', 'service_rooms',
            'custom_field', 'decor', 'total_price', 'room_type', 'transports');

        $estates->where('status', Estates::STATUS_SALE);

        // address
        if ($address) {
            $estates->where('address.city', "like", "%" . $address . "%");
        }

        // total price
        if ($priceFrom) {
            $estates->where('total_price', '>=', $priceFrom);
        }

        if ($priceTo) {
            $estates->where('total_price', '<=', $priceTo);
        }

        // area
        if ($metreSquare) {
            $getMetreSquare = $this->_getConditionMetreSquare($metreSquare);
            $estates->where('tatemono_menseki', '>=', (int)$getMetreSquare[0]);
            $estates->where('tatemono_menseki', '<=', (int)$getMetreSquare[1]);
        }

        // station name
        if ($station) {
            $estates->where('transports.station_name', $station);
        }

        // room kind & room count
        $roomTypeFrom = $this->_getRoomType($roomTypeFrom);
        $roomTypeTo = $this->_getRoomType($roomTypeTo);
        $roomKind = [];

        if ($roomTypeTo) {
            array_push($roomKind, $roomTypeTo[0]);
        }

        if ($roomTypeFrom) {
            array_push($roomKind, $roomTypeFrom[0]);
            $estates->whereIn('room_count', $roomKind);
            $estates->whereIn('room_kind', [$roomTypeFrom[1], $roomTypeFrom[2]]);
        }

        $customer = Customer::where('email', $email)->first();
        if ($isSocial) {
            $customer = Customer::where('social_id', $email)->first();
        }

        $wishList = [];
        if ($customer) {
            $wishListForCustomer = WishLists::select('estate_id')
                ->where('user_id', $customer->id)
                ->where('is_wishlist', WishLists::ADDED_WISH_LIST)
                ->get()->toArray();
            if (!empty($wishListForCustomer)) {
                foreach ($wishListForCustomer as $value) {
                    $wishList[] = $value['estate_id'];
                }
            }
        }

        $total = count($estates->paginate()->toArray()['data']);
        $data = $estates->paginate($limit, $page)->toArray();
        if ($data) {
            $data = $this->_getEstateInformation($data['data'], $wishList);
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
        if (!$id) {
            return response()->json(['data' => []], 200);
        }
        $estateRecommend = [];
        $listEstateRecommend = [];
        $estate = Estates::select(
            'estate_name',
            'homepage',
            'address',
            'price',
            'transports',
            'custom_field',
            'service_rooms',
            'room_count',
            'room_kind',
            'tatemono_menseki',
            'photos',
            'balcony_space',
            'structure',
            'room_floor',
            'total_houses',
            'built_date',
            'delivery',
            'renovation_done_date',
            'house_status',
            'delivery_date_type',
            'management_company',
            'management_scope',
            'land_rights',
            'trade_type',
            'date_last_modified',
            'estate_equipment',
            'estate_flooring',
            'decor',
            'total_price'
        )
            ->where('_id', $id)
            ->where('status', '=', Estates::STATUS_SALE)
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
     * @param $roomType
     * @return array
     */
    private function _getRoomType($roomType): array
    {
        $room = explode('/', $roomType);
        if (count($room) != 3) {
            return $room = [];
        }

        return [(int)substr($room[0], 0, 1), strtoupper($room[1]), strtoupper($room[2])];
    }

    /**
     * @param $estates
     * @param array $wishList
     * @return mixed
     */
    private function _getEstateInformation($estates, $wishList = [])
    {
        foreach ($estates as $key => $estate) {
            // force type decor field
            if (isset($estates[$key]['decor'])) {
                $estates[$key]['decor'] = (float)$estates[$key]['decor'];
            }
            $estateInformation = EstateInformation::where('estate_id', $estates[$key]['_id'])->get()->first();
            $estates[$key]['estate_information'] = $estateInformation;
            if ($estateInformation && $estateInformation->estate_main_photo) {
                $photo_first = $estateInformation->estate_main_photo;
            } else {
                $photo_first = $this->_getFirstPhotos($estate);
            }

            if (!empty($wishList)) {
                if (in_array($estate['_id'], $wishList)) {
                    $estates[$key]['is_wish'] = 1;
                }
            }

            $estates[$key]['photo_first'] = $photo_first;
            $estates[$key]['photos'] = $this->_getPhotosAll($estate);
        }
        return $estates;
    }

    private function _getFirstPhotos($estate)
    {
        if (!isset($estate['photos'])) {
            return null;
        }
        $photo = $estate['photos'][0];
        $photo_first = null;
        if ($photo && $photo['photo']) {
            $photo_first = $this->linkS3 . substr($estate['_id'], -2) . '/' . $estate['_id'] . '/' . $photo['photo'] . '.jpeg';
        }
        return $photo_first;
    }

    private function _getPhotosAll($estate)
    {
        if (!isset($estate['photos'])) {
            return array();
        }
        $photos_s3 = array();
        $photos = $estate['photos'];
        foreach ($photos as $photo) {
            if ($photo['photo']) {
                $photo['photo'] = $this->linkS3 . substr($estate['_id'], -2) . '/' . $estate['_id'] . '/' . $photo['photo'] . '.jpeg';
                array_push($photos_s3, $photo);
            }
        }
        return $photos_s3;
    }
    
    /**
     * updateEstateId3D
     *
     * @param  mixed $request
     * @return void
     */
    public function updateEstateId3D(Request $request)
    {

        $user = Auth::user();

        if ($user->role3d == Customer::ROLE_3D_CUSTOMER) {
            return $this->response(401, 'Permission denied', []);
        }

        $id = $request->get('id');
        $idEstate3D = $request->get('id_estate_3d');


        $rules = [
            'id' => 'required|string',
            'id_estate_3d' => 'required|string'
        ];

        $validator = Validator::make($request->all(), $rules, []);

        if ($validator->fails()) {
            return $this->response(422, $validator->errors(), []);
        }

        $estate = Estates::where('_id', $id)->where('status', Estates::STATUS_SALE)->first();
        if (!$estate) {
            return $this->response(422, 'Estate not found', []);
        }

        try {
            $estate->id_estate_3d = $idEstate3D;
            $estate->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $this->response(200, 'Update id estate 3d success', []);
    }
}
