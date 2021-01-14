<?php
namespace App\Importer;
use App\Models\Estates;
use GuzzleHttp\Client;
use Exception;
use MongoDB;

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
            'query' => array('token' => $token),
            'auth' => [
                'fdk',
                'test'
            ]]);
        } catch (Exception $e){
            \Log::error(sprintf('Please try again. Maybe FDK have bussy!'));
            $response = null;
        }
    	if ($response && $response->getStatusCode() != '200') {
            \Log::error(sprintf('Please check system!'));
            return array('status' => false);
        }
        if ($response && $response->getStatusCode() == '200') {
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

        $this->proccessAfterImport();
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
                $importedEstate = $estate->upsertFromFDKData($estateData);

                if ($importedEstate !== null) {
                    array_push($this->importedEstateIds, $importedEstate->_id);
                } else {
                    array_push($this->failedImportedEstatesId, $estateData->_id);
                }
            } catch (Exception $e) {
            	\Log::error($e);
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