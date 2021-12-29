<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function districts() {
        return $this->hasMany(District::class, 'city_id', 'id')->where('count_estates', '>', 0)
        ->where('status', District::STATUS_ACTIVATE)
        ->orderBy('name');
    }
}