<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'name_content',
        'tag_content',
        'page_id',
    ];

    public $searchable = ['type', 'name', 'tag_content'];

    const TAG_NAME_CONTENT = [
        'keywords', 'description', 'twitter:card', 'twitter:site', 'robots'
    ];

    const TAG_PROPERTY_CONTENT = [
        'og:locale', 'og:type', 'og:title', 'og:description', 'og:url', 'og:site_name'
    ];
}
