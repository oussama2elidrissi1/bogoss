# Bogos Land Wellness - Laravel Backend

Ce projet a été transformé en architecture Laravel + React.

## Structure

- **Backend**: Laravel 10 (API REST)
- **Frontend**: React + Vite (interface utilisateur)

## Installation

### Prérequis
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js 18+

### Backend Laravel

1. Installer les dépendances PHP:
```bash
composer install
```

2. Copier le fichier d'environnement:
```bash
cp .env.example .env
```

3. Générer la clé d'application:
```bash
php artisan key:generate
```

4. Configurer la base de données dans `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bogos_land
DB_USERNAME=root
DB_PASSWORD=
```

5. Exécuter les migrations:
```bash
php artisan migrate
```

6. (Optionnel) Charger les données de test:
```bash
php artisan db:seed
```

7. Démarrer le serveur Laravel:
```bash
php artisan serve
```

Le serveur API sera disponible sur `http://localhost:8000`

### Frontend React

1. Installer les dépendances:
```bash
npm install
```

2. Créer un fichier `.env` à la racine du projet:
```env
VITE_API_URL=http://localhost:8000/api
```

3. Démarrer le serveur de développement:
```bash
npm run dev
```

Le frontend sera disponible sur `http://localhost:5173`

## API Endpoints

### Authentification
- `POST /api/login` - Connexion
- `POST /api/register` - Inscription
- `POST /api/logout` - Déconnexion

### Ressources
- `GET /api/clients` - Liste des clients
- `POST /api/clients` - Créer un client
- `GET /api/clients/{id}` - Détails d'un client
- `PUT /api/clients/{id}` - Modifier un client
- `DELETE /api/clients/{id}` - Supprimer un client

- `GET /api/services` - Liste des services
- `POST /api/services` - Créer un service
- `GET /api/services/{id}` - Détails d'un service
- `PUT /api/services/{id}` - Modifier un service
- `DELETE /api/services/{id}` - Supprimer un service

- `GET /api/bookings` - Liste des réservations
- `POST /api/bookings` - Créer une réservation
- `GET /api/bookings/{id}` - Détails d'une réservation
- `PUT /api/bookings/{id}` - Modifier une réservation
- `DELETE /api/bookings/{id}` - Supprimer une réservation

- `GET /api/staff` - Liste du personnel
- `POST /api/staff` - Ajouter un membre du personnel
- `GET /api/staff/{id}` - Détails d'un membre
- `PUT /api/staff/{id}` - Modifier un membre
- `DELETE /api/staff/{id}` - Supprimer un membre

- `GET /api/inventory` - Liste de l'inventaire
- `POST /api/inventory` - Ajouter un article
- `GET /api/inventory/{id}` - Détails d'un article
- `PUT /api/inventory/{id}` - Modifier un article
- `DELETE /api/inventory/{id}` - Supprimer un article

- `GET /api/products` - Liste des produits
- `POST /api/products` - Créer un produit
- `GET /api/products/{id}` - Détails d'un produit
- `PUT /api/products/{id}` - Modifier un produit
- `DELETE /api/products/{id}` - Supprimer un produit

- `GET /api/promotions` - Liste des promotions
- `POST /api/promotions` - Créer une promotion
- `GET /api/promotions/{id}` - Détails d'une promotion
- `PUT /api/promotions/{id}` - Modifier une promotion
- `DELETE /api/promotions/{id}` - Supprimer une promotion

- `GET /api/subscriptions` - Liste des abonnements
- `POST /api/subscriptions` - Créer un abonnement
- `GET /api/subscriptions/{id}` - Détails d'un abonnement
- `PUT /api/subscriptions/{id}` - Modifier un abonnement
- `DELETE /api/subscriptions/{id}` - Supprimer un abonnement

### Analytics
- `GET /api/analytics/dashboard` - Statistiques du tableau de bord
- `GET /api/analytics/revenue` - Statistiques de revenus
- `GET /api/analytics/top-services` - Services les plus populaires

## Authentification

L'API utilise Laravel Sanctum pour l'authentification. Les tokens sont envoyés dans le header:
```
Authorization: Bearer {token}
```

## Base de données

Les tables créées:
- `users` - Utilisateurs
- `clients` - Clients
- `services` - Services
- `staff` - Personnel
- `bookings` - Réservations
- `inventory` - Inventaire
- `products` - Produits boutique
- `promotions` - Promotions
- `subscriptions` - Abonnements
- `personal_access_tokens` - Tokens d'authentification

## Notes

- Le frontend React a été adapté pour utiliser l'API Laravel au lieu des données mockées
- Toutes les opérations CRUD sont maintenant gérées par le backend
- L'authentification est gérée par Laravel Sanctum
