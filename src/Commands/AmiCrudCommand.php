<?php

namespace AmiCrud\Commands;

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

        $this->info("<options=bold,reverse;fg=green> Arguments Generated ...10% </>");

        // Generate Controller
        $path = $this->generateController($controllerPath, $formable, $model, $route);

        // Update Routes
        if ($path) {
            $this->info("<options=bold;fg=green>AMICRUD CLASS: </> ".$path);
        }
        if ($route&&$path) {
            $this->updateRoutes($route, $controllerPath);
        }
    }

    protected function generateController($controllerPath, $formable, $model, $route=null)
    {
        // Extracting the namespace and class name from the controller path
        $controllerSegments = explode('/', $controllerPath);
        $controllerName = array_pop($controllerSegments);

        if ($controllerSegments) {
            $controllerNamespace = "App\\Http\\Controllers\\" . implode('\\', $controllerSegments);
        }else{
            $controllerNamespace = "App\\Http\\Controllers";
        }

        $modelNamespace = $model ? "App\\Models\\$model" : null;
        // Read the stub file
        $stubPath = __DIR__ . '/../../resources/stubs/controller.stub';
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
        $path = "Http/Controllers/{$controllerPath}.php";
        $fullPath = app_path($path);

        // Check if the file already exists
        if (File::exists($fullPath)) {
            $this->info("The controller '{$controllerPath}' already exists. 😊\n");
        } else {
            // Write the modified content to the desired location
            File::put($fullPath, $content);
            $this->info("<options=bold,reverse;fg=green> Controller '{$controllerPath}' created successfully. ......100%  </> 🥳🥰🎉\n\n");
            return "app/".$path;
        }

     
    }
    
    protected function generateFormableArray($formable)
    {
       
        $fields = explode(',', $formable);
        $arrayContent = [];
    
        foreach ($fields as $field) {
            $arrayContent[] = "'{$field}' => [],";
        }
        $this->info("<options=bold,reverse;fg=green> Formables Generated ....30% </>");
    
        return implode("\n            ", $arrayContent);
    }
    

    protected function updateRoutes($route, $controllerPath)
    {
        $controllerSegments = explode('/', $controllerPath);
        $controllerName = array_pop($controllerSegments);
       
        $this->info("<options=bold;fg=green>ROUTE:</> ". "Route::resource('/".$route."', ".$controllerName."::class);"); 
        $this->info("<options=bold;fg=green>LINK:</> ". ' <a href="{{route("'.$route.'")}}">'); 

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
