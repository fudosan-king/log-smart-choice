<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagesSeo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $table = 'pages_seo';

    const STATUS_ACTIVATE = 1;
    const STATUS_DEACTIVATE = 2;
    const STATUS_LIST = [
        'Deactivate',
        'Activate',
    ];

    /**
     * @return mixed|string
     */
    public function getStatusAttribute()
    {
        if ($this->attributes) {
            $status = $this->attributes['status'];
            return array_key_exists($status, PagesSeo::STATUS_LIST) ? PagesSeo::STATUS_LIST[$status] : '';
        }
    }

    public function setStatusAttribute($value) {
        if (in_array($value, PagesSeo::STATUS_LIST)) {
            $status = array_keys(PagesSeo::STATUS_LIST, $value);
            $this->attributes['status'] = $status[0];
        }
    }
}
