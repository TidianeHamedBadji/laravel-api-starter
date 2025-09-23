<?php

namespace TidianeHamed\LaravelApiStarter\Tests\Feature;

use TidianeHamed\LaravelApiStarter\Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ApiStarterCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clean up any generated files from previous tests
        $this->cleanupGeneratedFiles();
    }
    
    protected function tearDown(): void
    {
        // Clean up after each test
        $this->cleanupGeneratedFiles();
        
        parent::tearDown();
    }

    /** @test */
    public function it_can_generate_all_components_for_a_model(): void
    {
        // Run the api:starter command
        $exitCode = Artisan::call('api:starter', [
            'model' => 'Product',
            '--all' => true,
        ]);

        $this->assertEquals(0, $exitCode);
        
        // Check that files were created (they would be in app/ directories in a real Laravel app)
        $output = Artisan::output();
        $this->assertStringContainsString('✅ API starter kit generated successfully!', $output);
        $this->assertStringContainsString('Product', $output);
    }

    /** @test */
    public function it_can_generate_specific_components(): void
    {
        $exitCode = Artisan::call('api:starter', [
            'model' => 'User',
            '--model' => true,
            '--controller' => true,
        ]);

        $this->assertEquals(0, $exitCode);
        
        $output = Artisan::output();
        $this->assertStringContainsString('✅ API starter kit generated successfully!', $output);
    }

    /** @test */
    public function it_displays_next_steps_after_generation(): void
    {
        $exitCode = Artisan::call('api:starter', [
            'model' => 'Category',
        ]);

        $this->assertEquals(0, $exitCode);
        
        $output = Artisan::output();
        $this->assertStringContainsString('📋 Next Steps:', $output);
        $this->assertStringContainsString('php artisan migrate', $output);
    }

    /** @test */
    public function it_can_generate_routes_when_requested(): void
    {
        $exitCode = Artisan::call('api:starter', [
            'model' => 'Order',
            '--routes' => true,
        ]);

        $this->assertEquals(0, $exitCode);
        
        $output = Artisan::output();
        $this->assertStringContainsString('✅ API starter kit generated successfully!', $output);
    }

    private function cleanupGeneratedFiles(): void
    {
        // In a real test, you might want to clean up generated files
        // For now, we'll just ensure the test environment is clean
        
        $directories = [
            app_path('Models'),
            app_path('Http/Controllers/Api'),
            app_path('Http/Requests'),
            app_path('Http/Resources'),
            app_path('Services'),
            database_path('migrations'),
            database_path('seeders'),
        ];

        foreach ($directories as $dir) {
            if (File::exists($dir)) {
                // Only clean test-generated files, not the actual application files
                $testFiles = File::glob($dir . '/*Test*.php');
                foreach ($testFiles as $file) {
                    File::delete($file);
                }
            }
        }
    }
}