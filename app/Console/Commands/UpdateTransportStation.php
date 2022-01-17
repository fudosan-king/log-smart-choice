<?php

namespace App\Console\Commands;

use App\Models\Estates;
use App\Models\Station;
use App\Models\Transport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTransportStation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estates:update_transport_station';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update transport and station from estate fdk';


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
        $estates = Estates::select('_id', 'transports')->where('status', Estates::STATUS_SALE)->get();
        DB::beginTransaction();
        try {
            foreach ($estates as $estate) {
                $estateId = (string) new \MongoDB\BSON\ObjectId($estate->_id);
                // Update district transport, station
                foreach ($estate->transports as $transport) {
                    $transportCurrent = Transport::where('name', $transport['transport_company'])->first();
                    if (!$transportCurrent) {
                        if ($transport['transport_company']) {
                            $transportNew = new Transport();
                            $transportNew->name = $transport['transport_company'];
                            $transportNew->save();
                            $station = Station::where('name', $transport['station_name'])->where('transport_id', $transportNew->id)->first();
                            if (!$station) {
                                if ($transport['station_name']) {
                                    $stationNew = new Station();
                                    $stationNew->name = $transport['station_name'];
                                    $stationNew->count_estates = 1;
                                    $stationNew->estate_ids = $estateId;
                                    $stationNew->transport_id = $transportNew->id;
                                    $stationNew->save();
                                }
                            } else {
                                if ($transportNew->id != $station->transport_id) {
                                    $stationNew = new Station();
                                    $stationNew->name = $transport['station_name'];
                                    $stationNew->count_estates = 1;
                                    $stationNew->estate_ids = $estateId;
                                    $stationNew->transport_id = $transportNew->id;
                                    $stationNew->save();
                                } else {
                                    $listIds = explode(',', $station->estate_ids);
                                    if (!in_array($estateId, $listIds)) {
                                        array_push($listIds, $estateId);
                                        $station->count_estates = $station->count_estates + 1;
                                        $station->estate_ids = implode(',', $listIds);
                                        $station->save();
                                    }
                                }
                            }
                        }
                    } else {
                        $station = Station::where('transport_id', $transportCurrent->id)->where('name', $transport['station_name'])->first();
                        if (!$station) {
                            if ($transport['station_name']) {
                                $stationNew = new Station();
                                $stationNew->name = $transport['station_name'];
                                $stationNew->count_estates = 1;
                                $stationNew->estate_ids = $estateId;
                                $stationNew->transport_id = $transportCurrent->id;
                                $stationNew->save();
                            }
                        } else {
                            if ($transportCurrent->id != $station->transport_id) {
                                $stationNew = new Station();
                                $stationNew->name = $transport['station_name'];
                                $stationNew->count_estates = 1;
                                $stationNew->estate_ids = $estateId;
                                $stationNew->transport_id = $transportCurrent->id;
                                $stationNew->save();
                            } else {
                                $listIds = explode(',', $station->estate_ids);
                                if (!in_array($estateId, $listIds)) {
                                    array_push($listIds, $estateId);
                                    $station->count_estates = $station->count_estates + 1;
                                    $station->estate_ids = implode(',', $listIds);
                                    $station->save();
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
        }
    }
}
