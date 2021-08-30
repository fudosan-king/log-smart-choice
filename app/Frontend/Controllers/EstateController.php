<?php


namespace App\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\District;
use App\Models\Estates;
use App\Models\EstateInformation;
use App\Models\EstateGroup;
use App\Models\Station;
use App\Models\WishLists;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EstateController extends Controller
{
    private $linkS3 = 'https://fdk-production.s3-ap-northeast-1.amazonaws.com/';


    protected $selectField;

    public function __construct()
    {
        $this->selectField = [
            'estate_name', 'price', 'address', 
            'tatemono_menseki', 'price', 'transports',
            'renovation_type', 'date_created'
        ];
    }

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
        $email = $request->get('email') ?? '';
        $isSocial = $request->get('isSocial') ?? '';
        $districtCode = $request->get('districtCode') ?? '';
        $companyCode = $request->get('companyCode') ?? '';

        $limit = $request->has('limit') ? intval($request->get('limit')) : 4;
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

        $estates = Estates::select($this->selectField);

        $estates->where('status', Estates::STATUS_SALE);


        if ($districtCode) {
            $districtModel = District::select('name')
                ->where('code', '=', $districtCode)
                ->get()->first();
            if ($districtModel) {
                $address = $districtModel->name;
            }
         }

        // address
        if ($address) {
            $estates->where('address.city', "like", "%" . $address . "%");
        }

        // total price
        if ($priceFrom) {
            $estates->where('price', '>=', $priceFrom);
        }

        if ($priceTo) {
            $estates->where('price', '<=', $priceTo);
        }

        // area
        if ($metreSquare) {
            $getMetreSquare = $this->_getConditionMetreSquare($metreSquare);
            $estates->where('tatemono_menseki', '>=', (int)$getMetreSquare[0]);
            $estates->where('tatemono_menseki', '<=', (int)$getMetreSquare[1]);
        }

        // station name
        
        if ($companyCode) {
            $stationModel = Station::select(['name', 'tran_company_short_name'])
                ->where('tran_company_code', '=', $companyCode)
                ->get()->first();
            if ($stationModel) {
                $estates->where('transports.transport_company', $stationModel->tran_company_short_name);
            }
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
        $estates->orderBy('date_imported', 'desc');

        $lists = $estates->paginate($limit, $page)->toArray();

        if ($lists['data']) {
            $lists['data'] = $this->getEstateInformation($lists['data'], $wishList);
            $lists['lasted_estate'] = $lists['data'][0];
            return response()->json($lists, 200);
        }

        return response()->json($lists, 200);
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
        $estate = Estates::select('estate_name', 'area_bldg_name', 'address', 'price', 'custom_field', 'tatemono_menseki',
            'structure', 'management_fee', 'room_floor', 'total_houses', 'built_date', 'delivery', 'date_last_modified',
            'renovation_done_date', 'house_status', 'delivery', 'land_law_report', 'trade_type', 
             'decor', 'repair_reserve_fee', 'other_fee', 'total_houses', 'built_date', 'motoduke.company', 'constructor',
            'management_company', 'management_scope', 'land_rights', 'latitude', 'longitude',
            'bicycles_park_price', 'usen_fee', 'internet_fee', 'catv_fee', 'community_fee', 'community_fee_type',
            'area_purpose', 'carpark_fee_min', 'carpark_manage_fee', 'homes', 'carpark_fee_min',
            'carpark_manage_fee', 'bike_park', 'bike_park_price', 'bike_park_price_per', 'bicycles_park',
            'bicycles_park_price', 'bicycles_park_price_per', 'ground_floors', 'structure', 'window_direction',
            'has_balcony', 'balcony_space', 'land_rights', 'land_rights_detail', 'land_leashold_type', 'land_leashold_years',
            'land_leashold_months', 'land_leashold_limit', 'leasehold_ratio', 'land_fee_type', 'land_fee', 'land_fee_per',
            'transports', 'room_count', 'room_kind', 'spa_fee', 'rights_fee', 'deposit_fee', 'guarantee_fee_depreciation', 'guarantee_fee',
            'repair_reserve_initial_fee', 'service_rooms', 'superintendent', 'renovation_type'
        )
            ->with('estateInformation')
            ->where('_id', $id)
            ->get();
        $estateAddress = $estate[0]['address'];
        $estateNearAddress = Estates::select('renovation_type', 'price', 'address', 'tatemono_menseki')
            ->where('_id', '!=', $id)
            ->where('address.city', $estateAddress['city'])->take(Estates::LIMIT_ESTATE_NEAR_AREA)->orderBy('date_created', 'desc')
            ->get();

        // if ($estate) {
        //     $estate = $this->getEstateInformation($estate);
        // }

        if ($estate) {
            return $this->response(200, 'Get estate detail success', ['estate' => $estate, 'estateNearAddress' => $estateNearAddress], true);
        }

        return $this->response(422, 'Get estate detail fail', []);
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
     * @param array $announcements
     * @return mixed
     */
    public function getEstateInformation($estates, $wishList = [])
    {
        foreach ($estates as $key => $estate) {
            // force type decor field
            if (isset($estates[$key]['decor'])) {
                $estates[$key]['decor'] = (float)$estates[$key]['decor'];
            }
            $estateInformation = EstateInformation::select(
                'estate_id', 'id_estate_3d', 'estate_main_photo',
                'renovation_media', 'estate_befor_photo', 'estate_after_photo',
                'time_to_join', 'direction', 'company_design',
                'url_map'
            )
                ->where('estate_id', $estates[$key]['_id'])->get()->first();
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

    public function getEstateNear(Request $request) {

        $email = $request->get('email') ?? '';
        $isSocial = $request->get('isSocial') ?? '';
        $idLastEstate = $request->get('estate_id') ?? '';
        $customer = Customer::where('email', $email)->first();
        if ($isSocial) {
            $customer = Customer::where('social_id', $email)->first();
        }
        
        $estateLasted = Estates::select($this->selectField)
            ->where('status', Estates::STATUS_SALE)
            ->orderBy('date_created', 'desc')
            ->first();

        if ($idLastEstate) {
            $estateLasted = Estates::select($this->selectField)
                ->where('_id', $idLastEstate)
                ->first();
        }
        if ($estateLasted) {
            $nearAddress = $estateLasted->address['city'];
            $nearStation = '';
            foreach ($estateLasted->transports as $transport) {
                if ($transport['station_name']) {
                    $nearStation = $transport['station_name'];
                    break;
                }
            }

            // list estate same city/station with last estates
            $estatesNear = Estates::select($this->selectField)
                ->where('status', Estates::STATUS_SALE)
                ->where('_id', '!=', $estateLasted['_id'])
                ->where(function ($query) use ($nearAddress, $nearStation) {
                    $query->orWhere('address.city', $nearAddress);
                    $query->orWhere('transports.station_name', $nearStation);
                })
                ->orderBy('date_created', 'desc')->take(Estates::LIMIT_ESTATE_NEAR_AREA)
                ->get()->toArray();
    
            
            if ($estatesNear) {
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
                $lists = $this->getEstateInformation($estatesNear, $wishList);
    
                return $this->response(200, 'Get near estate success', $lists, true);
            }
        }

        return $this->response(200, 'data not found', []);
    }

    public function getEstatesRecomment(Request $request)
    {
        $email = $request->get('email') ?? '';
        $isSocial = $request->get('isSocial') ?? '';

        $customer = Customer::where('email', $email)->first();
        if ($isSocial) {
            $customer = Customer::where('social_id', $email)->first();
        }

        $estates = [];
        $estatesSort = [];
        $estatesGroup = EstateGroup::select('estate_list')->where('group_code', 'recommended_estate')->get();

        foreach ($estatesGroup as $estateList) {
            foreach ($estateList['estate_list'] as $estate) {
                $estates[] = (string)$estate['estate_id'];
                $estatesSort[(string)$estate['estate_id']] = $estate['sort_order'];
            }
        }

        // list estate same city/station with last estates
        $estateRecommendList = Estates::select($this->selectField)
            ->where('status', Estates::STATUS_SALE)
            ->whereIn('_id', $estates)
            ->take(Estates::LIMIT_ESTATE_RECOMMEND)
            ->get()->toArray();

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

        if ($estateRecommendList) {
            $estateRecommendList = $this->getEstateInformation($estateRecommendList, $wishList);
            foreach ($estateRecommendList as $key => $estateRecommend) {
                $estateRecommendList[$key]['order_sort'] = $estatesSort[$estateRecommend['_id']];
            }
            usort($estateRecommendList, function($a, $b) {
                return $a['order_sort'] <=> $b['order_sort'];
            });
            return $this->response(200, "Get estate recommend success", $estateRecommendList, true);
        }

        return $this->response(422, "Get estate recommend fail", []);
    }
}
