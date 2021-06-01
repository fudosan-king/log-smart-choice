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

    const STATUS_SALE = '販売中';
    const STATUS_STOP = '掲載止め';
    const STATUS_CONTRACT = '請負中';
    const STATUS_END = '終了';
    const LIMIT_ESTATE_NEAR_AREA = 8;

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
            $estate->status = self::STATUS_STOP;
            $estate['_id'] = $estateData->_id;
        }

        $estate_pass = array(self::STATUS_CONTRACT, self::STATUS_END);
        if ($estate && in_array($estate->status, $estate_pass)) {
            return null;
        }

        foreach ($estateData as $key => $value) {
            $estate->$key = $value;
        }

        if ($estateData && $estateData->trade_status == self::STATUS_STOP) {
            $estate->status = self::STATUS_STOP;
        }

        try {
            $estate->save();
        } catch (Exception $e) {
            \Log::error($e);
        }

        return $estate;
    }
}
