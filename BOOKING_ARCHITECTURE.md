# Architecture de Réservation avec Panier

## 📊 Structure de la base de données

### Tables principales

#### `services`
Services proposés par l'établissement.

```sql
- id
- name
- category
- duration (minutes)
- price
- description
- image
- available (boolean)
```

#### `service_options`
Options disponibles pour chaque service.

```sql
- id
- service_id (FK)
- name
- description
- price (prix additionnel)
- duration (durée additionnelle en minutes)
- is_required (boolean)
- available (boolean)
- max_quantity (nombre max sélectionnable)
- sort_order
```

#### `bookings`
Réservation globale (panier complet).

```sql
- id
- booking_reference (unique, ex: BK-65ABC123)
- client_id (FK)
- client_name
- date
- time
- subtotal (total avant réductions)
- discount_total (total des réductions)
- total (montant final)
- total_duration (durée totale en minutes)
- status (pending, confirmed, cancelled, completed)
- payment_status (pending, paid, refunded)
- payment_method
- notes
```

#### `booking_items`
Items individuels dans une réservation (chaque service réservé).

```sql
- id
- booking_id (FK)
- service_id (FK)
- service_name (dénormalisé pour historique)
- staff_id (FK, nullable)
- staff_name
- quantity
- unit_price (prix du service)
- duration (durée du service)
- options_total (total des options)
- subtotal ((unit_price + options_total) * quantity)
- discount_amount (réduction appliquée)
- total (subtotal - discount_amount)
- promotion_id (FK, nullable)
- promotion_code
- staff_payout_percentage
- staff_payout_amount
- notes
```

#### `booking_item_options`
Options sélectionnées pour chaque item.

```sql
- id
- booking_item_id (FK)
- service_option_id (FK)
- option_name (dénormalisé)
- quantity
- unit_price
- duration
- total (unit_price * quantity)
```

---

## 🔗 Endpoints API

### 1. Récupérer les services avec options

**GET** `/api/services`

**Query Parameters:**
- `category` (optional): Filtrer par catégorie
- `search` (optional): Recherche dans nom/description

