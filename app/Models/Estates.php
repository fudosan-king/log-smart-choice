<?php

namespace App\Models;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
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
    const DECOR = 'リノベ済物件';
    const NOT_DECOR = 'カスタム可能物件';
    const BROKERAGE_FEE_ENABLE = 1;
    const BROKERAGE_FEE_DISABLE = 0;
    const RENOVATION_COST = [
        '80' => 1336,
        '81' => 1368,
        '82' => 1377,
        '83' => 1385,
        '84' => 1399,
        '85' => 1407,
        '86' => 1416,
        '87' => 1429,
        '88' => 1438,
        '89' => 1446,
        '90' => 1477,
        '91' => 1522,
        '92' => 1530,
        '93' => 1544,
        '94' => 1552,
        '95' => 1560,
        '96' => 1573,
        '97' => 1582,
        '98' => 1590,
        '99' => 1603,
        '100' => 1612,
        '101' => 1628,
        '102' => 1642,
        '103' => 1651,
        '104' => 1659,
        '105' => 1673,
        '106' => 1681,
        '107' => 1673,
        '108' => 1703,
        '109' => 1712,
        '110' => 1720,
        '111' => 1760,
        '112' => 1769,
        '113' => 1777,
        '114' => 1791,
        '115' => 1800,
        '116' => 1808,
        '117' => 1822,
        '118' => 1831,
        '119' => 1840,
        '120' => 1853,
        '121' => 1948,
        '122' => 1957,
        '123' => 1971,
        '124' => 1981,
        '125' => 1990,
        '126' => 2004,
        '127' => 2014,
        '128' => 2023,
        '129' => 2037,
        '130' => 2047,
        '131' => 2086,
        '132' => 2101,
        '133' => 2110,
        '134' => 2120,
        '135' => 2134,
        '136' => 2144,
        '137' => 2153,
        '138' => 2168,
        '139' => 2177,
        '140' => 2187,
        '141' => 2234,
        '142' => 2244,
        '143' => 2254,
        '144' => 2268,
        '145' => 2278,
        '146' => 2288,
        '147' => 2302,
        '148' => 2312,
        '149' => 2321,
        '150' => 2336,
        '151' => 2392,
        '152' => 2401,
        '153' => 2416,
        '154' => 2426,
        '155' => 2436,
        '156' => 2451,
        '157' => 2461,
        '158' => 2471,
        '159' => 2486,
        '160' => 2496,
        '161' => 2544,
        '162' => 2559,
        '163' => 2569,
        '164' => 2579,
        '165' => 2595,
        '166' => 2605,
        '167' => 2615,
        '168' => 2630,
        '169' => 2640,
        '170' => 2650,
        '171' => 2675,
        '172' => 2685,
        '173' => 2695,
        '174' => 2710,
        '175' => 2720,
        '176' => 2730,
        '177' => 2745,
        '178' => 2755,
        '179' => 2766,
        '180' => 2781,
        '181' => 2793,
        '182' => 2803,
        '183' => 2818,
        '184' => 2828,
        '185' => 2838,
        '186' => 2853,
        '187' => 2863,
        '188' => 2873,
        '189' => 2888,
        '190' => 2898,
        '191' => 2941,
        '192' => 2956,
        '193' => 2966,
        '194' => 2977,
        '195' => 2992,
        '196' => 3002,
        '197' => 3012,
        '198' => 3027,
        '199' => 3037,
        '200' => 3047
    ];

    /**
     * estateInformation
     *
     * @return void
     */
    public function estateInformation()
    {
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
        $startDate = date('Y-m-d 00:00:00');
        $endDate = date('Y-m-d 23:59:59');
        try {
            if (
                strtotime($startDate) <= (int)$dateModifyFDK->toDateTime()->format('U') &&
                (int)$dateModifyFDK->toDateTime()->format('U') <= strtotime($endDate)
            ) {
                if (!$estate->exists) {
                    $estate->status = self::STATUS_STOP;
                    $estate->date_imported = new \MongoDB\BSON\UTCDateTime(strtotime(date('Y-m-d H:i:s')) * 1000);
                    $estate->sort_order_recommend = self::NUMBER_RECOMMEND_ORDER_BY;
                    $estate['_id'] = $estateDataId;
                    $estate->is_send_announcement = self::NOT_SEND_ANNOUNCEMENT;

                    foreach ($estateData as $key => $value) {
                        $estate->$key = $value;
                    }

                    if ($estateData && $estateData->trade_status == self::STATUS_STOP) {
                        $estate->status = self::STATUS_STOP;
                    }
                    $estate->save();

                    $estateInfo = EstateInformation::where('estate_id', $estateDataId)->first();
                    if (!$estateInfo) {
                        $estateInfo = new EstateInformation();
                        $estateInfo->estate_id = $estateDataId;
                        $estateInfo->status = self::STATUS_STOP;
                        $estateInfo->tab_search = [];
                        $estateInfo->estate_fee = Estates::BROKERAGE_FEE_DISABLE;
                        $estateInfo->save();
                    } else {
                        $estateInfo->status = self::STATUS_STOP;
                        $estateInfo->save();
                    }
                } elseif (strtotime($estate->date_last_modified) != (int)$dateModifyFDK->toDateTime()->format('U')) {
                    $estateInfo = EstateInformation::where('estate_id', $estateDataId)->first();
                    $estate->status = $estateInfo->status;
                    $estate->tab_search = $estateInfo->tab_search;
                    $estate->estate_fee = $estateInfo->estate_fee;
                    $estate->is_send_announcement = self::NOT_SEND_ANNOUNCEMENT;
                    $estate->date_imported = new \MongoDB\BSON\UTCDateTime(strtotime(date('Y-m-d H:i:s')) * 1000);
                    $estate->sort_order_recommend = self::NUMBER_RECOMMEND_ORDER_BY;
                    $estate['_id'] = $estateDataId;

                    foreach ($estateData as $key => $value) {
                        $estate->$key = $value;
                    }
                    $estate->save();
                    $this->increaseDecreaseEstateInDistrict(json_decode(json_encode($estateData->address), true), false, $estateDataId);
                    $this->increaseDecreaseEstateInStation($estate->transports, false, $estateDataId);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
        }

        return $estate;
    }

    /**
     * increaseDecreaseEstateInDistrict
     *
     * @param  mixed $address
     * @param  mixed $flag
     * @param  mixed $estateId
     * @return void
     */
    public function increaseDecreaseEstateInDistrict($address, $flag, $estateId)
    {
        DB::beginTransaction();
        try {
            $districtCurrent = $address['city'];
            $cityCurrent = $address['pref'];
            $city = City::where('name', $cityCurrent)->where('status', City::STATUS_ACTIVE)->first();
            $district = District::where('name', $districtCurrent)->first();
            if (!$city) {
                $city = new City();
                $city->name = $cityCurrent;
                $city->save();
                $district = new District();
                $district->name = $districtCurrent;
                $district->city_id = $city->id;
                $district->estate_ids = $estateId;
                $district->count_estates = District::BEGIN_ESTATE_EXIST;
                $district->save();
            } else {
                if ($district) {
                    $listId = explode(',', $district->estate_ids);
                    if (!$listId[0]) {
                        $district->estate_ids = $estateId;
                        $district->count_estates = District::BEGIN_ESTATE_EXIST;
                    } else {
                        if ($flag) {
                            if (!in_array($estateId, $listId)) {
                                array_push($listId, $estateId);
                                $district->estate_ids = implode(',', $listId);
                                $district->count_estates = $district->count_estates + District::BEGIN_ESTATE_EXIST;
                            }
                        } else {
                            if ($district->count_estates > 0 && in_array($estateId, $listId)) {
                                $district->count_estates = $district->count_estates - District::BEGIN_ESTATE_EXIST;
                                $key = array_search($estateId, $listId);
                                unset($listId[$key]);
                                $district->estate_ids = implode(',', $listId);
                            }
                        }
                    }
                    $district->save();
                } else {
                    $district = new District();
                    $district->name = $districtCurrent;
                    $district->city_id = $city->id;
                    $district->romaji_name = District::DISTRICT_NOT_ORDER;
                    $district->estate_ids = $estateId;
                    $district->count_estates = District::BEGIN_ESTATE_EXIST;
                    $district->save();
                }
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }

    /**
     * increaseDecreaseEstateInStation
     *
     * @param  mixed $transportEstate
     * @param  mixed $flag
     * @param  mixed $estateId
     * @return void
     */
    public function increaseDecreaseEstateInStation($transportEstate, $flag, $estateId)
    {
        DB::beginTransaction();
        try {
            foreach ((array) $transportEstate as $transport) {
                $transport = (array) $transport;
                $transportCurrent = Transport::where('name', $transport['transport_company'])->first();
                if (!$transportCurrent) {
                    if ($transport['transport_company']) {
                        $transportNew = new Transport();
                        $transportNew->name = $transport['transport_company'];
                        $transportNew->save();
                        if ($transport['station_name']) {
                            $stationNew = new Station();
                            $stationNew->name = $transport['station_name'];
                            $stationNew->count_estates = Station::BEGIN_ESTATE_EXIST;
                            $stationNew->estate_ids = $estateId;
                            $stationNew->transport_id = $transportNew->id;
                            $stationNew->save();
                        }
                    }
                } else {
                    $station = Station::where('transport_id', $transportCurrent->id)->where('name', $transport['station_name'])->first();
                    if ($station) {
                        $listIds = [];
                        if ($station->estate_ids) {
                            $listIds = explode(',', $station->estate_ids);
                        }
                        if ($flag) {
                            if (!in_array($estateId, $listIds)) {
                                array_push($listIds, $estateId);
                                $station->count_estates = $station->count_estates + Station::BEGIN_ESTATE_EXIST;
                                $station->estate_ids = implode(',', $listIds);
                                $station->save();
                            }
                        } else {
                            if ($station->count_estates > 0 && in_array($estateId, $listIds)) {
                                $station->count_estates = $station->count_estates - Station::BEGIN_ESTATE_EXIST;
                                $key = array_search($estateId, $listIds);
                                unset($listIds[$key]);
                                $station->estate_ids = implode(',', $listIds);
                                $station->save();
                            }
                        }
                    } else {
                        if ($transport['station_name']) {
                            $stationNew = new Station();
                            $stationNew->name = $transport['station_name'];
                            $stationNew->count_estates = Station::BEGIN_ESTATE_EXIST;
                            $stationNew->estate_ids = $estateId;
                            $stationNew->transport_id = $transportCurrent->id;
                            $stationNew->save();
                        }
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
}
