# Guide de référence rapide - Système de réservation

## 🚀 Démarrage rapide

### Étape 1: Exécuter les migrations
```bash
php artisan migrate
```

### Étape 2: Seeder les options de service (optionnel)
```bash
php artisan db:seed --class=ServiceOptionsSeeder
```

### Étape 3: Tester les endpoints
Utilisez le fichier `api_tests.http` avec une extension REST Client (VS Code).

---

## 📦 Modèles Eloquent

### Service
```php
use App\Models\Service;

// Récupérer un service avec ses options
$service = Service::with('availableOptions')->find(1);

// Options disponibles
$options = $service->availableOptions;

// Options requises
$required = $service->requiredOptions;

// Staff associés
$staff = $service->staff;
```

### ServiceOption
```php
use App\Models\ServiceOption;

// Créer une option
ServiceOption::create([
    'service_id' => 1,
    'name' => 'Huile premium',
    'price' => 10.00,
    'duration' => 0,
    'is_required' => false,
    'available' => true,
    'max_quantity' => 1,
]);
```

### Booking
```php
use App\Models\Booking;

// Récupérer une réservation complète
$booking = Booking::with(['items.options', 'items.service', 'items.staff'])
    ->find(1);

// Calculer et mettre à jour les totaux
$booking->updateTotals();

// Accéder aux items
foreach ($booking->items as $item) {
    echo $item->service_name;
    echo $item->total;
}
```

### BookingItem
```php
use App\Models\BookingItem;

$item = BookingItem::with('options')->find(1);

// Calculer les totaux
$subtotal = $item->calculateSubtotal();
$total = $item->calculateTotal();
$duration = $item->calculateTotalDuration();
$payout = $item->calculateStaffPayout();
```

---

## 🔧 Utiliser BookingService

```php
use App\Services\BookingService;
use App\Models\Client;

$bookingService = app(BookingService::class);

// Preview des totaux
$preview = $bookingService->calculateCartTotals([
    [
        'service_id' => 1,
        'quantity' => 1,
        'options' => [
            ['option_id' => 1, 'quantity' => 1],
        ],
    ],
]);

// Créer une réservation
$booking = $bookingService->createBooking([
    'date' => '2026-02-01',
    'time' => '14:00',
    'notes' => 'Test',
    'items' => [
        [
            'service_id' => 1,
            'staff_id' => 1,
            'quantity' => 1,
            'options' => [
                ['option_id' => 1, 'quantity' => 1],
            ],
        ],
    ],
], $client);
```

---

## 🧪 Tests manuels

### 1. Créer des options pour un service
```bash
php artisan tinker
```

```php
$service = \App\Models\Service::first();

\App\Models\ServiceOption::create([
    'service_id' => $service->id,
    'name' => 'Option Test',
    'description' => 'Une option de test',
    'price' => 15.00,
    'duration' => 10,
    'is_required' => false,
    'available' => true,
    'max_quantity' => 2,
    'sort_order' => 1,
]);
```

### 2. Tester le calcul des totaux
```php
$bookingService = app(\App\Services\BookingService::class);

$totals = $bookingService->calculateCartTotals([
    [
        'service_id' => 1,
        'quantity' => 1,
        'options' => [
            ['option_id' => 1, 'quantity' => 1],
        ],
    ],
]);

dd($totals);
```

---

## 📊 Schéma relationnel

```
bookings
    ↓ hasMany
booking_items
    ↓ hasMany
booking_item_options

booking_items → belongsTo → services
booking_items → belongsTo → staff
booking_item_options → belongsTo → service_options
services → hasMany → service_options
```

---

## ⚡ Commandes utiles

### Créer un contrôleur API
```bash
php artisan make:controller Api/BookingApiController
```

### Créer un Request
```bash
php artisan make:request StoreBookingRequest
```

### Créer une Resource
```bash
php artisan make:resource BookingResource
```

### Créer un Service
```bash
mkdir -p app/Services
# Puis créer manuellement BookingService.php
```

### Migration rollback
```bash
php artisan migrate:rollback --step=4
```

### Fresh migration avec seed
```bash
php artisan migrate:fresh --seed
```

---

## 🐛 Debug

### Activer les logs SQL
```php
// Dans AppServiceProvider::boot()
\DB::listen(function ($query) {
    \Log::info($query->sql, $query->bindings);
});
```

### Vérifier une réservation
```bash
php artisan tinker
```

```php
$booking = \App\Models\Booking::with(['items.options'])->latest()->first();
dd($booking->toArray());
```

---

## 📝 Checklist avant déploiement

- [ ] Migrations exécutées
- [ ] Seeders exécutés (si nécessaire)
- [ ] Routes API testées
- [ ] Validation testée
- [ ] Calculs de totaux vérifiés
- [ ] Commission staff vérifiée
- [ ] Promotions testées
- [ ] Erreurs gérées correctement
- [ ] Documentation API à jour
- [ ] Tests unitaires écrits (optionnel)

---

## 🔐 Sécurité

### Middleware auth:sanctum
Toutes les routes sont protégées par `auth:sanctum`.

### Validation des options
Les options sont validées pour s'assurer qu'elles appartiennent au service.

### Vérification de disponibilité
Services et options non disponibles sont rejetés.

### Autorisation
Un client ne peut voir que ses propres réservations.

---

## 📞 Support

Pour toute question sur l'architecture:
- Voir `BOOKING_ARCHITECTURE.md` pour la documentation complète
- Consulter `api_tests.http` pour des exemples de requêtes
- Examiner `BookingService.php` pour la logique métier
