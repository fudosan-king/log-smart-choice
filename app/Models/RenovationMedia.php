<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class RenovationMedia extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'renovation_media';
}
