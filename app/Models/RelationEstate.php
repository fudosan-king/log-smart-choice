<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use PhpParser\Node\Expr\FuncCall;

class RelationEstate extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'relation_estate';
}
