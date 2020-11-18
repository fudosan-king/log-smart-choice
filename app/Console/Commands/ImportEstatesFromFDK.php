<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Importer\FDKImporter;

class ImportEstatesFromFDK extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estate:import_from_fdk 
                                {--page= : The page number for getting Estates, 0 means all pages}
                                {--per_page= : Number of estate per page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import estates from FDK';


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
        $perPage = (int) $this->option('per_page');
        $page = (int) $this->option('page');
        if (empty($perPage) || is_null($page)) {
            $this->error('Missing command param: per_page, page');
            return;
        }

        $fdkHost = setting('admin.fdk_host', config('fdk.fdk_host'));
        if (empty($fdkHost)) {
            $this->error('Missing setting FDK host! Please set it in Admin setting!');
        }

        $logSmartChoiceApiPath = setting('admin.log_smart_choice_api_path', config('fdk.log_smart_choice_api_path'));
        if (empty($logSmartChoiceApiPath)) {
            $this->error('Missing setting log Smart Choice API path! Please set it in Admin setting!');
        }

        $this->info('Start Importing');
        
        $fdkImporter = new FDKImporter($fdkHost, $logSmartChoiceApiPath, $perPage, $page);
        $fdkImporter->import();

        $this->info(sprintf("Successfull import %s estates", count($fdkImporter->importedEstateIds)));

        if (count($fdkImporter->failedImportedEstatesId)) {
            $this->info(sprintf("Failed import %s estates", count($fdkImporter->failedImportedEstatesId)));
        }
    }
}
