<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'region_code',
        'tran_company_code',
        'station_code',
        'tran_company_full_name',
        'tran_company_short_name',
        'old_name',
        'number_change',
        'value_change'
    ];

    const STATION_PARENT_1 = [172, 196, 171, 184, 199, 161, 102, 197, 198, 164, 159];
    const STATION_PARENT_2 = [341, 342, 344, 345, 346, 347, 348, 349, 350];
    const STATION_PARENT_3 = [283, 284, 281];
    const STATION_PARENT_4 = [270, 261, 262];
    const STATION_PARENT_5 = [321, 324, 325, 327, 322, 323, 326, ];
    const STATION_PARENT_6 = [351, 352, 353, 358, 354, 359];
    const STATION_PARENT_7 = [304, 301];
    const STATION_PARENT_8 = [252, 251];
    const STATION_PARENT_9 = [331, 332];
    const STATION_PARENT_10 = [311];
    const STATION_PARENT_11 = [394];
    const STATION_PARENT_12 = [355];
    const STATION_PARENT_13 = [357];
    const STATION_PARENT_14 = [246];
    const STATION_PARENT_15 = [250];

//    protected $tableName = 'stations';
}
