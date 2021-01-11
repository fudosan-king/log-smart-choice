<?php
namespace App\Importer;
use App\Models\Estates;
use GuzzleHttp\Client;
use Exception;
use MongoDB;

class FDKImporter {
	protected $host;

    protected $apiPath;

	protected $perPage = 1000;

	protected $page = 0;

	public $importedEstateIds = [];

	public $failedImportedEstatesId = [];


	public function __construct($fdkHost, $apiPath, $perPage, $page) {
    	$this->host = $fdkHost;
    	$this->perPage = $perPage;
    	$this->page = $page;
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
            'base_uri' => 'http://' . $this->host,
            'headers' => $headers,
        ]);
    }

    private function _getAllEstates($perPage)
    {
    	$page = 1;
    	$resultEstates = [];
        $stop = false;
    	while (!$stop) {
    		$estates = $this->_getEstatesByPage($perPage, $page);

    		if (empty($estates)) {
    			$stop = true;
    		} else {
                $resultEstates = array_merge($resultEstates, $estates);
                $page++;
            }
    	}

    	return $resultEstates;
    }

    private function _getEstatesByPage($perPage, $page)
    {
    	$client  = $this->getClient();
    	$response = $client->request('GET', $this->apiPath,
    		['query' => $this->_generateQueryParams($perPage, $page)]
    	);
    	if ($response->getStatusCode() != '200') {
            \Log::error(sprintf('Request to FDK fail with page %s and per page %s!', $page, $perPage));
            return [];
        }
        $jsonData = json_decode($response->getBody());

        return  $jsonData->estates;
    }


    private function _generateQueryParams($perPage, $page)
    {
    	$queryParams['limit'] = $perPage;
    	$queryParams['skip'] = $page > 0 ? (($page - 1) * $perPage) : 0;

    	return $queryParams;
    }

    public function getEstates($perPage, $page) {
    	if (is_int($page) && $page > 0) {
    		return $this->_getEstatesByPage($perPage, $page);
    	}

    	return $this->_getAllEstates($perPage);
    }

    public function import() {
    	$estates = $this->getEstates($this->perPage, $this->page);
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