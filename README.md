# Editorial Backend

Laravel 12 REST API for the Editorial Web frontend.

## Local development with XAMPP MySQL

Requirements:

- PHP 8.2+
- Composer
- MySQL/MariaDB (XAMPP is supported)

Create a local `.env` file from `.env.example`, then use local values:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=editorial_backend
DB_USERNAME=root
DB_PASSWORD=

FRONTEND_URL=http://localhost:5173
```

Create the database in phpMyAdmin or the XAMPP MySQL client, then run:

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve --port=8000
```

The API is available at `http://localhost:8000/api`.

## API endpoints

```text
GET|POST              /api/products
GET|PUT|PATCH|DELETE  /api/products/{product}
GET|POST              /api/services
GET|PUT|PATCH|DELETE  /api/services/{service}
GET|POST              /api/pricing
GET|PUT|PATCH|DELETE  /api/pricing/{pricing}
GET                    /api/health
```

## Production deployment checklist

Do not commit `.env`, passwords, or `APP_KEY`. Configure these values directly in the production server environment:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://api.example.com
APP_KEY=generated-on-server

DB_CONNECTION=mysql
DB_HOST=production-db-host
DB_PORT=3306
DB_DATABASE=editorial_backend_prod
DB_USERNAME=editorial_backend
DB_PASSWORD=strong-private-password

FRONTEND_URL=https://www.example.com
LOG_LEVEL=error
```

Use a dedicated database user with only the permissions required by this application. Do not use MySQL `root` in production.

The web server document root must point to Laravel's `public/` directory, not the repository root. Enable HTTPS before allowing browser traffic from the frontend. If uploaded public files are added later, run:

```bash
php artisan storage:link
```

After dependencies and environment values are configured on the server:

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Never use `migrate:fresh` or destructive seed commands against a production database.

## Same-domain and API-subdomain hosting

Same-domain routing:

```text
https://www.example.com/       → React/Vercel or static frontend
https://www.example.com/api/*   → reverse proxy to Laravel public/index.php
```

API subdomain routing:

```text
https://www.example.com/        → React frontend
https://api.example.com/api/*   → Laravel public/index.php
```

The frontend `VITE_API_URL` must match the deployed API URL. The API server's `FRONTEND_URL` must match the browser origin. DNS alone does not create same-domain `/api` routing; configure the host's reverse proxy or rewrite rules explicitly.

## CORS

CORS is configured for `/api/*` using the `FRONTEND_URL` environment value. Credentials are disabled because authentication is not yet part of this project. Restrict `FRONTEND_URL` to the exact frontend origin; do not use `*` for a production API.

## Verification

```bash
php artisan test
php artisan route:list --path=api
curl http://localhost:8000/api/health
```
