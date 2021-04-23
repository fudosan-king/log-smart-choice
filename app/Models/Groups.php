<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use App\Models\Estates;

class Groups extends Model
{
    use HasFactory;

    protected $_estateCollection;

    protected $connection = 'mongodb';

    protected $collection = 'groups_estate';

    const ESTATE_RECOMMEND = 'recommended_estate';

    /**
     * Get Estates of this groups
     *
     * @return  Illuminate\Database\Eloquent\Collection;
     */
    public static function getEstates()
    {
        if (!$self->_estateCollection) {
            $estateIds = (array_column($self->estate_list, 'estate_id'));
            $self->_estateCollection = Estates::whereIn('_id', $estateIds);
        }
        return $self->_estateCollection;
    }
}
