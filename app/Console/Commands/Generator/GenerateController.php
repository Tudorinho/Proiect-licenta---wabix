<?php

namespace App\Console\Commands\Generator;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:controller {configName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Config
        $configName = $this->argument('configName');
        $filePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$configName.'.php';
        $config = require($filePath);

        //Controllers Path
        $controllersPath = base_path('app'.DIRECTORY_SEPARATOR.'Http'.DIRECTORY_SEPARATOR.'Controllers');
        $controllerFileName = $config['controllerName'].'.php';
        $controllerFullFilePath = $controllersPath.DIRECTORY_SEPARATOR.$controllerFileName;

        //Controller template path
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'controller.stub';
        $template = file_get_contents($stubPath);

        $content = $this->buildContent($template, $config);
        file_put_contents($controllerFullFilePath, $content);

        echo "Controller $controllerFileName generated successfully using $configName config\n";
    }

    public function buildContent($template, $config)
    {
        //Manage general placeholders
        $template = str_replace('#controllerName', $config['controllerName'], $template);
        $template = str_replace('#modelName', $config['modelName'], $template);
        $template = str_replace('#routesPrefix', $config['routesPrefix'], $template);
        $template = str_replace('#translationKeyName', $config['translationKeyName'], $template);

        //Manage index route
        $list = $config['index'];
        $columns = '';
        $rawColumns = [];
        foreach ($list as $item){
            $columnName = $item['name'];
            if(!empty($item['value'])){
                $columnValue = $item['value'];
            } else{
                $columnValue = '';
            }

            $column = '';

            if($item['name'] == 'index'){
                $column .= "\t\t\t\t->addIndexColumn()\n";
            } elseif($item['name'] == 'action'){
                $rawColumns[] = "'action'";
                $actions = '';

                foreach ($item['types'] as $type){
                    $actions .= "\t\t\t\t\t\t'".$type."' => '".$config['routesPrefix'].".".$type."',\n";
                }
                $column .= "\t\t\t\t->addColumn('action', function(\$row){\n";
                $column .= "\t\t\t\t\treturn view('components.columns.actions', [\n";
                $column .= "\t\t\t\t\t\t'row' => \$row,\n";
                $column .= $actions;
                $column .= "\t\t\t\t\t]);\n";
                $column .= "\t\t\t\t})\n";
            } else{
                if(!empty($item['isRaw']) && $item['isRaw'] == true){
                    $rawColumns[] = "'".$columnName."'";
                }
                $column .= "\t\t\t\t->addColumn('".$columnName."', function(\$row){\n";
                if(!empty($item['value'])){
                    $column .= "\t\t\t\t\treturn ".$columnValue.";\n";
                } else{
                    $column .= "\t\t\t\t\treturn \$row->$columnName;\n";
                }
                $column .= "\t\t\t\t})\n";
            }

            $columns .= $column;
        }

        if(!empty($rawColumns)){
            $columns .= "\t\t\t\t->rawColumns([".implode(',', $rawColumns)."])";
        }
        $template = str_replace('#columns', $columns, $template);

        //Manage store validation
        $storeValidator = $this->buildValidator($config, 'store');
        $template = str_replace('#storeValidator', $storeValidator, $template);

        //Manage update validator
        $updateValidator = $this->buildValidator($config, 'update');
        $template = str_replace('#updateValidator', $updateValidator, $template);

        //Manage create variables
        $variables = $this->buildVariables($config, 'createOrUpdate');
        $template = str_replace('#createVariables', $variables['template'], $template);
        if(empty($variables['variablesNames'])){
            $return = "return view('#routesPrefix.create');";
            $return = "\t\t".str_replace('#routesPrefix', $config['routesPrefix'], $return);
        } else{
            $return = "return view('#routesPrefix.create', compact(".implode(',', $variables['variablesNames'])."));";
            $return = "\t\t".str_replace('#routesPrefix', $config['routesPrefix'], $return);
        }
        $template = str_replace('#createReturn', $return, $template);
        $dependencies = $variables['dependencyModels'];

        //Manage update variables
        $template = str_replace('#updateVariables', $variables['template'], $template);
        if(empty($variables['variablesNames'])){
            $return = "return view('#routesPrefix.edit', compact('model'));";
            $return = "\t\t".str_replace('#routesPrefix', $config['routesPrefix'], $return);
        } else{
            $return = "return view('#routesPrefix.edit', compact(".implode(',', $variables['variablesNames']).", 'model'));";
            $return = "\t\t".str_replace('#routesPrefix', $config['routesPrefix'], $return);
        }
        $template = str_replace('#updateReturn', $return, $template);

        //Manage Dependency Models
        $dependenciesTemplate = '';
        foreach ($dependencies as $index => $dependency){
            $dependenciesTemplate .= "use App\Models\\".$dependency.";";
            if($index < (sizeof($dependencies) - 1)){
                $dependenciesTemplate .= "\n";
            }
        }
        $template = str_replace('#dependencyModels', $dependenciesTemplate, $template);

        return $template;
    }

    public function buildValidator($config, $type)
    {
        if(empty($config['validators']) || empty($config['validators'][$type])){
            return '';
        }

        $validator = "\t\t\$validator = Validator::make(\$request->all(), [\n";
        foreach ($config['validators'][$type] as $key => $value){
            $validator .= "\t\t\t'".$key."' => '".$value."',\n";
        }
        $validator .= "\t\t]);";

        return $validator;
    }

    public function buildVariables($config, $type)
    {
        $variables = '';
        $variablesNames = [];
        $dependencyModels = [];

        if(empty($config[$type])){
            return $variables;
        }

        foreach ($config[$type] as $sections){
            foreach ($sections as $field){
                $variable = '';

                if ($field['type'] == 'dropdown'){
                    if(!empty($field['model'])){
                        $variable = "\t\t$".$field['valuesName']." = ".$field['model']."::all();\n";
                        $dependencyModels[] = $field['model'];
                    } else{
                        $variable = "\t\t$".$field['valuesName']." = [".implode(',', $field['values'])."];\n";
                    }

                    $variablesNames[] = "'".$field['valuesName']."'";
                }

                $variables .= $variable;
            }
        }

        return [
            "template" => $variables,
            "variablesNames" => $variablesNames,
            "dependencyModels" => $dependencyModels
        ];
    }
}
