<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    use HasFactory;

    const STATUS_ACTIVE = 1;
    const STATUS_DEACTIVE = 0;

    protected $fillable = [
        'name',
        'status'
    ];

    protected $hidden = ['status', 'created_at', 'updated_at'];

    protected $table = 'city';
    public $searchable = ['name', 'status'];

    public function districts()
    {
        return $this->hasMany(District::class, 'city_id', 'id')->select(DB::raw("romaji_name, (romaji_name = '-') boolDash, (romaji_name = '0') boolZero, (romaji_name+0 > 0) boolNum, id, name, city_id"))->where('count_estates', '>', 0)
            ->where('status', District::STATUS_ACTIVATE)
            ->orderByRaw('boolDash DESC, boolZero DESC, boolNum DESC, romaji_name+0, romaji_name');
    }
}
