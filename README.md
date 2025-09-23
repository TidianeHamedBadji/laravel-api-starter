# Laravel API Starter

🚀 Laravel API Starter Kit - Bootstrap professional Laravel API applications with best practices and conventions. CLI tool for rapid API development.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tidiane-hamed/laravel-api-starter.svg?style=flat-square)](https://packagist.org/packages/tidiane-hamed/laravel-api-starter)
[![Total Downloads](https://img.shields.io/packagist/dt/tidiane-hamed/laravel-api-starter.svg?style=flat-square)](https://packagist.org/packages/tidiane-hamed/laravel-api-starter)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Features

- **🎯 One Command Generation**: Generate all API components with a single `php artisan api:starter` command
- **🏗️ Complete Architecture**: Models, Controllers, Requests, Resources, Services, and Seeders
- **📋 Professional Standards**: Follows Laravel best practices and clean architecture
- **🔧 Highly Configurable**: Customizable namespaces, API versioning, and component options
- **🚀 Multi-Version Support**: Compatible with Laravel 10+ and future versions
- **📚 Comprehensive Documentation**: Available in English and French
- **🔌 Extensible**: Easy to customize and extend for your specific needs

## Installation

### Via Composer (Recommended)

```bash
composer require tidiane-hamed/laravel-api-starter
```

### Via Standalone CLI

```bash
# Download the PHAR file
wget https://github.com/TidianeHamedBadji/laravel-api-starter/releases/latest/download/laravel-api.phar

# Make it executable
chmod +x laravel-api.phar

# Use it globally
sudo mv laravel-api.phar /usr/local/bin/laravel-api
```

## Quick Start

### Basic Usage

Generate a complete API for a model with one command:

```bash
php artisan api:starter Product
```

This creates:
- 📄 `app/Models/Product.php` - Eloquent model with relationships
- 📄 `database/migrations/xxxx_create_products_table.php` - Database migration
- 📄 `app/Http/Controllers/Api/ProductController.php` - API controller with CRUD operations
- 📄 `app/Http/Requests/ProductRequest.php` - Form request for validation
- 📄 `app/Http/Resources/ProductResource.php` - API resource for data transformation
- 📄 `app/Services/ProductService.php` - Service layer for business logic
- 📄 `database/seeders/ProductSeeder.php` - Database seeder

### Advanced Usage

Generate specific components:

```bash
# Generate only model and controller
php artisan api:starter Product --model --controller

# Generate all components
php artisan api:starter Product --all

# Generate with routes
php artisan api:starter Product --all --routes
```

### Standalone Usage

Outside of Laravel projects:

```bash
# Generate components to a directory
laravel-api generate Product --output ./my-api

# Generate specific components
laravel-api generate User --model --controller --output ./generated
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=api-starter-config
```

Customize in `config/api-starter.php`:

```php
<?php

return [
    // Customize namespaces
    'model_namespace' => 'App\\Models',
    'controller_namespace' => 'App\\Http\\Controllers\\Api',
    'service_namespace' => 'App\\Services',
    
    // API Versioning
    'api_versioning' => [
        'enabled' => true,
        'default_version' => 'v1',
        'prefix' => 'api',
    ],
    
    // Database options
    'database' => [
        'soft_deletes' => true,
        'timestamps' => true,
        'uuid_primary_key' => false,
    ],
    
    // Authentication
    'authentication' => [
        'enabled' => true,
        'middleware' => ['auth:sanctum'],
    ],
];
```

## Generated Components

### Model (`app/Models/Product.php`)

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'description', 'status'];
    protected $casts = ['status' => 'boolean'];
    
    // Relationships, scopes, and methods...
}
```

### Controller (`app/Http/Controllers/Api/ProductController.php`)

Full REST API controller with:
- ✅ Index with pagination and filtering
- ✅ Store with validation
- ✅ Show individual resources
- ✅ Update with validation
- ✅ Delete (soft delete)
- ✅ Restore functionality
- ✅ Force delete option

### Service Layer (`app/Services/ProductService.php`)

Business logic abstraction with:
- ✅ CRUD operations
- ✅ Caching support
- ✅ Event handling
- ✅ Transaction management
- ✅ Error handling and logging

### API Resources (`app/Http/Resources/ProductResource.php`)

Data transformation with:
- ✅ Consistent response format
- ✅ Relationship loading
- ✅ Conditional fields
- ✅ Metadata inclusion

## API Endpoints

After generation, your API will have these endpoints:

```
GET    /api/products       # List all products (paginated)
POST   /api/products       # Create a new product
GET    /api/products/{id}  # Show a specific product
PUT    /api/products/{id}  # Update a product
DELETE /api/products/{id}  # Delete a product (soft delete)
```

### Example API Response

```json
{
  "data": {
    "id": 1,
    "name": "Sample Product",
    "description": "A sample product description",
    "status": true,
    "status_label": "Active",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
  },
  "meta": {
    "version": "1.0",
    "api_documentation": "https://yourapp.com/docs/api"
  }
}
```

## Customization

### Custom Stubs

Publish and customize the stub templates:

```bash
php artisan vendor:publish --tag=api-starter-stubs
```

Edit templates in `resources/stubs/api-starter/`:
- `models/model.stub`
- `controllers/api_controller.stub`
- `requests/form_request.stub`
- `resources/api_resource.stub`
- `services/service.stub`
- `seeders/seeder.stub`

### Custom Namespaces

```php
// config/api-starter.php
'model_namespace' => 'Domain\\Products\\Models',
'controller_namespace' => 'Domain\\Products\\Controllers',
'service_namespace' => 'Domain\\Products\\Services',
```

### API Versioning

```php
// config/api-starter.php
'api_versioning' => [
    'enabled' => true,
    'default_version' => 'v2',
    'prefix' => 'api',
],
```

This generates controllers in `App\Http\Controllers\Api\V2\` namespace.

## Command Options

| Option | Description |
|--------|-------------|
| `--all` | Generate all components |
| `--model` | Generate model only |
| `--migration` | Generate migration only |
| `--controller` | Generate controller only |
| `--request` | Generate form request only |
| `--resource` | Generate API resource only |
| `--service` | Generate service only |
| `--seeder` | Generate seeder only |
| `--routes` | Add routes to api.php |
| `--force` | Overwrite existing files |

## Best Practices

### 1. Follow RESTful Conventions

The generated controllers follow REST conventions:
- Use proper HTTP methods (GET, POST, PUT, DELETE)
- Return appropriate HTTP status codes
- Use resource-based URLs

### 2. Service Layer Pattern

Business logic is abstracted into service classes:

```php
// In your controller
public function store(ProductRequest $request)
{
    $product = $this->productService->create($request->validated());
    return new ProductResource($product);
}

// In your service
public function create(array $data): Product
{
    // Business logic, validation, events, etc.
    return Product::create($data);
}
```

### 3. Resource Transformation

Use API resources for consistent data formatting:

```php
// ProductResource.php
public function toArray($request)
{
    return [
        'id' => $this->id,
        'name' => $this->name,
        'price' => $this->when($this->price, $this->price),
        'category' => new CategoryResource($this->whenLoaded('category')),
    ];
}
```

### 4. Validation

Form requests handle validation and authorization:

```php
// ProductRequest.php
public function rules()
{
    return [
        'name' => 'required|string|max:255|unique:products,name',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
    ];
}
```

## Testing

Run the package tests:

```bash
composer test
```

Test your generated APIs:

```bash
# Test with curl
curl -X GET http://localhost/api/products \
  -H "Accept: application/json" \
  -H "Authorization: Bearer your-token"

# Test with Postman
# Import the generated Postman collection (if available)
```

## Integration Examples

### With Laravel Sanctum

```php
// In your generated controller
public function __construct(ProductService $productService)
{
    $this->middleware('auth:sanctum');
    $this->productService = $productService;
}
```

### With Laravel Passport

```php
// config/api-starter.php
'authentication' => [
    'enabled' => true,
    'middleware' => ['auth:api'],
],
```

### With API Rate Limiting

```php
// In RouteServiceProvider or api.php
Route::middleware(['throttle:api'])->group(function () {
    Route::apiResource('products', ProductController::class);
});
```

## Troubleshooting

### Common Issues

1. **Permission Denied**: Ensure your Laravel project has proper write permissions
2. **Class Not Found**: Run `composer dump-autoload` after generation
3. **Migration Issues**: Check database configuration and run `php artisan migrate`

### Debug Mode

Enable debug output:

```bash
php artisan api:starter Product --all -v
```

### Getting Help

- 📖 [Full Documentation](https://github.com/TidianeHamedBadji/laravel-api-starter/wiki)
- 🐛 [Report Issues](https://github.com/TidianeHamedBadji/laravel-api-starter/issues)
- 💬 [Discussions](https://github.com/TidianeHamedBadji/laravel-api-starter/discussions)

## Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

### Development Setup

```bash
# Clone the repository
git clone https://github.com/TidianeHamedBadji/laravel-api-starter.git

# Install dependencies
composer install

# Run tests
composer test

# Run code style checks
composer format
```

## Changelog

Please see [CHANGELOG.md](CHANGELOG.md) for recent changes.

## Security

If you discover any security-related issues, please email tidiane.hamedbadji@gmail.com instead of using the issue tracker.

## Credits

- [Tidiane Hamed Badji](https://github.com/TidianeHamedBadji) - Creator and maintainer
- [All Contributors](https://github.com/TidianeHamedBadji/laravel-api-starter/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

---

## 📖 Documentation Française

[Version française de la documentation](README_FR.md)
