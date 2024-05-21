<?php

namespace App\Console\Commands\Generator;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:routes {configName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate routes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Config
        $configName = $this->argument('configName');
        $filePath = dirname(__FILE__).DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$configName.'.php';
        $config = require($filePath);
        $modelName = $config['modelName'];
        $controllerName = $config['controllerName'];
        $routesPrefix = $config['routesPrefix'];

        echo "Use the generated routes below for $modelName. Routes were generated successfully using $configName config\n\n";

        $routes = "Route::prefix('$routesPrefix')->group(function () {\n";
        $routes .= "\tRoute::get('', [App\Http\Controllers\\$controllerName::class, 'index'])->name('$routesPrefix.index');\n";
        $routes .= "\tRoute::get('/create', [App\Http\Controllers\\$controllerName::class, 'create'])->name('$routesPrefix.create');\n";
        $routes .= "\tRoute::post('/', [App\Http\Controllers\\$controllerName::class, 'store'])->name('$routesPrefix.store');\n";
        $routes .= "\tRoute::get('/{id}/edit', [App\Http\Controllers\\$controllerName::class, 'edit'])->name('$routesPrefix.edit');\n";
        $routes .= "\tRoute::put('/{id}', [App\Http\Controllers\\$controllerName::class, 'update'])->name('$routesPrefix.update');\n";
        $routes .= "\tRoute::delete('/{id}', [App\Http\Controllers\\$controllerName::class, 'destroy'])->name('$routesPrefix.destroy');\n";
        $routes .= "});\n\n";
        echo $routes;
    }
}