**Response 200:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Massage Relaxant",
      "category": "Soins",
      "description": "Massage complet du corps pour une détente profonde",
      "price": 50.00,
      "duration": 60,
      "image": "/images/massage-relaxant.jpg",
      "available": true,
      "options": [
        {
          "id": 1,
          "name": "Huile essentielle de lavande",
          "description": "Huile relaxante pour améliorer l'expérience",
          "price": 10.00,
          "duration": 0,
          "is_required": false,
          "max_quantity": 1,
          "available": true
        },
        {
          "id": 2,
          "name": "Extension 30 minutes",
          "description": "Prolongez votre massage de 30 minutes",
          "price": 25.00,
          "duration": 30,
          "is_required": false,
          "max_quantity": 2,
          "available": true
        }
      ],
      "created_at": "2026-01-20T10:00:00Z"
    },
    {
      "id": 2,
      "name": "Hammam Traditionnel",
      "category": "Hammam",
      "description": "Séance de hammam avec gommage",
      "price": 40.00,
      "duration": 45,
      "image": "/images/hammam.jpg",
      "available": true,
      "options": [
        {
          "id": 3,
          "name": "Savon noir premium",
          "description": "Savon noir artisanal",
          "price": 8.00,
          "duration": 0,
          "is_required": false,
          "max_quantity": 1,
          "available": true
        }
      ],
      "created_at": "2026-01-20T10:00:00Z"
    }
  ]
}
```

---

### 2. Récupérer un service spécifique

**GET** `/api/services/{id}`

**Response 200:**
```json
{
  "data": {
    "id": 1,
    "name": "Massage Relaxant",
    "category": "Soins",
    "description": "Massage complet du corps pour une détente profonde",
    "price": 50.00,
    "duration": 60,
    "image": "/images/massage-relaxant.jpg",
    "available": true,
    "options": [
      {
        "id": 1,
        "name": "Huile essentielle de lavande",
        "description": "Huile relaxante pour améliorer l'expérience",
        "price": 10.00,
        "duration": 0,
        "is_required": false,
        "max_quantity": 1,
        "available": true
      }
    ],
    "created_at": "2026-01-20T10:00:00Z"
  }
}
```

---

### 3. Calculer le total d'un panier (PREVIEW)

**POST** `/api/bookings/calculate`

**Request Body:**
```json
{
  "items": [
    {
      "service_id": 1,
      "quantity": 1,
      "options": [
        {
          "option_id": 1,
          "quantity": 1
        },
        {
          "option_id": 2,
          "quantity": 1
        }
      ]
    },
    {
      "service_id": 2,
      "quantity": 1,
      "options": [
        {
          "option_id": 3,
          "quantity": 1
        }
      ]
    }
  ]
}
```

**Response 200:**
```json
{
  "success": true,
  "data": {
    "subtotal": 133.00,
    "discount_total": 10.00,
    "total": 123.00,
    "total_duration": 105,
    "items": [
      {
        "service_id": 1,
        "service_name": "Massage Relaxant",
        "quantity": 1,
        "unit_price": 50.00,
        "options_total": 35.00,
        "subtotal": 85.00,
        "discount": 5.00,
        "total": 80.00,
        "duration": 90,
        "promotion": {
          "code": "MASSAGE10",
          "type": "percentage",
          "discount": 10.00
        }
      },
      {
        "service_id": 2,
        "service_name": "Hammam Traditionnel",
        "quantity": 1,
        "unit_price": 40.00,
        "options_total": 8.00,
        "subtotal": 48.00,
        "discount": 5.00,
        "total": 43.00,
        "duration": 45,
        "promotion": {
          "code": "MASSAGE10",
          "type": "percentage",
          "discount": 10.00
        }
      }
    ]
  }
}
```

---

### 4. Créer une réservation

**POST** `/api/bookings`

**Request Body:**
```json
{
  "date": "2026-01-30",
  "time": "14:00",
  "notes": "Première visite, préférence pour un praticien expérimenté",
  "items": [
    {
      "service_id": 1,
      "staff_id": 3,
      "quantity": 1,
      "notes": "Éviter les zones sensibles du dos",
      "options": [
        {
          "option_id": 1,
          "quantity": 1
        },
        {
          "option_id": 2,
          "quantity": 1
        }
      ]
    },
    {
      "service_id": 2,
      "staff_id": 2,
      "quantity": 1,
      "notes": null,
      "options": [
        {
          "option_id": 3,
          "quantity": 1
        }
      ]
    }
  ]
}
```

**Validation Rules:**
- `date`: required, date, after_or_equal:today
- `time`: required, string
- `notes`: nullable, string, max:1000
- `items`: required, array, min:1
- `items.*.service_id`: required, exists:services,id
- `items.*.staff_id`: nullable, exists:staff,id
- `items.*.quantity`: nullable, integer, min:1, max:10
- `items.*.notes`: nullable, string, max:500
- `items.*.options`: nullable, array
- `items.*.options.*.option_id`: required, exists:service_options,id
- `items.*.options.*.quantity`: nullable, integer, min:1, max:10

**Response 201:**
```json
{
  "success": true,
  "message": "Réservation créée avec succès.",
  "data": {
    "id": 42,
    "booking_reference": "BK-65ABC123",
    "client": {
      "id": 15,
      "name": "Jean Dupont"
    },
    "date": "2026-01-30",
    "time": "14:00",
    "status": "pending",
    "payment_status": "pending",
    "payment_method": null,
    "totals": {
      "subtotal": 133.00,
      "discount_total": 10.00,
      "total": 123.00,
      "total_duration": 135
    },
    "items": [
      {
        "id": 101,
        "service": {
          "id": 1,
          "name": "Massage Relaxant"
        },
        "staff": {
          "id": 3,
          "name": "Marie Leblanc"
        },
        "quantity": 1,
        "unit_price": 50.00,
        "duration": 60,
        "pricing": {
          "options_total": 35.00,
          "subtotal": 85.00,
          "discount_amount": 5.00,
          "total": 80.00
        },
        "promotion": {
          "id": 5,
          "code": "MASSAGE10"
        },
        "staff_payout": {
          "percentage": 60.00,
          "amount": 30.00
        },
        "options": [
          {
            "id": 201,
            "option_id": 1,
            "name": "Huile essentielle de lavande",
            "quantity": 1,
            "unit_price": 10.00,
            "duration": 0,
            "total": 10.00
          },
          {
            "id": 202,
            "option_id": 2,
            "name": "Extension 30 minutes",
            "quantity": 1,
            "unit_price": 25.00,
            "duration": 30,
            "total": 25.00
          }
        ],
        "notes": "Éviter les zones sensibles du dos"
      },
      {
        "id": 102,
        "service": {
          "id": 2,
          "name": "Hammam Traditionnel"
        },
        "staff": {
          "id": 2,
          "name": "Ahmed Benali"
        },
        "quantity": 1,
        "unit_price": 40.00,
        "duration": 45,
        "pricing": {
          "options_total": 8.00,
          "subtotal": 48.00,
          "discount_amount": 5.00,
          "total": 43.00
        },
        "promotion": {
          "id": 5,
          "code": "MASSAGE10"
        },
        "staff_payout": {
          "percentage": 55.00,
          "amount": 22.00
        },
        "options": [
          {
            "id": 203,
            "option_id": 3,
            "name": "Savon noir premium",
            "quantity": 1,
            "unit_price": 8.00,
            "duration": 0,
            "total": 8.00
          }
        ],
        "notes": null
      }
    ],
    "notes": "Première visite, préférence pour un praticien expérimenté",
    "created_at": "2026-01-24T15:30:00Z",
    "updated_at": "2026-01-24T15:30:00Z"
  }
}
```

**Response 422 (Validation Error):**
```json
{
  "success": false,
  "message": "Erreur lors de la création de la réservation: Certaines options ne sont pas valides pour ce service.",
  "errors": {
    "items.0.options": [
      "Certaines options ne sont pas valides pour ce service."
    ]
  }
}
```

---

### 5. Récupérer une réservation

**GET** `/api/bookings/{id}`

Accepte l'ID numérique ou la référence (ex: `BK-65ABC123`)

**Response 200:** (même format que la réponse de création)

---

### 6. Lister les réservations du client

**GET** `/api/bookings`

**Query Parameters:**
- `page` (optional): Numéro de page (pagination)

**Response 200:**
```json
{
  "data": [
    {
      "id": 42,
      "booking_reference": "BK-65ABC123",
      "client": {
        "id": 15,
        "name": "Jean Dupont"
      },
      "date": "2026-01-30",
      "time": "14:00",
      "status": "pending",
      "payment_status": "pending",
      "totals": {
        "subtotal": 133.00,
        "discount_total": 10.00,
        "total": 123.00,
        "total_duration": 135
      },
      "items": [...],
      "created_at": "2026-01-24T15:30:00Z"
    }
  ],
  "links": {
    "first": "http://example.com/api/bookings?page=1",
    "last": "http://example.com/api/bookings?page=3",
    "prev": null,
    "next": "http://example.com/api/bookings?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 3,
    "per_page": 10,
    "to": 10,
    "total": 27
  }
}
```

---

## 💼 Règles métier

### 1. Disponibilité
- Les services doivent avoir `available = true`
- Les options doivent avoir `available = true`
- Les options doivent appartenir au service sélectionné

### 2. Calcul des prix
- **Subtotal item** = `(unit_price + options_total) * quantity`
- **Options total** = `Σ(option.unit_price * option.quantity)`
- **Total item** = `subtotal - discount_amount`
- **Subtotal booking** = `Σ(item.subtotal)`
- **Total booking** = `Σ(item.total)`

### 3. Calcul de la durée
- **Durée item** = `(service.duration + Σ(option.duration * option.quantity)) * quantity`
- **Durée totale** = `Σ(item.duration)`

### 4. Commission/Payout Staff
- Le payout est calculé **uniquement sur le prix du service** (pas les options)
- Formula: `staff_payout_amount = (unit_price * quantity * staff_payout_percentage) / 100`
- Le `staff_payout_percentage` vient de la table pivot `service_staff`

### 5. Promotions
- Les promotions sont appliquées **au niveau de chaque item**
- La meilleure promotion applicable est automatiquement sélectionnée
- Types: `percentage` (pourcentage) ou `fixed` (montant fixe)
- Les promotions ne s'appliquent **que sur le prix du service** (pas les options)

### 6. Options
- `is_required`: Si true, l'option doit être sélectionnée
- `max_quantity`: Quantité maximale sélectionnable
- Les options peuvent ajouter un coût ET une durée

---

## 🔧 Commandes de migration

```bash
# Exécuter les migrations
php artisan migrate

