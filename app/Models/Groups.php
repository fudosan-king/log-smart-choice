<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use App\Models\Estate;

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
    public function getEstates()
    {
        if (!$this->_estateCollection) {
            $estateIds = (array_column($this->estate_list, 'estate_id'));
            $this->_estateCollection = Estate::whereIn('_id', $estateIds);
        }
        return $this->_estateCollection;
    }
}
