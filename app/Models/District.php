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

    protected $fillable = [
        'code',
        'name',
        'status',
        'city_id',
    ];

    protected $table = 'district1';
    public $searchable = ['code', 'name', 'status', 'city_id'];
}