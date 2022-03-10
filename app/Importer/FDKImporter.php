<?php
namespace App\Importer;
use App\Models\Estates;
use GuzzleHttp\Client;
use Exception;
use Illuminate\Support\Facades\Log;
use MongoDB;
use Illuminate\Http\Response;

class FDKImporter {
	protected $host;

    protected $url;

    protected $apiPath;

	public $importedEstateIds = [];

	public $failedImportedEstatesId = [];

	public function __construct($fdkHost, $fdkURL, $apiPath) {
    	$this->host = $fdkHost;
        $this->url = $fdkURL;
        $this->apiPath = $apiPath;
    }

    public function getClient($headers=[])
    {
    	if (empty($headers)) {
            $headers = [
                'Host' => $this->host,
                'Accept' => 'application/json',
            	'Content-Type' => 'application/json',
            ];
    	}

    	return new Client([
            'base_uri' => $this->url,
            'headers' => $headers,
        ]);
    }

    public function getEstates()
    {
        $token = config('fdk.fdk_token');
    	$client  = $this->getClient();
        try {
            $response = $client->request('GET', $this->apiPath, [
            'query' => array('token' => $token, 'limit' => env('LIMIT_ESTATE_FROM_FDK', 100)),
            'auth' => [
                'fdk',
                'test'
            ]]);
        } catch (Exception $e){
            Log::error(sprintf('Please try again. Maybe FDK have bussy!'));
            $response = null;
        }
    	if ($response && $response->getStatusCode() != Response::HTTP_OK) {
            Log::error(sprintf('Please check system!'));
            return array('status' => false);
        }
        if ($response && $response->getStatusCode() == Response::HTTP_OK) {
            $jsonData = json_decode($response->getBody());
            return array('status' => true, 'estates' => $jsonData->estates);
        }
        return array('status' => false);
    }

    public function import() {
    	$status = $this->getEstates();
    	if ($status && !$status['status']) {
            return;
    	}
        $this->importEstates($status['estates']);

        // $this->proccessAfterImport();
    }

    public function importEstates($estates){
    	foreach ($estates as $estate) {
    		$estateData = MongoDB\BSON\toPHP(MongoDB\BSON\fromJson(json_encode($estate)));
    		if (in_array($estateData->_id, $this->importedEstateIds)
    			|| in_array($estateData->_id, $this->failedImportedEstatesId)) {
            	continue;
        	}
            try {
                $estate = new Estates();
                // add room type in after import into order-renove
                $estateData->room_type = $estateData->room_floor . $estateData->room_kind;
                $importedEstate = $estate->upsertFromFDKData($estateData);

                if ($importedEstate !== null) {
                    array_push($this->importedEstateIds, $importedEstate->_id);
                } else {
                    array_push($this->failedImportedEstatesId, $estateData->_id);
                }
            } catch (Exception $e) {
            	Log::error($e);
            	array_push($this->failedImportedEstatesId, $estateData->_id);
            }
    	}
    }

    protected function proccessAfterImport()
    {
		Estates::whereNotIn('_id', $this->importedEstateIds)->chunkById(200, function ($estates) {
		    $estates->each->update(['status' => Estates::STATUS_STOP]);
		});
    }
}