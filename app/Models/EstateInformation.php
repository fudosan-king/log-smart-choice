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
        if (isset($this->attributes['renovation_media'])){
            return $this->attributes['renovation_media'];
        }
        return null;
    }
    public function getMainPhoto()
    {
        if (isset($this->attributes['estate_main_photo'])){
            return $this->attributes['estate_main_photo'];
        }
        return null;
    }
    public function getBeforAfterPhoto()
    {
        if(isset($this->attributes['estate_befor_photo']) && isset($this->attributes['estate_after_photo'])){
            return array($this->attributes['estate_befor_photo'], $this->attributes['estate_after_photo']);
        }
        return array(null, null);
    }
}
