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
        '表参道･青山', '麻布･広尾', '渋谷･恵比寿･中目黒', '目黒･白金高輪',
        '下北沢･三軒茶屋', '東横線･目黒線', '駒沢･二子玉川', '代々木公園',
        '井の頭線', '神楽坂', '品川・田町', '銀座・築地', '豊洲清澄・門前仲町',
        '皇居西側', '中央線', '千駄ヶ谷･四ッ谷', '西新宿', '東新宿･早稲田',
        'その他'
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
