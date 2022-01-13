<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    const STATUS_ACTIVATE = 1;
    const STATUS_DEACTIVATE = 0;
    const INIT_CONTAIN_ESTATE = 0;
    const BEGIN_ESTATE_EXIST = 1;
    const HARD_CODE_DISTRICT_SEARCH = [
        '港区',
        '中央区',
        '千代田区',
        '渋谷区',
        '新宿区',
        '文京区',
        '目黒区',
        '品川区',
        '世田谷区'
    ];

    protected $fillable = [
        'code',
        'name',
        'status',
        'city_id',
    ];

    protected $table = 'district';
    public $searchable = ['code', 'name', 'status', 'city_id'];
    protected $hidden = ['code', 'status', 'estate_ids', 'created_at', 'updated_at'];
}
