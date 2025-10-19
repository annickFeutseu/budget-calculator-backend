# 💰 Calculateur de Budget Personnel

Application web moderne pour gérer vos finances personnelles avec Laravel et Angular.

## 🎯 Fonctionnalités

- ✅ Gestion des transactions (revenus/dépenses)
- ✅ Catégorisation personnalisée
- ✅ Tableau de bord avec statistiques
- ✅ Graphiques interactifs (Chart.js)
- ✅ Filtrage et recherche
- ✅ Design responsive moderne
- ✅ API RESTful sécurisée
- ✅ Architecture propre et maintenable

## 🛠️ Technologies

### Backend
- Laravel 10
- MySQL 8.0
- PHP 8.1+
- Laravel Sanctum (Authentication)

### Frontend
- Angular 17
- TypeScript
- RxJS
- Chart.js
- Tailwind CSS (via CDN)

## 📦 Installation

### Prérequis
```bash
- PHP 8.1+
- Composer
- Node.js 18+
- MySQL 8.0+
- Angular CLI (npm install -g @angular/cli)
```

### 1. Backend Laravel

```bash
# Cloner et installer
git clone https://github.com/votre-username/budget-calculator.git
cd budget-calculator/backend

# Installer les dépendances
composer install

# Configuration environnement
cp .env.example .env
php artisan key:generate

# Configurer la base de données dans .env
DB_DATABASE=budget_calculator
DB_USERNAME=root
DB_PASSWORD=your_password

# Créer la base de données
mysql -u root -p
CREATE DATABASE budget_calculator;
exit;

# Migrations et seeds
php artisan migrate --seed

# Lancer le serveur
php artisan serve
```

L'API sera disponible sur: `http://localhost:8000`

### 2. Frontend Angular

```bash
cd frontend

# Installer les dépendances
npm install

# Lancer le serveur de développement
ng serve

# Ou avec un port spécifique
ng serve --port 4200
```

L'application sera disponible sur: `http://localhost:4200`

## 📁 Structure du Projet

### Backend
```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/
│   │   │   ├── TransactionController.php
│   │   │   ├── CategoryController.php
│   │   │   └── DashboardController.php
│   │   ├── Requests/
│   │   │   └── StoreTransactionRequest.php
│   │   └── Resources/
│   │       └── TransactionResource.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Transaction.php
│   │   ├── Category.php
│   │   └── Budget.php
│   └── Services/
│       └── BudgetAnalyticsService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
└── .env
```

### Frontend
```
frontend/
├── src/
│   ├── app/
│   │   ├── core/
│   │   │   ├── services/
│   │   │   │   ├── api.service.ts
│   │   │   │   ├── auth.service.ts
│   │   │   │   └── transaction.service.ts
│   │   │   ├── interceptors/
│   │   │   │   └── auth.interceptor.ts
│   │   │   └── guards/
│   │   │       └── auth.guard.ts
│   │   ├── features/
│   │   │   ├── dashboard/
│   │   │   │   └── dashboard.component.ts
│   │   │   ├── transactions/
│   │   │   │   ├── transaction-list.component.ts
│   │   │   │   └── transaction-form.component.ts
│   │   │   └── categories/
│   │   │       └── category-manager.component.ts
│   │   ├── models/
│   │   │   └── transaction.model.ts
│   │   ├── app.component.ts
│   │   ├── app.config.ts
│   │   └── app.routes.ts
│   └── environments/
│       ├── environment.ts
│       └── environment.prod.ts
├── angular.json
└── package.json
```

## 🔌 API Endpoints

### Authentification
```
POST   /api/register          - Inscription
POST   /api/login             - Connexion
POST   /api/logout            - Déconnexion
GET    /api/user              - Utilisateur actuel
```

### Transactions
```
GET    /api/transactions      - Liste des transactions
POST   /api/transactions      - Créer une transaction
GET    /api/transactions/{id} - Détail d'une transaction
PUT    /api/transactions/{id} - Modifier une transaction
DELETE /api/transactions/{id} - Supprimer une transaction
```

### Catégories
```
GET    /api/categories        - Liste des catégories
POST   /api/categories        - Créer une catégorie
PUT    /api/categories/{id}   - Modifier une catégorie
DELETE /api/categories/{id}   - Supprimer une catégorie
```

### Dashboard
```
GET    /api/dashboard/summary    - Statistiques globales
GET    /api/dashboard/chart-data - Données pour graphiques
```

## 📊 Exemples de Requêtes API

