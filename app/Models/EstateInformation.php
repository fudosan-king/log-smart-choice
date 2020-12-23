<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class EstateInformation extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'estates_information';

    /**
     * Get renovation_media
     *
     * @return dict
     */
    public function getRenovationMedia()
    {
        return $this->attributes['renovation_media'];
    }
}
