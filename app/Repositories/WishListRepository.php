<?php


namespace App\Repositories;

use App\Models\WishLists;

class WishListRepository extends BaseRepository
{


    public function getModel()
    {
        return WishLists::class;
    }
    public function  getWishList($userId){
        return $this->model::select('estate_id')->where('user_id', $userId)->where('is_wishlist', WishLists::ADDED_WISH_LIST)->get();
    }
}
