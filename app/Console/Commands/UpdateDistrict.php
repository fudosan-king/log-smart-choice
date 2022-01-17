<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\District;
use App\Models\Estates;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateDistrict extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estates:update_district';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update district from estate fdk';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $estates = Estates::select('_id', 'address')->where('status', Estates::STATUS_SALE)->get();
        DB::beginTransaction();
        try {
            foreach ($estates as $estate) {
                $estateId = (string) new \MongoDB\BSON\ObjectId($estate->_id);
                // Update district
                $currentDistrict = $estate['address']['city'];
                $currentCity = $estate['address']['pref'];
                $district = District::where('name', $currentDistrict)->first();
                $city = City::where('name', $currentCity)->first();
                if ($city) {
                    if ($district) {
                        $listEstates = explode(',', $district->estate_ids);
                        if (!$listEstates[0]) {
                            $district->estate_ids = $estateId;
                            $district->count_estates = District::BEGIN_ESTATE_EXIST;
                        } else {
                            if (!in_array($estateId, $listEstates)) {
                                array_push($listEstates, $estateId);
                                $district->estate_ids = implode(',', $listEstates);
                                $district->count_estates =  $district->count_estates + District::BEGIN_ESTATE_EXIST;
                            }
                        }
                        $district->save();
                    } else {
                        $district = new District();
                        $district->name = $currentDistrict;
                        $district->city_id = $city->id;
                        $district->estate_ids = $estateId;
                        $district->count_estates = District::BEGIN_ESTATE_EXIST;
                        $district->save();
                    }
                } else {
                    $city = new City();
                    $city->name = $currentCity;
                    $city->status = City::STATUS_ACTIVE;
                    $city->save();
                    $district = new District();
                    $district->city_id = $city->id;
                    $district->name = $currentDistrict;
                    $district->estate_ids = $estateId;
                    $district->count_estates = District::BEGIN_ESTATE_EXIST;
                    $district->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
}
