<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class Estates extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'estates_baibai';

    /**
     * Get date created
     *
     * @return false|string
     */
    public function getDateCreatedAttribute()
    {
        $date = $this->attributes['date_created']->toDateTime();
        return date('Y-m-d H:i:s', $date->format('U'));
    }

    /**
     * Get date last modified
     *
     * @return false|string
     */
    public function getDateLastModifiedAttribute()
    {
        $date = $this->attributes['date_last_modified']->toDateTime();
        return date('Y-m-d H:i:s', $date->format('U'));
    }

}
