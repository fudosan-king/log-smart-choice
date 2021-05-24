<?php


namespace App\Frontend\Controllers;


use App\Http\Controllers\Controller;

use App\Models\Estates;
use App\Models\WishLists;
use App\Repositories\EstateRepository;
use App\Repositories\WishListRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class WishListController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    protected $wishListRepository;
    protected $estateRepository;

    public function __construct(
        WishListRepository $wishListRepository,
        EstateRepository $estateRepository
    )
    {
        $this->wishListRepository = $wishListRepository;
        $this->estateRepository = $estateRepository;
    }

    public function upsertWishList(Request $request)
    {
        $estateId = $request->get('estateId');
        $userId = auth()->guard('api')->user()->id;
        $isWish = $request->get('is_wish', 1);

        $wishStatus = [WishLists::ADDED_WISH_LIST, Wishlists::NOT_YET_WISH_LIST];

        // check estateId
        $estateInfo = $this->estateRepository->getEstateInfo($estateId);
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
        $wishLists = $this->wishListRepository->getWishList($userId);
        $wishListIds = [];
        foreach ($wishLists as $wishList) {
            $wishListIds[] = $wishList->estate_id;
        }
        $estates = $this->estateRepository->getEstateWishList($wishListIds);
        return $this->response(200, 'Success', $estates, true);
    }
}