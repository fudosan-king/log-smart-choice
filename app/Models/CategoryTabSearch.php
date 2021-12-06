<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryTabSearch extends Model
{

    protected $fillable = ['name', 'status'];
    // protected $table = 'category_tab_search';
    public $searchable = ['name'];

    const ACTIVE = 1;
    const INACTIVE = 0;
}