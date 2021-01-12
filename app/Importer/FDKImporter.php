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
    	$client  = $this->getClient();
    	$response = $client->request('GET', $this->apiPath, []);
    	if ($response->getStatusCode() != '200') {
            \Log::error(sprintf('Request to FDK fail with page %s and per page %s!', $page, $perPage));
            return [];
        }
        $jsonData = json_decode($response->getBody());

        return  $jsonData->estates;
    }

    public function import() {
    	$estates = $this->getEstates();
    	if (empty($estates))
    	{
    		\Log::error('Empty Estate data!');
    		return;
    	}

        $this->importEstates($estates);

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
    	if (count($this->importedEstateIds) == 0) {
			return;
		}

		Estates::whereNotIn('_id', $this->importedEstateIds)->chunkById(200, function ($estates) {
		    $estates->each->update(['status' => Estates::STATUS_NOT_SALE]);
		});
    }
}