### Créer une transaction
```json
POST /api/transactions
Content-Type: application/json
Authorization: Bearer {token}

{
  "category_id": 1,
  "amount": 50.00,
  "type": "expense",
  "description": "Courses alimentaires",
  "transaction_date": "2025-10-19"
}
```

### Réponse
```json
{
  "success": true,
  "message": "Transaction créée avec succès",
  "data": {
    "id": 1,
    "amount": 50.00,
    "type": "expense",
    "description": "Courses alimentaires",
    "transaction_date": "2025-10-19",
    "category": {
      "id": 1,
      "name": "Alimentation",
      "color": "#f59e0b",
      "icon": "🛒"
    },
    "created_at": "2025-10-19T10:30:00.000000Z"
  }
}
```

## 🎨 Fonctionnalités UI/UX

### Dashboard
- Cartes statistiques (Revenus, Dépenses, Solde)
- Graphiques dynamiques avec Chart.js
- Transactions récentes
- Répartition par catégorie

### Gestion Transactions
- Formulaire intuitif avec validation
- Sélection type (revenu/dépense)
- Catégorisation avec couleurs/icônes
- Édition en ligne
- Suppression avec confirmation

### Design Moderne
- Dégradés colorés
- Animations fluides
- Cards avec ombres
- Hover effects
- Responsive design (mobile-first)
- Dark mode ready

## 🔒 Sécurité

### Backend
- ✅ Laravel Sanctum pour l'authentification
- ✅ Validation des requêtes
- ✅ Policies pour l'autorisation
- ✅ Protection CSRF
- ✅ Sanitization des inputs
- ✅ Rate limiting

### Frontend
- ✅ HTTP Interceptors pour le token
- ✅ Route Guards
- ✅ Validation formulaires
- ✅ Gestion erreurs centralisée

## 🧪 Tests

### Backend
```bash
# Tests unitaires
php artisan test

# Tests avec couverture
php artisan test --coverage

# Tests spécifiques
php artisan test --filter TransactionTest
```

### Frontend
```bash
# Tests unitaires
ng test

# Tests e2e
ng e2e

# Coverage
ng test --code-coverage
```

## 📦 Build Production

### Backend
```bash
# Optimisations
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migrations production
php artisan migrate --force
```

### Frontend
```bash
# Build production
ng build --configuration production

# Fichiers dans dist/
# Déployer sur serveur web (Apache/Nginx)
```

## 🚀 Déploiement

### Hébergement recommandé

**Backend:**
- Laravel Forge
- DigitalOcean
- AWS EC2
- Heroku

**Frontend:**
- Vercel
- Netlify
- Firebase Hosting
- AWS S3 + CloudFront

### Configuration Nginx (Exemple)
```nginx
server {
    listen 80;
    server_name api.budget-app.com;
    root /var/www/budget-calculator/backend/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 📈 Améliorations Futures

### Version 2.0
- [ ] Budgets mensuels avec alertes
- [ ] Export PDF/Excel des rapports
- [ ] Récurrence des transactions
- [ ] Comparaison de périodes
- [ ] Objectifs d'épargne
- [ ] Multi-devises
- [ ] Scan de reçus avec OCR
- [ ] Notifications push
- [ ] Mode collaboratif (famille)
- [ ] Application mobile (React Native)

## 🤝 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit (`git commit -m 'Add AmazingFeature'`)
4. Push (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📝 Standards de Code

### Backend
- PSR-12 pour le style de code
- PHPStan niveau 5
- Laravel Pint pour le formatting

### Frontend
- ESLint configuration Angular
- Prettier pour le formatting
- Convention de nommage stricte

## 🐛 Debugging

### Backend
```bash
# Logs
tail -f storage/logs/laravel.log

# Debug mode
php artisan serve --host=0.0.0.0 --port=8000

# Vider les caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Frontend
```bash
# Mode verbose
ng serve --verbose

# Source maps
ng build --source-map

# Analyze bundle
ng build --stats-json
npx webpack-bundle-analyzer dist/stats.json
```

## 📞 Support

Pour toute question ou problème:
- 📧 Email: votre-email@example.com
- 🐛 Issues: [GitHub Issues](https://github.com/votre-username/budget-calculator/issues)
- 💬 Discussions: [GitHub Discussions](https://github.com/votre-username/budget-calculator/discussions)

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier `LICENSE` pour plus de détails.

## 👏 Remerciements

- Laravel Framework
- Angular Team
- Chart.js
- Communauté Open Source

*/