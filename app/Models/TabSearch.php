<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TabSearch extends Model
{

    protected $fillable = ['name', 'status', 'category_tab_search_id'];
    protected $table = 'tab_search';
    public $searchable = ['name'];

    const ACTIVE = 1;
    const INACTIVE = 0;
}