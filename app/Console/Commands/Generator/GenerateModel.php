<?php

namespace App\Console\Commands\Generator;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:model {configName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Config
        $configName = $this->argument('configName');
        $filePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$configName.'.php';
        $config = require($filePath);

        //Models Path
        $modelsPath = base_path('app'.DIRECTORY_SEPARATOR.'Models');
        $modelFileName = $config['modelName'].'.php';
        $modelFullFilePath = $modelsPath.DIRECTORY_SEPARATOR.$modelFileName;

        //Migration template path
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'model.stub';
        $template = file_get_contents($stubPath);

        $content = $this->buildContent($template, $config);
        file_put_contents($modelFullFilePath, $content);

        echo "Model $modelFileName generated successfully using $configName config\n";
    }

    public function buildContent($template, $config)
    {
        //General
        $template = str_replace('#tableName', $config['table']['name'], $template);
        $template = str_replace('#modelName', $config['modelName'], $template);

        //Fillable
        $fillable = "\tprotected \$fillable = [\n";
        foreach ($config['table']['columns'] as $column){
            if(!in_array($column['name'], ['id', 'timestamps'])){
                $fillable .= "\t\t'".$column['name']."',\n";
            }

        }
        $fillable .= "\t];";
        $template = str_replace('#fillable', $fillable, $template);

        //Relationships
        $relationshipsContent = '';
        foreach ($config['relationships'] as $index => $relationship){
            $relationshipContent = "\tpublic function ".$relationship['name']."()\n";
            $relationshipContent .= "\t{\n";
            $relationshipContent .= "\t\treturn \$this->".$relationship['type']."(".$relationship['relatedModel']."::class, '".$relationship['column']."', 'id');\n";
            $relationshipContent .= "\t}";
            if($index < (sizeof($config['relationships']) - 1)){
                $relationshipContent .= "\n\n";
            }

            $relationshipsContent .= $relationshipContent;
        }
        $template = str_replace('#relationships', $relationshipsContent, $template);

        return $template;
    }
}
