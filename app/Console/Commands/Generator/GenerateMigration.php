<?php

namespace App\Console\Commands\Generator;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:migration {configName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate migration';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Config
        $configName = $this->argument('configName');
        $filePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$configName.'.php';
        $config = require($filePath);

        //Migrations Path
        $now = new Carbon();
        $formattedDate = $now->format('Y_m_d');
        $migrationFileName = $formattedDate.'_'.time().'_create_'.$config['table']['name'].'_table.php';
        $migrationsPath = base_path('database'.DIRECTORY_SEPARATOR.'migrations');
        $migrationFullFilePath = $migrationsPath.DIRECTORY_SEPARATOR.$migrationFileName;

        //Migration template path
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'migration.stub';
        $template = file_get_contents($stubPath);

        $content = $this->buildContent($template, $config);
        file_put_contents($migrationFullFilePath, $content);

        echo "Migration $migrationFileName generated successfully using $configName config\n";
    }

    public function buildContent($template, $config)
    {
        $template = str_replace('#tableName', $config['table']['name'], $template);

        $columns = "";
        foreach ($config['table']['columns'] as $index => $column){
            $columnTemplate = '';
            if($column['name'] == 'id'){
                $columnTemplate = "\$table->id()";
            } elseif ($column['name'] == 'timestamps'){
                $columnTemplate = "\$table->timestamps()";
            } elseif ($column['type'] == 'enum'){
                $columnTemplate = "\$table->enum('".$column['name']."', [".implode(',', $column['values'])."])";
            } else{
                $columnTemplate = "\$table->".$column['type']."('".$column['name']."')";
            }

            $columnTemplate = "\t\t\t".$columnTemplate;
            if(!empty($column['nullable']) && $column['nullable'] == true){
                $columnTemplate = $columnTemplate.'->nullable()';
            }
            if(!empty($column['default'])){
                $columnTemplate = $columnTemplate.'->default('.$column['default'].')';
            }
            if(!empty($column['type']) && $column['type'] == 'foreignId'){
                $columnTemplate = $columnTemplate.'->constrained()';
            }

            $columnTemplate = $columnTemplate.';';

            if($index < (sizeof($config['table']['columns']) - 1)){
                $columnTemplate = $columnTemplate."\n";
            }

            $columns .= $columnTemplate;
        }

        $template = str_replace('#columns', $columns, $template);

        return $template;
    }
}
