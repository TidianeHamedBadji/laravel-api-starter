<?php

namespace TidianeHamed\LaravelApiStarter;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class ApiStarterService
{
    public function __construct(
        protected Filesystem $files = new Filesystem()
    ) {}

    /**
     * Generate all API starter components for a model.
     */
    public function generateApiComponents(string $modelName, array $options = []): array
    {
        $generated = [];
        
        // Convert model name to different formats
        $studlyName = Str::studly($modelName);
        $snakeName = Str::snake($modelName);
        $pluralName = Str::plural($studlyName);
        $kebabName = Str::kebab($modelName);
        
        $config = config('api-starter', []);
        
        // Generate Model
        if ($options['generate_model'] ?? true) {
            $generated['model'] = $this->generateModel($studlyName, $config);
        }
        
        // Generate Migration
        if ($options['generate_migration'] ?? true) {
            $generated['migration'] = $this->generateMigration($snakeName, $config);
        }
        
        // Generate Controller
        if ($options['generate_controller'] ?? true) {
            $generated['controller'] = $this->generateController($studlyName, $config);
        }
        
        // Generate Form Request
        if ($options['generate_request'] ?? true) {
            $generated['request'] = $this->generateRequest($studlyName, $config);
        }
        
        // Generate API Resource
        if ($options['generate_resource'] ?? true) {
            $generated['resource'] = $this->generateResource($studlyName, $config);
        }
        
        // Generate Service
        if ($options['generate_service'] ?? true) {
            $generated['service'] = $this->generateService($studlyName, $config);
        }
        
        // Generate Seeder
        if ($options['generate_seeder'] ?? true) {
            $generated['seeder'] = $this->generateSeeder($studlyName, $config);
        }
        
        return $generated;
    }

    /**
     * Generate a model file.
     */
    protected function generateModel(string $name, array $config): string
    {
        $namespace = $config['model_namespace'] ?? 'App\\Models';
        $stubPath = $this->getStubPath('models/model.stub');
        
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceTokens($stub, [
            'NAMESPACE' => $namespace,
            'CLASS_NAME' => $name,
            'TABLE_NAME' => Str::snake(Str::plural($name)),
        ]);
        
        $path = app_path("Models/{$name}.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $stub);
        
        return $path;
    }

    /**
     * Generate a migration file.
     */
    protected function generateMigration(string $name, array $config): string
    {
        $className = 'Create' . Str::studly(Str::plural($name)) . 'Table';
        $tableName = Str::plural($name);
        $stubPath = $this->getStubPath('migrations/create_table.stub');
        
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceTokens($stub, [
            'CLASS_NAME' => $className,
            'TABLE_NAME' => $tableName,
        ]);
        
        $filename = date('Y_m_d_His') . '_create_' . $tableName . '_table.php';
        $path = database_path("migrations/{$filename}");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $stub);
        
        return $path;
    }

    /**
     * Generate a controller file.
     */
    protected function generateController(string $name, array $config): string
    {
        $namespace = $config['controller_namespace'] ?? 'App\\Http\\Controllers\\Api';
        $stubPath = $this->getStubPath('controllers/api_controller.stub');
        
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceTokens($stub, [
            'NAMESPACE' => $namespace,
            'CLASS_NAME' => $name . 'Controller',
            'MODEL_NAME' => $name,
            'MODEL_VARIABLE' => Str::camel($name),
            'PLURAL_VARIABLE' => Str::camel(Str::plural($name)),
        ]);
        
        $path = app_path("Http/Controllers/Api/{$name}Controller.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $stub);
        
        return $path;
    }

    /**
     * Generate a form request file.
     */
    protected function generateRequest(string $name, array $config): string
    {
        $namespace = $config['request_namespace'] ?? 'App\\Http\\Requests';
        $stubPath = $this->getStubPath('requests/form_request.stub');
        
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceTokens($stub, [
            'NAMESPACE' => $namespace,
            'CLASS_NAME' => $name . 'Request',
        ]);
        
        $path = app_path("Http/Requests/{$name}Request.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $stub);
        
        return $path;
    }

    /**
     * Generate an API resource file.
     */
    protected function generateResource(string $name, array $config): string
    {
        $namespace = $config['resource_namespace'] ?? 'App\\Http\\Resources';
        $stubPath = $this->getStubPath('resources/api_resource.stub');
        
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceTokens($stub, [
            'NAMESPACE' => $namespace,
            'CLASS_NAME' => $name . 'Resource',
        ]);
        
        $path = app_path("Http/Resources/{$name}Resource.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $stub);
        
        return $path;
    }

    /**
     * Generate a service file.
     */
    protected function generateService(string $name, array $config): string
    {
        $namespace = $config['service_namespace'] ?? 'App\\Services';
        $stubPath = $this->getStubPath('services/service.stub');
        
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceTokens($stub, [
            'NAMESPACE' => $namespace,
            'CLASS_NAME' => $name . 'Service',
            'MODEL_NAME' => $name,
            'MODEL_VARIABLE' => Str::camel($name),
        ]);
        
        $path = app_path("Services/{$name}Service.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $stub);
        
        return $path;
    }

    /**
     * Generate a seeder file.
     */
    protected function generateSeeder(string $name, array $config): string
    {
        $stubPath = $this->getStubPath('seeders/seeder.stub');
        
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceTokens($stub, [
            'CLASS_NAME' => $name . 'Seeder',
            'MODEL_NAME' => $name,
        ]);
        
        $path = database_path("seeders/{$name}Seeder.php");
        $this->ensureDirectoryExists(dirname($path));
        $this->files->put($path, $stub);
        
        return $path;
    }

    /**
     * Get the stub file path.
     */
    protected function getStubPath(string $stub): string
    {
        $publishedPath = resource_path("stubs/api-starter/{$stub}");
        
        if ($this->files->exists($publishedPath)) {
            return $publishedPath;
        }
        
        return __DIR__ . "/../stubs/{$stub}";
    }

    /**
     * Replace tokens in stub content.
     */
    protected function replaceTokens(string $stub, array $tokens): string
    {
        foreach ($tokens as $key => $value) {
            $stub = str_replace("{{ {$key} }}", $value, $stub);
        }
        
        return $stub;
    }

    /**
     * Ensure directory exists.
     */
    protected function ensureDirectoryExists(string $path): void
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }
    }
}