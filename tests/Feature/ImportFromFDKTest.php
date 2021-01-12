<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Estates;
use App\Importer\FDKImporter;
use MongoDB;
use Artisan;
use Database\Seeds\FDKSettingsSeeder;

class ImportFromFDKTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        Estates::all()->each->delete();
        Artisan::call('db:seed', [
            '--class' => FDKSettingsSeeder::class,
        ]);

        $this->fdkHost = setting('fdk_host', config('fdk.fdk_host'));
        $this->fdkURL = setting('fdk_url', config('fdk.fdk_url'));
        $this->logSmartChoiceApiPath = setting('fdk.log_smart_choice_api_path', config('fdk.log_smart_choice_api_path'));
    }

    public function testGettingDataFromFDK()
    {
        $fdkImporter = new FDKImporter($this->fdkHost, $this->fdkURL, $this->logSmartChoiceApiPath);
        $estates = $fdkImporter->getEstates();
        $this->assertTrue(count($estates) > 0, "Error while geting data from FDK!");
    }

    public function testImport()
    {
        $insertedEstateIds = $this->insertEstatesFromFDK();
        $this->randomModifiedEstates($insertedEstateIds);
        $this->updateEstates();
    }


    public function tearDown(): void
    {
        parent::tearDown();
        Estates::all()->each->delete();
    }

    protected function updateEstates()
    {
        $importer = new FDKImporter($this->fdkHost, $this->fdkURL, $this->logSmartChoiceApiPath);
        $updatingEstates = $importer->getEstates();
        $importer->import();
        $this->assertTrue(count($importer->importedEstateIds) >= 1);

        $this->checkEstatesAfterImport($updatingEstates, Estates::STATUS_IN_SALE);

        $notSaleUpdatedEstate = Estates::where('status', Estates::STATUS_NOT_SALE)->get();
        $this->assertTrue(count($notSaleUpdatedEstate) == 0, 'Error while update estate status to NOT_SALE');
    }

    protected function insertEstatesFromFDK()
    {
        $importer = new FDKImporter($this->fdkHost, $this->fdkURL, $this->logSmartChoiceApiPath);
        $insertingestates = $importer->getEstates();
        $importer->import();
        $this->assertTrue(count($importer->importedEstateIds) >= 1);

        $this->checkEstatesAfterImport($insertingestates, Estates::STATUS_NEW);

        return $importer->importedEstateIds;
    }

    protected function checkEstatesAfterImport($importingEstates, $statusToCheck) {
        echo '
        ';
        echo 'Status check: ' . $statusToCheck;
        foreach ($importingEstates as $importingEstate) {
            // Parse to array for document and root for comparision.
            // We need to parse all to array because in somecase, Laravel return to array for empty object
            $importingEstate = MongoDB\BSON\toPHP(MongoDB\BSON\fromJson(
                json_encode($importingEstate)), [
                    'root' => 'array',
                    'document' => 'array',
                    'array' => 'array'
                ]);
            $importedEstate = Estates::find($importingEstate['_id']);
            echo '
            ';
            echo 'ID: ' . $importedEstate->_id . ' -> Status: ' .$importedEstate->status;
            $this->assertTrue($importedEstate !== null, 'Inserting error!');
            $this->assertTrue($importedEstate->status === $statusToCheck, sprintf('Expect %s status, got %s!', $statusToCheck, $importedEstate->status));

            // Parse to array for document and root for comparision.
            // We need to parse all to array because in somecase, Laravel return to array for empty object
            $importedEstate = MongoDB\BSON\toPHP(MongoDB\BSON\fromJson(
                json_encode($importedEstate)),[
                    'root' => 'array',
                    'document' => 'array',
                    'array' => 'array'
                ]);
            $isSameOrigin = $this->isEstateSameWithOrigin($importingEstate, $importedEstate);

            $this->assertTrue($isSameOrigin);
        }
    }

    protected function isEstateSameWithOrigin($originEstate, $estate) {
        $isSame = true;
        foreach ($originEstate as $key => $value) {
            if ($estate[$key] != $value) {
                $isSameOrigin = false;
                break;
            }
        }
        return $isSame;
    }

    protected function randomModifiedEstates($insertedEstateIds) {
        foreach ($insertedEstateIds as $insertedEstateId) {
            $insertedEstate = Estates::find($insertedEstateId);
            $insertedEstate->tatemono_menseki = rand(0,100);
            $insertedEstate->price = rand(0,100);
            $insertedEstate->status = Estates::STATUS_IN_SALE;
            $insertedEstate->save();
        }
    }
}
