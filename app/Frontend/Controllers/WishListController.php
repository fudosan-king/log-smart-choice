<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Estates;
use App\Models\WishLists;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class WishListController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upsertWishList(Request $request)
    {
        $estateId = $request->get('estateId');
        $customerId = auth()->guard('api')->user()->id;
        $isWish = $request->get('is_wish', 1);

        $wishStatus = [WishLists::ADDED_WISH_LIST, Wishlists::NOT_YET_WISH_LIST];

        // check estateId
        $estateInfo = Estates::where('_id', $estateId)->where('status', Estates::STATUS_SALE)->get();
        if ($estateInfo->isEmpty()) {
            return $this->response(400, 'Estate invalid', []);
        }

        // check status wish
        if (!in_array($isWish, $wishStatus)) {
            return $this->response(400, 'Wish status invalid', []);
        }

        try {
            WishLists::updateOrCreate(
                ['estate_id' => $estateId, 'user_id' => $customerId],
                ['is_wishlist' => $isWish]
            );
            return $this->response(200, 'Success', [], true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
        return $this->response(400, 'Fail', []);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getWishLists(Request $request)
    {
        $limit = WishLists::ITEM_PER_PAGE;
        $page = $request->get('page');
        $customerId = auth()->guard('api')->user()->id;
        $customerCheck = Customer::select('status')->where('id', $customerId)->first();
        if ($customerCheck->status == Customer::DEACTIVE) {
            return $this->response(401, __('customer.customer_fail'));
        }
        $wishLists = WishLists::select('estate_id')->where('user_id', $customerId)->where('is_wishlist', WishLists::ADDED_WISH_LIST)->get();
        $estateIds = [];
        foreach ($wishLists as $wishList) {
            $estateIds[] = $wishList->estate_id;
        }

        $estates = Estates::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke', 'room_count', 'room_kind',
            'room_floor', 'renovation_type')
            ->whereIn('_id', $estateIds)
            ->where('status', Estates::STATUS_SALE)->paginate($limit, $page);

        $wishList = [];
        $estateController = new EstateController();
        $estateInfo = $estateController->getEstateInformation($estates, $estateIds);
        // $estateInfo = $estates;

        return $this->response(200, 'Success', $estateInfo, true);
    }
}