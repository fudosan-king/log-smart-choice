<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model as Model;

class Estates extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';

    protected $collection = 'estates_baibai';

    protected $guarded = [];

    const STATUS_SALE = '公開中';
    const STATUS_STOP = '非公開';
    const STATUS_END = '成約済';
    const LIMIT_ESTATE_NEAR_AREA = 8;
    const LIMIT_ESTATE_RECOMMEND = 16;

    const NUMBER_RECOMMEND_ORDER_BY = 100;


    public function estateInformation() {
        return $this->hasOne(EstateInformation::class, 'estate_id', '_id');
    }

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

    /**
     * Get date created
     *
     * @return false|string
     */
    public function getDateImportedAttribute()
    {
        if (isset($this->attributes['date_imported'])) {
            $dateImported = $this->attributes['date_imported'];
            $date = new DateTime(date('Y-m-d H:i:s', $dateImported->toDateTime()->format('U')));
            return $date->format('Y-m-d H:i:s');
        }
    }

    public function upsertFromFDKData($estateData)
    {
        $estate = self::firstOrNew(['_id' => $estateData->_id]);
        try {
            if (!$estate->exists) {
                $estate->status = self::STATUS_STOP;
                $estate->date_imported = new \MongoDB\BSON\UTCDateTime(strtotime(date('Y-m-d H:i:s')) * 1000);
                $estate->sort_order_recommend = self::NUMBER_RECOMMEND_ORDER_BY;
                $estate['_id'] = $estateData->_id;
                $estate_pass = array(self::STATUS_END);
                if ($estate && in_array($estate->status, $estate_pass)) {
                    return null;
                }

                foreach ($estateData as $key => $value) {
                    $estate->$key = $value;
                }

                if ($estateData && $estateData->trade_status == self::STATUS_STOP) {
                    $estate->status = self::STATUS_STOP;
                }
                $estate->save();
            } elseif ($estate->date_last_modified != $estateData->date_last_modified) {
                $estate->status = self::STATUS_STOP;
                $estate->date_imported = new \MongoDB\BSON\UTCDateTime(strtotime(date('Y-m-d H:i:s')) * 1000);
                $estate->sort_order_recommend = self::NUMBER_RECOMMEND_ORDER_BY;
                $estate['_id'] = $estateData->_id;
                $estate_pass = array(self::STATUS_END);
                if ($estate && in_array($estate->status, $estate_pass)) {
                    return null;
                }

                foreach ($estateData as $key => $value) {
                    $estate->$key = $value;
                }

                if ($estateData && $estateData->trade_status == self::STATUS_STOP) {
                    $estate->status = self::STATUS_STOP;
                }
                $estate->save();
            }
        } catch (Exception $e) {
            Log::error($e);
        }

        return $estate;
    }

    
}
