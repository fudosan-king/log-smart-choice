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
        '表参道駅', '乃木坂駅', '目黒駅', '中目黒駅',
        '代官山駅', '恵比寿駅', '渋谷駅', '三軒茶屋駅',
        '広尾駅', '麻布十番駅', '六本木駅', '品川駅',
        '田町駅', '五反田駅', '大崎駅'
    ];
}
