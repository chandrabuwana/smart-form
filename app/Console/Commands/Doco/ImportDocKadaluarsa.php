<?php

namespace App\Console\Commands\Doco;

use Illuminate\Console\Command;

class ImportDocKadaluarsa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-doc-kadaluarsa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $folder = 'LOGISTIK';
        $site = 'JKT';
        $NIK = '1020505';


    }
}
