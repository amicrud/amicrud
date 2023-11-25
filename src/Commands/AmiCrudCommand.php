<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AmiCrudCommand extends Command
{
    protected $signature = 'amicrud:crud {controller} {--route=} {--formable=} {--model=}';
    protected $description = 'Create a CRUD controller and update routes';

    public function handle()
    {
        $controllerPath = $this->argument('controller');
        $route = $this->option('route');
        $formable = $this->option('formable');
        $model = $this->option('model');

        // Generate Controller
        $this->generateController($controllerPath, $formable, $model, $route);

        // Update Routes
        if ($route) {
            $this->updateRoutes($route, $controllerPath);
        }
    }

    protected function generateController($controllerPath, $formable, $model, $route=null)
    {
        // Extracting the namespace and class name from the controller path
        $controllerSegments = explode('/', $controllerPath);
        $controllerName = array_pop($controllerSegments);
        $controllerNamespace = "App\\Http\\Controllers\\" . implode('\\', $controllerSegments);
        $modelNamespace = $model ? "App\\Models\\$model" : null;
        // $this->info("controllerName");
        // Read the stub file
        $stubPath = resource_path('stubs/controller.stub');
        $stubContent = file_get_contents($stubPath);
    
        // Define replacements
        $replacements = [
            'DummyNamespace' => $controllerNamespace,
            'DummyControllerName' => $controllerName,
            'DummyModelNamespace' => $modelNamespace,
            'DummyModelName' => $model,
            'dummy_main_route' => strtolower($route),
            'DummyFormableArray' => $this->generateFormableArray($formable),
        ];
    
        // Replace placeholders with actual values
        $content = str_replace(array_keys($replacements), array_values($replacements), $stubContent);
    
        // Write the modified content to the desired location
        File::put(app_path("Http/Controllers/{$controllerPath}.php"), $content);
    }
    
    protected function generateFormableArray($formable)
    {
        $fields = explode(',', $formable);
        $arrayContent = [];
    
        foreach ($fields as $field) {
            $arrayContent[] = "'{$field}' => [],";
        }
    
        return implode("\n            ", $arrayContent);
    }
    

    protected function updateRoutes($route, $controllerPath)
    {
        // $controllerClass = "App\\Http\\Controllers\\" . str_replace('/', '\\', $controllerPath);
        // $routeFilePath = base_path("routes/amicrud.php");
        // $useRouteStatement = "use Illuminate\\Support\\Facades\\Route;\n";
        // $useControllerStatement = "use {$controllerClass};\n";
        // $routeStatement = "Route::resource('{$route}', " . class_basename($controllerClass) . "::class);\n";
    
        // // Check if the file exists and contains the PHP opening tag
        // if (File::exists($routeFilePath) && strpos(File::get($routeFilePath), '<?php') !== false) {
            
        //     $fileContent = File::get($routeFilePath);
            
        //     // Append the use statements and route definition
        //     $contentToAdd = "\n";
            
        //     // Check if use statement for Route is present
        //     if (strpos($fileContent, $useRouteStatement) === false) {
        //         $contentToAdd .= $useRouteStatement;
        //     }
            
        //     // Check if use statement for Controller is present
        //     if (strpos($fileContent, $useControllerStatement) === false) {
        //         $contentToAdd .= $useControllerStatement;
        //     }
            
        //     // Append the route definition
        //     $contentToAdd .= $routeStatement;
            
        //     File::append($routeFilePath, $contentToAdd);
        // } else {
        //     // Create the file with the PHP opening tag, use statements, and route definition
        //     $content = "<?php\n\n" . $useRouteStatement . $useControllerStatement . $routeStatement;
        //     File::put($routeFilePath, $content);
        // }
    }
    
    
}
