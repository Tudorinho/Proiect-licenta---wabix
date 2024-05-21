<?php

namespace App\Console\Commands\Generator;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Generate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate {resources} {configName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate resources';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*
         * Resources to be created
         * m = migrations
         * c = controller
         * M = model
         * v = views
         * r = routes
         * V = validators
         */
        $resources = $this->argument('resources');
        $resourcesTypes = str_split($resources);

        $configName = $this->argument('configName');

        $alreadyGenerated = [
            'employees',
            'holidays',
            'leaves',
            'leaves-balances',
            'leaves-types',
            'worklogs'
        ];
        if(in_array($configName, $alreadyGenerated)){
            echo "Files already generated for $configName \n";
            die();
        }

        foreach ($resourcesTypes as $resourcesType){
            switch ($resourcesType){
                case 'm':
                    Artisan::call('generate:migration '.$configName);
                    break;
                case 'c':
                    Artisan::call('generate:controller '.$configName);
                    break;
                case 'r':
                    Artisan::call('generate:routes '.$configName);
                    break;
                case 'M':
                    Artisan::call('generate:model '.$configName);
                    break;
                case 'v':
                    Artisan::call('generate:views '.$configName);
                    break;
                case 'E':
                    Artisan::call('generate:events '.$configName);
                    break;
            }
        }
    }
}
