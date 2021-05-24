<?php


namespace App\Repositories;

use App\Models\Estates;

class EstateRepository extends BaseRepository
{


    public function getModel()
    {
        return Estates::class;
    }
    public function getEstateWishList($wishListIds){
        $estates = $this->model::select('estate_name', 'price', 'balcony_space',
            'address', 'tatemono_menseki', 'motoduke', 'room_count', 'room_kind',
            'room_floor', 'land_space', 'homepage', 'photos', 'service_rooms', 'custom_field')
            ->whereIn('_id', $wishListIds)
            ->where('status', Estates::STATUS_SALE)->get()->toArray();
        return $estates;
    }
    public function getEstateInfo($estateId)
    {
        return $this->model::where('_id', $estateId)->where('status', Estates::STATUS_SALE)->get();
    }
}
