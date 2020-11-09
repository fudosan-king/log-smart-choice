<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class EstateLogs extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'estates_logs';
}
