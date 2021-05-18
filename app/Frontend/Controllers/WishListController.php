<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;

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
        $userId = auth()->guard('api')->user()->id;
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
                ['estate_id' => $estateId, 'user_id' => $userId],
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
    public function getWishLists()
    {
        $userId = auth()->guard('api')->user()->id;
        $wishLists = WishLists::select('estate_id')->where('user_id', $userId)->where('is_wishlist', WishLists::ADDED_WISH_LIST)->get();
        $wishListIds = [];
        foreach ($wishLists as $wishList) {
            $wishListIds[] = $wishList->estate_id;
        }

        $estates = Estates::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke', 'room_count', 'room_kind',
            'room_floor', 'land_space', 'homepage', 'photos', 'service_rooms', 'custom_field')
            ->whereIn('_id', $wishListIds)
            ->where('status', Estates::STATUS_SALE)->get()->toArray();

        // return response()->json(['data' => $estates ? $estates : []], 200);
        return $this->response(200, 'Success', $estates, true);
    }
}