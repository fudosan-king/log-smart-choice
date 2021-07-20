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

//    protected $tableName = 'stations';
}