# En cas de problème, rollback
php artisan migrate:rollback

# Refresh complet
php artisan migrate:fresh

# Avec seeders
php artisan migrate:fresh --seed
```

---

## 📝 Exemples d'utilisation

### Scénario 1: Réservation simple (1 service, 0 option)

```json
{
  "date": "2026-02-01",
  "time": "10:00",
  "items": [
    {
      "service_id": 5,
      "staff_id": 1,
      "quantity": 1
    }
  ]
}
```

### Scénario 2: Réservation multiple (2 services différents)

```json
{
  "date": "2026-02-01",
  "time": "10:00",
  "items": [
    {
      "service_id": 1,
      "staff_id": 3,
      "quantity": 1,
      "options": [
        {"option_id": 1, "quantity": 1}
      ]
    },
    {
      "service_id": 2,
      "staff_id": 2,
      "quantity": 1
    }
  ]
}
```

### Scénario 3: Même service, quantité multiple

```json
{
  "date": "2026-02-01",
  "time": "14:00",
  "items": [
    {
      "service_id": 1,
      "staff_id": 3,
      "quantity": 2,
      "options": [
        {"option_id": 1, "quantity": 2}
      ]
    }
  ]
}
```

### Scénario 4: Options multiples sur un service

```json
{
  "date": "2026-02-01",
  "time": "16:00",
  "items": [
    {
      "service_id": 1,
      "quantity": 1,
      "options": [
        {"option_id": 1, "quantity": 1},
        {"option_id": 2, "quantity": 1},
        {"option_id": 4, "quantity": 2}
      ]
    }
  ]
}
```

---

## ⚠️ Gestion des erreurs

### Erreurs communes

**Service non disponible:**
```json
{
  "success": false,
  "message": "Erreur lors de la création de la réservation: Le service 'Massage Relaxant' n'est pas disponible actuellement."
}
```

**Option invalide pour le service:**
```json
{
  "success": false,
  "message": "Erreur lors de la création de la réservation: L'option 'Huile essentielle' n'appartient pas au service 'Hammam Traditionnel'"
}
```

**Quantité excessive:**
```json
{
  "success": false,
  "message": "Erreur lors de la création de la réservation: La quantité demandée pour 'Extension 30 minutes' dépasse le maximum autorisé (2)"
}
```

---

## 🎯 Avantages de cette architecture

✅ **Une seule réservation globale** avec plusieurs services
✅ **Options flexibles** par service avec quantité configurable
✅ **Promotions automatiques** appliquées intelligemment
✅ **Calcul de payout staff** précis et transparent
✅ **Historique préservé** via dénormalisation des noms
✅ **Évolutif** pour ajouter des fonctionnalités futures
✅ **API RESTful** claire et documentée
✅ **Validation robuste** à tous les niveaux
✅ **Calcul de totaux** automatique et fiable
