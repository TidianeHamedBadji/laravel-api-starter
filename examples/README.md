# Laravel API Starter Examples

This directory contains example configurations and integration files for common use cases.

## Files in this directory:

- `api-routes-example.php` - Example API routes file
- `postman-collection.json` - Postman collection for testing generated APIs
- `laravel-integration.md` - Step-by-step integration guide
- `docker-setup/` - Docker configuration for API development

## Quick Examples

### 1. Basic Product API

```bash
php artisan api:starter Product --all --routes
```

This generates a complete Product API with all CRUD operations.

### 2. Multi-Model E-commerce API

```bash
php artisan api:starter Category --all
php artisan api:starter Product --all
php artisan api:starter Order --all
```

### 3. Blog API

```bash
php artisan api:starter Post --all
php artisan api:starter Comment --all
php artisan api:starter Tag --all
```

## Testing Generated APIs

Use the included Postman collection or curl commands:

```bash
# List products
curl -X GET http://localhost/api/products \
  -H "Accept: application/json" \
  -H "Authorization: Bearer your-token"

# Create product
curl -X POST http://localhost/api/products \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer your-token" \
  -d '{"name":"Test Product","description":"A test product","status":true}'
```