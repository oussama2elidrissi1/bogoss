# Bogos Land Wellness - Application Laravel Complète

Application Laravel complète avec frontend Blade et backend API.

## 🚀 Structure

- **Backend**: Laravel 10 (MVC + API REST)
- **Frontend**: Blade Templates + Tailwind CSS
- **Base de données**: MySQL

## 📦 Installation

### Prérequis
- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js 18+

### Étapes d'installation

1. **Installer les dépendances PHP**:
```bash
composer install
```

2. **Configurer l'environnement**:
```bash
# Le fichier .env devrait déjà exister
# Vérifiez la configuration de la base de données
```

3. **Générer la clé d'application** (si pas déjà fait):
```bash
php artisan key:generate
```

4. **Exécuter les migrations**:
```bash
php artisan migrate
```

5. **Charger les données de test**:
```bash
php artisan db:seed
```

6. **Installer les dépendances Node.js**:
```bash
npm install
```

7. **Compiler les assets**:
```bash
npm run dev
# ou pour la production:
npm run build
```

8. **Démarrer le serveur Laravel**:
```bash
php artisan serve
```

L'application sera disponible sur `http://localhost:8000`

## 🔐 Comptes par défaut

### Administrateur
- Email: `admin@bogosland.com`
- Password: `admin123`

## 📁 Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/        # Contrôleurs admin
│   │   ├── Client/       # Contrôleurs client
│   │   ├── Auth/         # Authentification
│   │   └── Api/          # API REST
│   └── Middleware/       # Middlewares
├── Models/               # Modèles Eloquent
resources/
├── views/
│   ├── layouts/          # Layouts Blade
│   ├── components/       # Composants Blade
│   ├── admin/            # Vues admin
│   ├── client/           # Vues client
│   └── auth/             # Vues authentification
├── css/                  # Styles CSS
└── js/                   # JavaScript
routes/
├── web.php               # Routes web (Blade)
└── api.php               # Routes API
```

## 🎯 Routes principales

### Web (Blade)
- `/` - Page d'accueil
- `/login` - Connexion
- `/register` - Inscription
- `/client/dashboard` - Tableau de bord client
- `/admin/dashboard` - Tableau de bord admin
- `/admin/clients` - Gestion clients
- `/admin/services` - Gestion services
- `/admin/bookings` - Gestion réservations
- `/admin/staff` - Gestion personnel
- `/admin/inventory` - Gestion inventaire

### API
- `/api/*` - Toutes les routes API REST

## 🎨 Fonctionnalités

### Frontend (Blade)
- ✅ Page d'accueil
- ✅ Authentification (login/register)
- ✅ Dashboard admin avec statistiques
- ✅ Gestion clients
- ✅ Gestion services
- ✅ Gestion réservations
- ✅ Gestion personnel
- ✅ Gestion inventaire
- ✅ Dashboard client

### Backend (API)
- ✅ API REST complète
- ✅ Authentification Sanctum
- ✅ CRUD pour toutes les ressources
- ✅ Analytics et statistiques

## 🛠️ Technologies utilisées

- Laravel 10
- Blade Templates
- Tailwind CSS
- Laravel Sanctum
- MySQL
- Vite

## 📝 Notes

- Les assets sont compilés avec Vite
- L'authentification utilise les sessions Laravel pour le web
- L'API utilise Laravel Sanctum pour l'authentification
- Toutes les pages admin nécessitent l'authentification et le rôle admin
