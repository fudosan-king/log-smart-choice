<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishLists extends Model
{

    use HasFactory;

    protected $fillable = [
        'estate_id', 'user_id', 'is_wishlist'
    ];

    protected $tableName = 'wish_lists';

    const ADDED_WISH_LIST = 1;
    const NOT_YET_WISH_LIST = 0;
}