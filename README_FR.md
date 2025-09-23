# Laravel API Starter

🚀 Kit de démarrage API Laravel - Créez des applications API Laravel professionnelles avec les meilleures pratiques et conventions. Outil CLI pour un développement API rapide.

[![Dernière Version sur Packagist](https://img.shields.io/packagist/v/tidiane-hamed/laravel-api-starter.svg?style=flat-square)](https://packagist.org/packages/tidiane-hamed/laravel-api-starter)
[![Téléchargements Totaux](https://img.shields.io/packagist/dt/tidiane-hamed/laravel-api-starter.svg?style=flat-square)](https://packagist.org/packages/tidiane-hamed/laravel-api-starter)
[![Licence MIT](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

## Fonctionnalités

- **🎯 Génération en Une Commande**: Générez tous les composants API avec une seule commande `php artisan api:starter`
- **🏗️ Architecture Complète**: Modèles, Contrôleurs, Requêtes, Ressources, Services et Seeders
- **📋 Standards Professionnels**: Suit les meilleures pratiques Laravel et l'architecture propre
- **🔧 Hautement Configurable**: Espaces de noms personnalisables, versioning API et options de composants
- **🚀 Support Multi-Version**: Compatible avec Laravel 10+ et les versions futures
- **📚 Documentation Complète**: Disponible en français et anglais
- **🔌 Extensible**: Facile à personnaliser et étendre selon vos besoins

## Installation

### Via Composer (Recommandé)

```bash
composer require tidiane-hamed/laravel-api-starter
```

### Via CLI Autonome

```bash
# Télécharger le fichier PHAR
wget https://github.com/TidianeHamedBadji/laravel-api-starter/releases/latest/download/laravel-api.phar

# Le rendre exécutable
chmod +x laravel-api.phar

# L'utiliser globalement
sudo mv laravel-api.phar /usr/local/bin/laravel-api
```

## Démarrage Rapide

### Utilisation de Base

Générez une API complète pour un modèle avec une commande :

```bash
php artisan api:starter Product
```

Cela crée :
- 📄 `app/Models/Product.php` - Modèle Eloquent avec relations
- 📄 `database/migrations/xxxx_create_products_table.php` - Migration de base de données
- 📄 `app/Http/Controllers/Api/ProductController.php` - Contrôleur API avec opérations CRUD
- 📄 `app/Http/Requests/ProductRequest.php` - Requête de formulaire pour la validation
- 📄 `app/Http/Resources/ProductResource.php` - Ressource API pour la transformation des données
- 📄 `app/Services/ProductService.php` - Couche de service pour la logique métier
- 📄 `database/seeders/ProductSeeder.php` - Seeder de base de données

### Utilisation Avancée

Générez des composants spécifiques :

```bash
# Générer seulement le modèle et le contrôleur
php artisan api:starter Product --model --controller

# Générer tous les composants
php artisan api:starter Product --all

# Générer avec les routes
php artisan api:starter Product --all --routes
```

### Utilisation Autonome

En dehors des projets Laravel :

```bash
# Générer les composants vers un répertoire
laravel-api generate Product --output ./mon-api

# Générer des composants spécifiques
laravel-api generate User --model --controller --output ./genere
```

## Configuration

Publiez le fichier de configuration :

```bash
php artisan vendor:publish --tag=api-starter-config
```

Personnalisez dans `config/api-starter.php` :

```php
<?php

return [
    // Personnaliser les espaces de noms
    'model_namespace' => 'App\\Models',
    'controller_namespace' => 'App\\Http\\Controllers\\Api',
    'service_namespace' => 'App\\Services',
    
    // Versioning API
    'api_versioning' => [
        'enabled' => true,
        'default_version' => 'v1',
        'prefix' => 'api',
    ],
    
    // Options de base de données
    'database' => [
        'soft_deletes' => true,
        'timestamps' => true,
        'uuid_primary_key' => false,
    ],
    
    // Authentification
    'authentication' => [
        'enabled' => true,
        'middleware' => ['auth:sanctum'],
    ],
];
```

## Composants Générés

### Modèle (`app/Models/Product.php`)

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
    
    // Relations, scopes et méthodes...
}
```

### Contrôleur (`app/Http/Controllers/Api/ProductController.php`)

Contrôleur API REST complet avec :
- ✅ Index avec pagination et filtrage
- ✅ Store avec validation
- ✅ Show pour les ressources individuelles
- ✅ Update avec validation
- ✅ Delete (suppression douce)
- ✅ Fonctionnalité de restauration
- ✅ Option de suppression forcée

### Couche de Service (`app/Services/ProductService.php`)

Abstraction de la logique métier avec :
- ✅ Opérations CRUD
- ✅ Support de mise en cache
- ✅ Gestion des événements
- ✅ Gestion des transactions
- ✅ Gestion d'erreurs et journalisation

### Ressources API (`app/Http/Resources/ProductResource.php`)

Transformation des données avec :
- ✅ Format de réponse cohérent
- ✅ Chargement des relations
- ✅ Champs conditionnels
- ✅ Inclusion de métadonnées

## Points de Terminaison API

Après génération, votre API aura ces points de terminaison :

```
GET    /api/products       # Lister tous les produits (paginé)
POST   /api/products       # Créer un nouveau produit
GET    /api/products/{id}  # Afficher un produit spécifique
PUT    /api/products/{id}  # Mettre à jour un produit
DELETE /api/products/{id}  # Supprimer un produit (suppression douce)
```

### Exemple de Réponse API

```json
{
  "data": {
    "id": 1,
    "name": "Produit Exemple",
    "description": "Description d'un produit exemple",
    "status": true,
    "status_label": "Actif",
    "created_at": "2024-01-15T10:30:00.000000Z",
    "updated_at": "2024-01-15T10:30:00.000000Z"
  },
  "meta": {
    "version": "1.0",
    "api_documentation": "https://votreapp.com/docs/api"
  }
}
```

## Personnalisation

### Modèles Personnalisés

Publiez et personnalisez les modèles de gabarits :

```bash
php artisan vendor:publish --tag=api-starter-stubs
```

Modifiez les modèles dans `resources/stubs/api-starter/` :
- `models/model.stub`
- `controllers/api_controller.stub`
- `requests/form_request.stub`
- `resources/api_resource.stub`
- `services/service.stub`
- `seeders/seeder.stub`

### Espaces de Noms Personnalisés

```php
// config/api-starter.php
'model_namespace' => 'Domain\\Products\\Models',
'controller_namespace' => 'Domain\\Products\\Controllers',
'service_namespace' => 'Domain\\Products\\Services',
```

### Versioning API

```php
// config/api-starter.php
'api_versioning' => [
    'enabled' => true,
    'default_version' => 'v2',
    'prefix' => 'api',
],
```

Cela génère des contrôleurs dans l'espace de noms `App\Http\Controllers\Api\V2\`.

## Options de Commande

| Option | Description |
|--------|-------------|
| `--all` | Générer tous les composants |
| `--model` | Générer seulement le modèle |
| `--migration` | Générer seulement la migration |
| `--controller` | Générer seulement le contrôleur |
| `--request` | Générer seulement la requête de formulaire |
| `--resource` | Générer seulement la ressource API |
| `--service` | Générer seulement le service |
| `--seeder` | Générer seulement le seeder |
| `--routes` | Ajouter les routes à api.php |
| `--force` | Écraser les fichiers existants |

## Meilleures Pratiques

### 1. Suivre les Conventions RESTful

Les contrôleurs générés suivent les conventions REST :
- Utiliser les méthodes HTTP appropriées (GET, POST, PUT, DELETE)
- Retourner les codes de statut HTTP appropriés
- Utiliser des URLs basées sur les ressources

### 2. Modèle de Couche de Service

La logique métier est abstraite dans les classes de service :

```php
// Dans votre contrôleur
public function store(ProductRequest $request)
{
    $product = $this->productService->create($request->validated());
    return new ProductResource($product);
}

// Dans votre service
public function create(array $data): Product
{
    // Logique métier, validation, événements, etc.
    return Product::create($data);
}
```

### 3. Transformation des Ressources

Utilisez les ressources API pour un formatage de données cohérent :

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

Les requêtes de formulaire gèrent la validation et l'autorisation :

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

## Tests

Exécutez les tests du package :

```bash
composer test
```

Testez vos APIs générées :

```bash
# Test avec curl
curl -X GET http://localhost/api/products \
  -H "Accept: application/json" \
  -H "Authorization: Bearer votre-token"

# Test avec Postman
# Importez la collection Postman générée (si disponible)
```

## Exemples d'Intégration

### Avec Laravel Sanctum

```php
// Dans votre contrôleur généré
public function __construct(ProductService $productService)
{
    $this->middleware('auth:sanctum');
    $this->productService = $productService;
}
```

### Avec Laravel Passport

```php
// config/api-starter.php
'authentication' => [
    'enabled' => true,
    'middleware' => ['auth:api'],
],
```

### Avec Limitation de Débit API

```php
// Dans RouteServiceProvider ou api.php
Route::middleware(['throttle:api'])->group(function () {
    Route::apiResource('products', ProductController::class);
});
```

## Dépannage

### Problèmes Courants

1. **Permission Refusée** : Assurez-vous que votre projet Laravel a les permissions d'écriture appropriées
2. **Classe Non Trouvée** : Exécutez `composer dump-autoload` après génération
3. **Problèmes de Migration** : Vérifiez la configuration de la base de données et exécutez `php artisan migrate`

### Mode Debug

Activez la sortie de débogage :

```bash
php artisan api:starter Product --all -v
```

### Obtenir de l'Aide

- 📖 [Documentation Complète](https://github.com/TidianeHamedBadji/laravel-api-starter/wiki)
- 🐛 [Signaler des Problèmes](https://github.com/TidianeHamedBadji/laravel-api-starter/issues)
- 💬 [Discussions](https://github.com/TidianeHamedBadji/laravel-api-starter/discussions)

## Contribution

Nous accueillons les contributions ! Veuillez consulter [CONTRIBUTING.md](CONTRIBUTING.md) pour plus de détails.

### Configuration de Développement

```bash
# Cloner le dépôt
git clone https://github.com/TidianeHamedBadji/laravel-api-starter.git

# Installer les dépendances
composer install

# Exécuter les tests
composer test

# Exécuter les vérifications de style de code
composer format
```

## Journal des Modifications

Veuillez consulter [CHANGELOG.md](CHANGELOG.md) pour les changements récents.

## Sécurité

Si vous découvrez des problèmes liés à la sécurité, veuillez envoyer un email à tidiane.hamedbadji@gmail.com au lieu d'utiliser le tracker de problèmes.

## Crédits

- [Tidiane Hamed Badji](https://github.com/TidianeHamedBadji) - Créateur et mainteneur
- [Tous les Contributeurs](https://github.com/TidianeHamedBadji/laravel-api-starter/contributors)

## Licence

La Licence MIT (MIT). Veuillez consulter le [Fichier de Licence](LICENSE) pour plus d'informations.

---

## 📖 English Documentation

[English version of documentation](README.md)