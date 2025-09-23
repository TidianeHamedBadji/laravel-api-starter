<?php

namespace TidianeHamed\LaravelApiStarter\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Standalone command for generating API components outside Laravel
 */
class StandaloneGenerateCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('generate')
            ->setDescription('Generate Laravel API components')
            ->addArgument('model', InputArgument::REQUIRED, 'The name of the model')
            ->addOption('all', null, InputOption::VALUE_NONE, 'Generate all components')
            ->addOption('model', null, InputOption::VALUE_NONE, 'Generate model')
            ->addOption('migration', null, InputOption::VALUE_NONE, 'Generate migration')
            ->addOption('controller', null, InputOption::VALUE_NONE, 'Generate controller')
            ->addOption('request', null, InputOption::VALUE_NONE, 'Generate form request')
            ->addOption('resource', null, InputOption::VALUE_NONE, 'Generate API resource')
            ->addOption('service', null, InputOption::VALUE_NONE, 'Generate service')
            ->addOption('seeder', null, InputOption::VALUE_NONE, 'Generate seeder')
            ->addOption('output', 'o', InputOption::VALUE_OPTIONAL, 'Output directory', './generated');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $modelName = $input->getArgument('model');
        $outputDir = $input->getOption('output');
        
        $io->title('🚀 Laravel API Starter - Standalone Generator');
        $io->info("Generating API components for: {$modelName}");
        
        // Create output directory if it doesn't exist
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }
        
        $components = $this->getComponentsToGenerate($input);
        $generated = [];
        
        foreach ($components as $component => $generate) {
            if ($generate) {
                $io->text("Generating {$component}...");
                $filePath = $this->generateComponent($component, $modelName, $outputDir);
                $generated[$component] = $filePath;
            }
        }
        
        $io->newLine();
        $io->success('API components generated successfully!');
        
        // Display generated files
        $io->section('Generated Files:');
        foreach ($generated as $component => $path) {
            $io->writeln("📄 {$component}: <info>{$path}</info>");
        }
        
        $io->newLine();
        $io->note([
            'Copy the generated files to your Laravel project',
            'Customize the files according to your requirements',
            'Run migrations and update your routes'
        ]);
        
        return Command::SUCCESS;
    }
    
    private function getComponentsToGenerate(InputInterface $input): array
    {
        $components = [
            'model' => false,
            'migration' => false,
            'controller' => false,
            'request' => false,
            'resource' => false,
            'service' => false,
            'seeder' => false,
        ];
        
        if ($input->getOption('all')) {
            return array_map(fn() => true, $components);
        }
        
        $hasSpecific = false;
        foreach (array_keys($components) as $component) {
            if ($input->getOption($component)) {
                $components[$component] = true;
                $hasSpecific = true;
            }
        }
        
        // If no specific options, generate all
        if (!$hasSpecific) {
            return array_map(fn() => true, $components);
        }
        
        return $components;
    }
    
    private function generateComponent(string $component, string $modelName, string $outputDir): string
    {
        $stubsDir = __DIR__ . '/../../stubs';
        $stubMap = [
            'model' => 'models/model.stub',
            'migration' => 'migrations/create_table.stub',
            'controller' => 'controllers/api_controller.stub',
            'request' => 'requests/form_request.stub',
            'resource' => 'resources/api_resource.stub',
            'service' => 'services/service.stub',
            'seeder' => 'seeders/seeder.stub',
        ];
        
        $stubPath = $stubsDir . '/' . $stubMap[$component];
        $stub = file_get_contents($stubPath);
        
        // Replace placeholders
        $replacements = $this->getComponentReplacements($component, $modelName);
        $stub = $this->replaceTokens($stub, $replacements);
        
        // Determine output path
        $filename = $this->getOutputFilename($component, $modelName);
        $outputPath = $outputDir . '/' . $filename;
        
        // Create directory if needed
        $dir = dirname($outputPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents($outputPath, $stub);
        
        return $outputPath;
    }
    
    private function getReplacements(string $modelName): array
    {
        $studlyName = ucfirst($modelName);
        $snakeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $modelName));
        $pluralName = $studlyName . 's'; // Simple pluralization
        $camelName = lcfirst($studlyName);
        $tableName = $snakeName . 's';
        
        return [
            'NAMESPACE' => 'App\\Models',
            'CONTROLLER_NAMESPACE' => 'App\\Http\\Controllers\\Api',
            'REQUEST_NAMESPACE' => 'App\\Http\\Requests',
            'RESOURCE_NAMESPACE' => 'App\\Http\\Resources', 
            'SERVICE_NAMESPACE' => 'App\\Services',
            'CLASS_NAME' => $studlyName,
            'MODEL_NAME' => $studlyName,
            'MODEL_VARIABLE' => $camelName,
            'PLURAL_VARIABLE' => lcfirst($pluralName),
            'TABLE_NAME' => $tableName,
        ];
    }
    
    private function getComponentReplacements(string $component, string $modelName): array
    {
        $base = $this->getReplacements($modelName);
        
        return match ($component) {
            'controller' => array_merge($base, [
                'NAMESPACE' => $base['CONTROLLER_NAMESPACE'],
                'CLASS_NAME' => $modelName . 'Controller',
            ]),
            'request' => array_merge($base, [
                'NAMESPACE' => $base['REQUEST_NAMESPACE'],
                'CLASS_NAME' => $modelName . 'Request',
            ]),
            'resource' => array_merge($base, [
                'NAMESPACE' => $base['RESOURCE_NAMESPACE'],
                'CLASS_NAME' => $modelName . 'Resource',
            ]),
            'service' => array_merge($base, [
                'NAMESPACE' => $base['SERVICE_NAMESPACE'],
                'CLASS_NAME' => $modelName . 'Service',
            ]),
            'seeder' => array_merge($base, [
                'CLASS_NAME' => $modelName . 'Seeder',
            ]),
            default => $base,
        };
    }
    
    private function replaceTokens(string $stub, array $tokens): string
    {
        foreach ($tokens as $key => $value) {
            $stub = str_replace("{{ {$key} }}", $value, $stub);
        }
        return $stub;
    }
    
    private function getOutputFilename(string $component, string $modelName): string
    {
        $studlyName = ucfirst($modelName);
        $snakeName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $modelName));
        $tableName = $snakeName . 's';
        
        return match ($component) {
            'model' => "models/{$studlyName}.php",
            'migration' => "migrations/" . date('Y_m_d_His') . "_create_{$tableName}_table.php",
            'controller' => "controllers/{$studlyName}Controller.php",
            'request' => "requests/{$studlyName}Request.php",
            'resource' => "resources/{$studlyName}Resource.php",
            'service' => "services/{$studlyName}Service.php",
            'seeder' => "seeders/{$studlyName}Seeder.php",
            default => "{$component}/{$studlyName}.php",
        };
    }
}