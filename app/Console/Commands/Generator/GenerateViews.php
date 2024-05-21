<?php

namespace App\Console\Commands\Generator;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:views {configName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate views';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Config
        $configName = $this->argument('configName');
        $filePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$configName.'.php';
        $config = require($filePath);

        //Views Path
        $viewsPath = base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$config['routesPrefix']);

        //Index
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'index.stub';
        $template = file_get_contents($stubPath);
        if(!File::isDirectory($viewsPath)) {
            File::makeDirectory($viewsPath, 0777, true, true);
        }
        $path = $viewsPath.DIRECTORY_SEPARATOR.'index.blade.php';
        $content = $this->buildIndexContent($template, $config);
        file_put_contents($path, $content);

        //Create
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'create.stub';
        $template = file_get_contents($stubPath);
        $content = $this->buildCreateOrUpdateContent($template, $config, "create");
        if(!File::isDirectory($viewsPath)) {
            File::makeDirectory($viewsPath, 0777, true, true);
        }
        $path = $viewsPath.DIRECTORY_SEPARATOR.'create.blade.php';
        file_put_contents($path, $content);

        //Update
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'edit.stub';
        $template = file_get_contents($stubPath);
        $content = $this->buildCreateOrUpdateContent($template, $config, "edit");
        if(!File::isDirectory($viewsPath)) {
            File::makeDirectory($viewsPath, 0777, true, true);
        }
        $path = $viewsPath.DIRECTORY_SEPARATOR.'edit.blade.php';
        file_put_contents($path, $content);

        echo "Views index, create and update generated successfully using $configName config\n";
    }

    public function buildIndexContent($template, $config)
    {
        $template = str_replace('#tableName', $config['table']['name'], $template);
        $template = str_replace('#translationKeyName', $config['translationKeyName'], $template);
        $template = str_replace('#translationsPlural', $config['translations']['plural'], $template);
        $template = str_replace('#routesPrefix', $config['routesPrefix'], $template);

        $tableHeader = '';
        $tableColumns = '';
        foreach ($config['index'] as $index => $column){
            $fieldName = $this->snakeToCamelCase($column['name']);
            if($column['name'] == 'index'){
                $fieldName = 'no';
            }
            $tableHeader .= "\t\t\t<th>@lang('translation.fields.".$fieldName."')</th>";
            if($index < (sizeof($config['index']) - 1)){
                $tableHeader .= "\n";
            }

            $tableColumns .= "\t\t\t\t\t{\n";
            if($column['name'] == 'index'){
                $tableColumns .= "\t\t\t\t\t\tdata: 'DT_RowIndex',\n";
            } else{
                $tableColumns .= "\t\t\t\t\t\tdata: '".$column['name']."',\n";
            }

            if($column['name'] == 'index'){
                $tableColumns .= "\t\t\t\t\t\tname: 'No',\n";
            } else{
                $tableColumns .= "\t\t\t\t\t\tname: '".$column['name']."',\n";
            }
            if($column['name'] == 'index'){
                $tableColumns .= "\t\t\t\t\t\tsearchable: false,\n";
            }
            $tableColumns .= "\t\t\t\t\t},";

            if($index < (sizeof($config['index']) - 1)){
                $tableColumns .= "\n";
            }
        }

        $template = str_replace('#tableHeader', $tableHeader, $template);
        $template = str_replace('#tableColumns', $tableColumns, $template);

        return $template;
    }

    public function buildCreateOrUpdateContent($template, $config, $type){
        $template = str_replace('#tableName', $config['table']['name'], $template);
        $template = str_replace('#translationKeyName', $config['translationKeyName'], $template);
        $template = str_replace('#translationsPlural', $config['translations']['plural'], $template);
        $template = str_replace('#translationsAdd', $config['translations']['add'], $template);
        $template = str_replace('#translationsEdit', $config['translations']['edit'], $template);
        $template = str_replace('#routesPrefix', $config['routesPrefix'], $template);
        $template = str_replace('#translationsEdit', $config['translations']['add'], $template);

        $formContent = '';

        foreach ($config['createOrUpdate'] as $sectionKey => $section){
            $headingTemplate = $this->getFormBlockTemplate('heading-h5');
            $headingTemplate = "\t\t\t\t\t\t".str_replace('#sectionKey', $sectionKey, $headingTemplate)."\n";
            $formContent .= $headingTemplate;

            $formContent .= "\t\t\t\t\t\t".'<div class="row">'."\n";

            foreach ($section as $fieldValue){
                $fieldTranslationKey = $this->snakeToCamelCase($fieldValue['name']);

                if($fieldValue['type'] == 'string'){
                    $fieldTemplate = $this->getFormBlockTemplate('string');
                    $fieldTemplate = str_replace('#width', $fieldValue['width'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldName', $fieldValue['name'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldTranslationKey', $fieldTranslationKey, $fieldTemplate);
                    if(!empty($fieldValue['marginTop'])){
                        $fieldTemplate = str_replace('#marginTop', 'mt-'.$fieldValue['marginTop'], $fieldTemplate);
                    } else{
                        $fieldTemplate = str_replace('#marginTop', '', $fieldTemplate);
                    }
                    $formContent .= $fieldTemplate;
                } elseif($fieldValue['type'] == 'text'){
                    $fieldTemplate = $this->getFormBlockTemplate('text');
                    $fieldTemplate = str_replace('#width', $fieldValue['width'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldName', $fieldValue['name'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldTranslationKey', $fieldTranslationKey, $fieldTemplate);
                    if(!empty($fieldValue['marginTop'])){
                        $fieldTemplate = str_replace('#marginTop', 'mt-'.$fieldValue['marginTop'], $fieldTemplate);
                    } else{
                        $fieldTemplate = str_replace('#marginTop', '', $fieldTemplate);
                    }

//                    dd($fieldTemplate);
                    $formContent .= $fieldTemplate;
                } elseif($fieldValue['type'] == 'password'){
                    $fieldTemplate = $this->getFormBlockTemplate('password');
                    $fieldTemplate = str_replace('#width', $fieldValue['width'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldName', $fieldValue['name'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldTranslationKey', $fieldTranslationKey, $fieldTemplate);
                    if(!empty($fieldValue['marginTop'])){
                        $fieldTemplate = str_replace('#marginTop', 'mt-'.$fieldValue['marginTop'], $fieldTemplate);
                    } else{
                        $fieldTemplate = str_replace('#marginTop', '', $fieldTemplate);
                    }
                    $formContent .= $fieldTemplate;
                } elseif($fieldValue['type'] == 'dropdown'){
                    if(!empty($fieldValue['model'])){
                        $fieldTemplate = $this->getFormBlockTemplate('dropdown-model');
                        $fieldTemplate = str_replace('#width', $fieldValue['width'], $fieldTemplate);
                        $fieldTemplate = str_replace('#fieldName', $fieldValue['name'], $fieldTemplate);
                        $fieldTemplate = str_replace('#models', $fieldValue['valuesName'], $fieldTemplate);
                        $fieldTemplate = str_replace('#id', $fieldValue['id'], $fieldTemplate);
                        $fieldTemplate = str_replace('#displayValue', $fieldValue['displayValue'], $fieldTemplate);
                        $fieldTemplate = str_replace('#fieldTranslationKey', $fieldTranslationKey, $fieldTemplate);
                        if(!empty($fieldValue['marginTop'])){
                            $fieldTemplate = str_replace('#marginTop', 'mt-'.$fieldValue['marginTop'], $fieldTemplate);
                        } else{
                            $fieldTemplate = str_replace('#marginTop', '', $fieldTemplate);
                        }
                        $formContent .= $fieldTemplate;
                    } elseif(!empty($fieldValue['values'])){
                        $fieldTemplate = $this->getFormBlockTemplate('dropdown-values');
                        $fieldTemplate = str_replace('#width', $fieldValue['width'], $fieldTemplate);
                        $fieldTemplate = str_replace('#fieldName', $fieldValue['name'], $fieldTemplate);
                        $fieldTemplate = str_replace('#models', $fieldValue['valuesName'], $fieldTemplate);
                        $fieldTemplate = str_replace('#fieldTranslationKey', $fieldTranslationKey, $fieldTemplate);
                        if(!empty($fieldValue['marginTop'])){
                            $fieldTemplate = str_replace('#marginTop', 'mt-'.$fieldValue['marginTop'], $fieldTemplate);
                        } else{
                            $fieldTemplate = str_replace('#marginTop', '', $fieldTemplate);
                        }
                        $formContent .= $fieldTemplate;
                    }
                } elseif($fieldValue['type'] == 'datepicker'){
                    $fieldTemplate = $this->getFormBlockTemplate('datepicker');
                    $fieldTemplate = str_replace('#width', $fieldValue['width'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldName', $fieldValue['name'], $fieldTemplate);
                    $fieldTemplate = str_replace('#fieldTranslationKey', $fieldTranslationKey, $fieldTemplate);
                    if(!empty($fieldValue['marginTop'])){
                        $fieldTemplate = str_replace('#marginTop', 'mt-'.$fieldValue['marginTop'], $fieldTemplate);
                    } else{
                        $fieldTemplate = str_replace('#marginTop', '', $fieldTemplate);
                    }
                    $dateFormat = "yyyy-mm-dd";
                    if(!empty($fieldValue['format'])){
                        $dateFormat = $fieldValue['format'];
                    }
                    $fieldTemplate = str_replace('#dateFormat', $dateFormat, $fieldTemplate);

                    $formContent .= $fieldTemplate;
                }
            }

            $formContent .= "\t\t\t\t\t\t".'</div>'."\n";
        }

        $template = str_replace('#formContent', $formContent, $template);

        return $template;
    }

    function snakeToCamelCase($string, $capitalizeFirstCharacter = false)
    {
        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));

        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }

        return lcfirst($str);
    }

    function getFormBlockTemplate($name){
        $stubPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'stubs'.DIRECTORY_SEPARATOR.'form-blocks'.DIRECTORY_SEPARATOR.$name.'.stub';

        return file_get_contents($stubPath);
    }

}
