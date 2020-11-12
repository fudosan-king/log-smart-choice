<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Support\Facades\Log;
use App\Models\Estate;
use Illuminate\Support\Facades\DB;
use MongoDB;
use MongoDB\Client as MongoDBClient;


class SyncEstateDataFromFDK implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $updatedEstateIds;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $estateIds = [];
        $step = 1000;
        $limit = 4000;
        $skip = 0;
        while (true) {
            $estates = $this->getEstateData($limit, $skip);
            if (!$estates || count($estates) == 0) {
                break;
            }
            foreach ($estates as $estate) {
                $this->upsertEstate($estate);
            }
            $skip = $limit;
            $limit += $step;
        }

        $this->updateStatusForNotUpdatedEstates($this->updatedEstateIds)
    };

    private function getDownloadPath()
    {
        return storage_path('fdk_lsc_estates.json');
    }

    private function getEstateData($limit, $skip)
    {
        $client = new Client([
            'base_uri' => 'http://fdk.localhost:5000',
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $client->request('GET', '/api/lsc-estates?limit' . $limit . '&skip=' . $skip);
        if ($response->getStatusCode() != '200') {
            \Log::error('Request to FDK fail!');
            return [];
        }

        $jsonData = json_decode($response->getBody());

        return $jsonData->estates;
    }

    private function upsertEstate($estate) 
    {
        $object = (array) MongoDB\BSON\toPHP(MongoDB\BSON\fromJson(json_encode($estate)));

        $existedEstate = Estate::find($object['_id']);
        if (in_array($object['_id'], $this->updatedEstateIds)) {
            continue;
        }

        array_push($this->$updatedEstateIds, $object['_id']);
        if (!$existedEstate) {
            $newEstate = new Estate($object);
            $newEstate->status  = 'new';
            $newEstate->save();
            continue;
        } else {
            $existedEstate->update($object); 
        }
    }

    private function updateStatusForNotUpdatedEstates($estateIds)
    {
        Estate::whereNotIn('_id', $estateIds)->update(['status' => 'not_sale']);
    }
}
