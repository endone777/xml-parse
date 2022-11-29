<?php

namespace App\Console\Commands;

use App\Services\OfferUpdateService;
use Illuminate\Console\Command;

class XMLParse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xml:parse {--file=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @param OfferUpdateService $service
     * @return void
     */
    public function handle(OfferUpdateService $service): void
    {

        $service
            ->fileExist($this->option('file'))
            ->createOffersArray()
            ->difference()
            ->deleteDuplicates()
        ;


        $data = array_chunk($service->getStorageData(), 20);

        $bar = $this->output->createProgressBar(count($data));

        $bar->start();

        for($i = 0 ; $i < count($data) ; $i++){
            $service->upsertData($data[$i]);
            $bar->advance();
        }

        $bar->finish();

        $timeExecution= round((microtime(true) - LARAVEL_START) * 1000 , 4 );

        $this->newLine();

        $this->info( "Finishing: " .$timeExecution . "ms" );

    }
}
