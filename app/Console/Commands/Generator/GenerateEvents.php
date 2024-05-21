<?php

namespace App\Console\Commands\Generator;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:events {configName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate validators';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Config
        $configName = $this->argument('configName');
        $filePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$configName.'.php';
        $config = require($filePath);

        //Validators Path
        $validatorsPath = base_path('app'.DIRECTORY_SEPARATOR.'Validators');
        $beforeValidatorFileName = "BeforeValidate".$config['modelName'].'.php';
        $beforeValidatorFullFilePath = $validatorsPath.DIRECTORY_SEPARATOR.$beforeValidatorFileName;

        //Before Validator template path
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'before-validate.stub';
        $template = file_get_contents($stubPath);
        $content = $this->buildContent($template, $config);
        file_put_contents($beforeValidatorFullFilePath, $content);

        echo "Before Validator $beforeValidatorFileName generated successfully using $configName config\n";

        //BeforeCreate listener
        $path = base_path('app'.DIRECTORY_SEPARATOR.'Listeners');
        $fileName = "BeforeCreate".DIRECTORY_SEPARATOR."BeforeCreate".$config['modelName'].'Listener.php';
        $fullFilePath = $path.DIRECTORY_SEPARATOR.$fileName;
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'before-create-listener.stub';
        $template = file_get_contents($stubPath);
        $content = $this->buildContent($template, $config);
        file_put_contents($fullFilePath, $content);

        //AfterCreate listener
        $path = base_path('app'.DIRECTORY_SEPARATOR.'Listeners');
        $fileName = "AfterCreate".DIRECTORY_SEPARATOR."AfterCreate".$config['modelName'].'Listener.php';
        $fullFilePath = $path.DIRECTORY_SEPARATOR.$fileName;
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'after-create-listener.stub';
        $template = file_get_contents($stubPath);
        $content = $this->buildContent($template, $config);
        file_put_contents($fullFilePath, $content);

        //BeforeUpdate listener
        $path = base_path('app'.DIRECTORY_SEPARATOR.'Listeners');
        $fileName = "BeforeUpdate".DIRECTORY_SEPARATOR."BeforeUpdate".$config['modelName'].'Listener.php';
        $fullFilePath = $path.DIRECTORY_SEPARATOR.$fileName;
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'before-update-listener.stub';
        $template = file_get_contents($stubPath);
        $content = $this->buildContent($template, $config);
        file_put_contents($fullFilePath, $content);

        //AfterUpdate listener
        $path = base_path('app'.DIRECTORY_SEPARATOR.'Listeners');
        $fileName = "AfterUpdate".DIRECTORY_SEPARATOR."AfterUpdate".$config['modelName'].'Listener.php';
        $fullFilePath = $path.DIRECTORY_SEPARATOR.$fileName;
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'after-update-listener.stub';
        $template = file_get_contents($stubPath);
        $content = $this->buildContent($template, $config);
        file_put_contents($fullFilePath, $content);
    }

    public function buildContent($template, $config)
    {
        //General
        $template = str_replace('#modelName', $config['modelName'], $template);

        return $template;
    }
}
