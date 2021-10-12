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
    const LIMIT_ESTATE_RECOMMEND = 40;

    const NUMBER_RECOMMEND_ORDER_BY = 100;
    const SEND_ANNOUNCEMENT = 1;
    const NOT_SEND_ANNOUNCEMENT = 0;
    const LIMIT_ESTATE_ANNOUNCEMENT = 15;
    const RENOVATION_SQUARE_MIN = 80;
    const RENOVATION_SQUARE_MAX = 200;
    const RENOVATION_COST = [
        '80' => 13357964,
        '81' => 13682764,
        '82' => 13767664,
        '83' => 13852564,
        '84' => 13986564,
        '85' => 14071464,
        '86' => 14156364,
        '87' => 14290364,
        '88' => 14375264,
        '89' => 14460164,
        '90' => 14766064,
        '91' => 15219764,
        '92' => 15303064,
        '93' => 15435364,
        '94' => 15518664,
        '95' => 15601964,
        '96' => 15734364,
        '97' => 15817664,
        '98' => 15900964,
        '99' => 16033364,
        '100' => 16116664,
        '101' => 16284564,
        '102' => 16419364,
        '103' => 16505064,
        '104' => 16590764,
        '105' => 16725464,
        '106' => 16811164,
        '107' => 16725464,
        '108' => 17031664,
        '109' => 17117364,
        '110' => 17203064,
        '111' => 17599864,
        '112' => 17687064,
        '113' => 17774264,
        '114' => 17910564,
        '115' => 17997764,
        '116' => 18084964,
        '117' => 18221164,
        '118' => 18308364,
        '119' => 18395564,
        '120' => 18531864,
        '121' => 19476864,
        '122' => 19570364,
        '123' => 19712964,
        '124' => 19806464,
        '125' => 19899964,
        '126' => 20042564,
        '127' => 20136064,
        '128' => 20229564,
        '129' => 20372164,
        '130' => 20465664,
        '131' => 20864264,
        '132' => 21008364,
        '133' => 21103464,
        '134' => 21198564,
        '135' => 21342764,
        '136' => 21437864,
        '137' => 21532964,
        '138' => 21677164,
        '139' => 21772264,
        '140' => 21867364,
        '141' => 22344664,
        '142' => 22441264,
        '143' => 22537864,
        '144' => 22683464,
        '145' => 22780064,
        '146' => 22876664,
        '147' => 23022364,
        '148' => 23118964,
        '149' => 23215564,
        '150' => 23361264,
        '151' => 23915864,
        '152' => 24014864,
        '153' => 24162964,
        '154' => 24261964,
        '155' => 24360964,
        '156' => 24508964,
        '157' => 24607964,
        '158' => 24706964,
        '159' => 24855064,
        '160' => 24954064,
        '161' => 25441964,
        '162' => 25592364,
        '163' => 25693664,
        '164' => 25794964,
        '165' => 25945364,
        '166' => 26046664,
        '167' => 26147964,
        '168' => 26298364,
        '169' => 26399664,
        '170' => 26500964,
        '171' => 26746764,
        '172' => 26848064,
        '173' => 26949364,
        '174' => 27099764,
        '175' => 27201064,
        '176' => 27302364,
        '177' => 27452764,
        '178' => 27554064,
        '179' => 27655364,
        '180' => 27805764,
        '181' => 27925664,
        '182' => 28026964,
        '183' => 28177264,
        '184' => 28278564,
        '185' => 28379864,
        '186' => 28530264,
        '187' => 28631564,
        '188' => 28732864,
        '189' => 28883264,
        '190' => 28984564,
        '191' => 29412164,
        '192' => 29562564,
        '193' => 29663864,
        '194' => 29765164,
        '195' => 29915464,
        '196' => 30016764,
        '197' => 30118064,
        '198' => 30268464,
        '199' => 30369764,
        '200' => 30471064
    ];

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
        $estateDataId = (string) new \MongoDB\BSON\ObjectId($estateData->_id);
        $estate = self::firstOrNew(['_id' => $estateData->_id]);
        $dateModifyFDK = $estateData->date_last_modified;
        $stations = [];
        if ($estate->transports) {
            foreach($estate->transports as $transport) {
                if (!in_array($transport['transport_company'], $stations)) {
                    array_push($stations, $transport['transport_company']);
                }
            }
        }
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');
        try {
            if (strtotime($startDate) <= $dateModifyFDK->toDateTime()->format('U') &&
            $dateModifyFDK->toDateTime()->format('U') <= strtotime($endDate)) {
                if (!$estate->exists) {
                    $estate->status = self::STATUS_STOP;
                    $estate->date_imported = new \MongoDB\BSON\UTCDateTime(strtotime(date('Y-m-d H:i:s')) * 1000);
                    $estate->sort_order_recommend = self::NUMBER_RECOMMEND_ORDER_BY;
                    $estate['_id'] = $estateData->_id;
                    $estate->is_send_announcement = self::NOT_SEND_ANNOUNCEMENT;
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
                    $this->increaseDecreaseEstateInDistrict(json_decode(json_encode($estateData->address), true), false, $estateData->_id);
                    $this->increaseDecreaseEstateInStation($stations, false, $estateData->_id);
                    $estateInfo = EstateInformation::where('estate_id', $estateDataId)->first();
                    if ($estateInfo) {
                        $estateInfo->date_lasted_modified_in_lsc = '';
                        $estateInfo->user_lasted_modified_in_lsc = 0;
                        $estateInfo->save();
                    }
                } elseif (strtotime($estate->date_last_modified) != $dateModifyFDK->toDateTime()->format('U')) {
                    $this->increaseDecreaseEstateInDistrict(json_decode(json_encode($estateData->address), true), false, $estateData->_id);
                    $this->increaseDecreaseEstateInStation($stations, false, $estateData->_id);
                    
                    $estate->status = self::STATUS_STOP;
                    $estate->is_send_announcement = self::NOT_SEND_ANNOUNCEMENT;
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

                    // if ($estateData && $estateData->trade_status == self::STATUS_STOP) {
                    //     $estate->status = self::STATUS_STOP;
                    // }
                    $estate->save();
    
                    $estateInfo = EstateInformation::where('estate_id', $estateDataId)->first();
                    if ($estateInfo) {
                        $estateInfo->date_lasted_modified_in_lsc = '';
                        $estateInfo->user_lasted_modified_in_lsc = 0;
                        $estateInfo->save();
                    }
                }
            }
        } catch (Exception $e) {
            Log::error($e);
        }

        return $estate;
    }

    public function increaseDecreaseEstateInDistrict($districtEstate, $flag, $estateId)
    {
        $district = District::where('name', $districtEstate)->first();
        if ($district) {
            $estateIds = [];
            if ($district->estate_ids) {
                $estateIds = explode(',', $district->estate_ids);
            }

            if ($flag && !in_array($estateId, $estateIds)) {
                $district->count_estates = $district->count_estates + 1;
                array_push($estateIds, $estateId);
                $district->estate_ids = implode(',', $estateIds);
            } else {
                if ( $district->count_estates != 0 && in_array($estateId, $estateIds)) {
                    $district->count_estates = $district->count_estates - 1;
                    $key = array_search($estateId, $estateIds);
                    unset($estateIds[$key]);
                    $district->estate_ids = implode(',', $estateIds);
                }
            }
            $district->save();
        }
    }
    
    public function increaseDecreaseEstateInStation($stationsEstate, $flag, $estateId)
    {
        $stations = Station::whereIn('tran_company_short_name', $stationsEstate)->get();
        if ($stations) {
            foreach ($stations as $key => $station) {
                $estateIds = [];
                if ($station->estate_ids) {
                    $estateIds = explode(',', $station->estate_ids);
                }
    
                if ($flag && !in_array($estateId, $estateIds)) {
                    $station->count_estates = $station->count_estates + 1;
                    array_push($estateIds, $estateId);
                    $station->estate_ids = implode(',', $estateIds);
                } else {
                    if ( $station->count_estates != 0 && in_array($estateId, $estateIds)) {
                        $station->count_estates = $station->count_estates - 1;
                        $key = array_search($estateId, $estateIds);
                        unset($estateIds[$key]);
                        $station->estate_ids = implode(',', $estateIds);
                    }
                }
                $station->save();
            }
        }
    }
}
