<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Model;
use MongoDB\BSON;

class Estates extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'estates_baibai';

    protected $guarded = [];

    const STATUS_NEW = 'NEW';
    const STATUS_IN_SALE = 'IN_SALE';
    const STATUS_UPDATING = 'UPDATING';
    const STATUS_UNDER_CONTRACT = 'UNDER_CONTRACT';
    const STATUS_NOT_SALE = 'NOT_SALE';
    const STATUS_COMPLETED = 'COMPLETED';

    /**
     * Get date created
     *
     * @return false|string
     */
    public function getDateCreatedAttribute()
    {
        if (isset($this->attributes['date_created'])) {
            $date = $this->attributes['date_created']->toDateTime();
            return date('Y-m-d H:i:s', $date->format('U'));
        }
        if (isset($this->attributes['created_at'])) {
            $date = $this->attributes['created_at']->toDateTime();
            return date('Y-m-d H:i:s', $date->format('U'));
        }
    }

    /**
     * Get date last modified
     *
     * @return false|string
     */
    public function getDateLastModifiedAttribute()
    {
        if (isset($this->attributes['date_last_modified'])) {
            $date = $this->attributes['date_last_modified']->toDateTime();
            return date('Y-m-d H:i:s', $date->format('U'));
        }
        if (isset($this->attributes['updated_at'])) {
            $date = $this->attributes['updated_at']->toDateTime();
            return date('Y-m-d H:i:s', $date->format('U'));
        }
    }

    public function upsertFromFDKData($estateData)
    {
        $estate = self::firstOrNew(['_id' => $estateData->_id]);

        if (!$estate->exists) {
            $estate->status = self::STATUS_NEW;
            $estate['_id'] = $estateData->_id;
        }

        foreach ($estateData as $key => $value) {
            $estate->$key = $value;
        }

        try {
            $estate->save();
        } catch (Exception $e) {
            \Log::error($e);
        }

        return $estate;
    }

    public function getStatusText()
    {
        $statusText = [
            self::STATUS_NEW => 'New',
            self::STATUS_IN_SALE => 'In Sale',
            self::STATUS_UPDATING => 'Updating',
            self::STATUS_UNDER_CONTRACT => 'Under Contract',
            self::STATUS_NOT_SALE => 'Not Sale',
            self::STATUS_COMPLETED => 'Completed',
        ];
        return $this->status ? $statusText[$this->status] : '';
    }
}
