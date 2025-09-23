<?php

namespace TidianeHamed\LaravelApiStarter\Commands;

use Illuminate\Console\Command;
use TidianeHamed\LaravelApiStarter\ApiStarterService;

class ApiStarterCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'api:starter 
                           {model : The name of the model}
                           {--all : Generate all components}
                           {--model : Generate model}
                           {--migration : Generate migration}
                           {--controller : Generate controller}
                           {--request : Generate form request}
                           {--resource : Generate API resource}
                           {--service : Generate service}
                           {--seeder : Generate seeder}
                           {--routes : Add routes to api.php}
                           {--force : Overwrite existing files}';

    /**
     * The console command description.
     */
    protected $description = 'Generate a complete API starter kit with models, controllers, requests, resources, services, and seeders';

    /**
     * Execute the console command.
     */
    public function handle(ApiStarterService $apiStarter): int
    {
        $modelName = $this->argument('model');
        
        // Determine which components to generate
        $options = $this->getGenerationOptions();
        
        $this->info("🚀 Generating API components for: {$modelName}");
        $this->newLine();
        
        try {
            // Generate components
            $generated = $apiStarter->generateApiComponents($modelName, $options);
            
            // Display results
            $this->displayResults($generated);
            
            // Generate routes if requested
            if ($options['generate_routes'] ?? false) {
                $this->generateRoutes($modelName);
            }
            
            $this->newLine();
            $this->info('✅ API starter kit generated successfully!');
            
            // Display next steps
            $this->displayNextSteps($modelName);
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error("❌ Error generating API components: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Get the generation options based on command arguments.
     */
    protected function getGenerationOptions(): array
    {
        // If --all is specified, generate everything
        if ($this->option('all')) {
            return [
                'generate_model' => true,
                'generate_migration' => true,
                'generate_controller' => true,
                'generate_request' => true,
                'generate_resource' => true,
                'generate_service' => true,
                'generate_seeder' => true,
                'generate_routes' => $this->option('routes'),
            ];
        }
        
        // Check individual options
        $hasSpecificOptions = collect([
            'model', 'migration', 'controller', 'request', 
            'resource', 'service', 'seeder'
        ])->some(fn($option) => $this->option($option));
        
        // If no specific options, generate all by default
        if (!$hasSpecificOptions) {
            return [
                'generate_model' => true,
                'generate_migration' => true,
                'generate_controller' => true,
                'generate_request' => true,
                'generate_resource' => true,
                'generate_service' => true,
                'generate_seeder' => true,
                'generate_routes' => $this->option('routes'),
            ];
        }
        
        return [
            'generate_model' => $this->option('model'),
            'generate_migration' => $this->option('migration'),
            'generate_controller' => $this->option('controller'),
            'generate_request' => $this->option('request'),
            'generate_resource' => $this->option('resource'),
            'generate_service' => $this->option('service'),
            'generate_seeder' => $this->option('seeder'),
            'generate_routes' => $this->option('routes'),
        ];
    }

    /**
     * Display the generation results.
     */
    protected function displayResults(array $generated): void
    {
        foreach ($generated as $type => $path) {
            $this->line("📄 {$type}: <info>{$path}</info>");
        }
    }

    /**
     * Generate API routes for the model.
     */
    protected function generateRoutes(string $modelName): void
    {
        $routesPath = base_path('routes/api.php');
        
        if (!file_exists($routesPath)) {
            $this->warn('routes/api.php not found. Skipping route generation.');
            return;
        }
        
        $controllerName = $modelName . 'Controller';
        $routeName = \Illuminate\Support\Str::kebab(\Illuminate\Support\Str::plural($modelName));
        
        $routes = "\n// {$modelName} API Routes\n";
        $routes .= "Route::apiResource('{$routeName}', App\\Http\\Controllers\\Api\\{$controllerName}::class);\n";
        
        file_put_contents($routesPath, $routes, FILE_APPEND);
        
        $this->line("🛣️  routes: <info>{$routesPath}</info>");
    }

    /**
     * Display next steps for the user.
     */
    protected function displayNextSteps(string $modelName): void
    {
        $this->newLine();
        $this->info('📋 Next Steps:');
        $this->line('1. Review and customize the generated migration file');
        $this->line('2. Run: <comment>php artisan migrate</comment>');
        $this->line('3. Update the form request validation rules');
        $this->line('4. Customize the API resource response format');
        $this->line('5. Implement business logic in the service class');
        $this->line('6. Update the seeder with relevant test data');
        $this->line('7. Run: <comment>php artisan db:seed --class=' . $modelName . 'Seeder</comment>');
        
        if ($this->option('routes')) {
            $this->line('8. Test your API endpoints');
        } else {
            $this->line('8. Add routes manually or run with --routes option');
        }
    }
}