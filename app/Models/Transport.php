<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{

    protected $fillable = ['name', 'status'];
    protected $table = 'transports';

    const ACTIVE = 1;
    const INACTIVE = 0;
}