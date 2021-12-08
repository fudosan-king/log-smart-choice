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

    protected $table = 'city1';
    public $searchable = ['name', 'status'];
}