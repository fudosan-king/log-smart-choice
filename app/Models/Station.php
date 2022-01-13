<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'created_at', 'updated_at', 'estate_ids'];

    protected $table = 'stations';

    const BEGIN_ESTATE_EXIST = 1;

    const HARD_CODE_STATION_SEARCH = [
        '白金高輪',
        '白金台',
        '泉岳寺',
        '高輪ゲートウェイ',
        '麻布十番',
        '表参道',
        '恵比寿',
        '外苑前',
        '五反田',
        '中目黒',
        '渋谷',
        '広尾',
        '青山一丁目',
        '赤坂見附',
        '赤坂',
        '代々木上原',
        '代々木公園',
        '目黒',
        '三田'
    ];
}
