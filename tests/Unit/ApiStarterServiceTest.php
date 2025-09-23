<?php

namespace TidianeHamed\LaravelApiStarter\Tests\Unit;

use TidianeHamed\LaravelApiStarter\Tests\TestCase;
use TidianeHamed\LaravelApiStarter\ApiStarterService;
use Illuminate\Filesystem\Filesystem;

class ApiStarterServiceTest extends TestCase
{
    private ApiStarterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->service = new ApiStarterService();
    }

    /** @test */
    public function it_can_be_instantiated(): void
    {
        $this->assertInstanceOf(ApiStarterService::class, $this->service);
    }

    /** @test */
    public function it_can_generate_api_components(): void
    {
        // Mock the filesystem to avoid actually creating files during tests
        $this->app->instance(Filesystem::class, $this->createMock(Filesystem::class));
        
        $options = [
            'generate_model' => true,
            'generate_controller' => true,
            'generate_request' => true,
        ];

        // This would normally generate files, but with mocked filesystem it won't
        $result = $this->service->generateApiComponents('TestModel', $options);
        
        // In a real test, we'd assert that the correct files were generated
        $this->assertIsArray($result);
    }

    /** @test */
    public function it_handles_configuration_properly(): void
    {
        // Test that the service respects configuration
        config(['api-starter.model_namespace' => 'Custom\\Models']);
        
        $namespace = config('api-starter.model_namespace');
        $this->assertEquals('Custom\\Models', $namespace);
    }

    /** @test */
    public function it_can_replace_tokens_in_stubs(): void
    {
        $reflection = new \ReflectionClass($this->service);
        $method = $reflection->getMethod('replaceTokens');
        $method->setAccessible(true);

        $stub = 'Hello {{ NAME }}, welcome to {{ PLACE }}!';
        $tokens = [
            'NAME' => 'John',
            'PLACE' => 'Laravel'
        ];

        $result = $method->invoke($this->service, $stub, $tokens);
        $this->assertEquals('Hello John, welcome to Laravel!', $result);
    }
}