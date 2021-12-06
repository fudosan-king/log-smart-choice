<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{

    protected $fillable = ['name', 'status'];
    protected $table = 'transports';
    protected $hidden = ['id', 'status', 'created_at', 'updated_at'];

    const ACTIVE = 1;
    const INACTIVE = 0;

    public function stations() {
        return $this->hasMany(Station::class, 'transport_id', 'id')->where('count_estates', '>', 0);
    }
}