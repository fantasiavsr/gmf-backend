# GMF Training Center Backend API

Laravel 12 REST API for the GMF Training Center React frontend.

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
DB_DATABASE=gmf_backend
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

The API base URL is `http://localhost:8000/api`.

## API routes

All routes are prefixed with `/api`. Public routes do not need authentication. For protected routes, send the bearer token returned by `POST /api/login`:

```http
Authorization: Bearer <token>
Accept: application/json
Content-Type: application/json
```

### Health

| Method | Route         | Access | Purpose                           |
| ------ | ------------- | ------ | --------------------------------- |
| `GET`  | `/api/health` | Public | Check that the API is responding. |

### Authentication

| Method | Route                | Access    | Purpose                                                  |
| ------ | -------------------- | --------- | -------------------------------------------------------- |
| `POST` | `/api/register`      | Public    | Create an account; new accounts receive the `user` role. |
| `POST` | `/api/login`         | Public    | Authenticate and return the user and bearer token.       |
| `GET`  | `/api/user`          | Signed in | Return the authenticated user.                           |
| `POST` | `/api/logout`        | Signed in | Revoke the current token.                                |
| `PUT`  | `/api/user/profile`  | Signed in | Update profile fields.                                   |
| `PUT`  | `/api/user/password` | Signed in | Change the current password.                             |

### Certificates

Certificate previews are public. Full details and PDF metadata require a bearer token and certificate ownership, or the `admin` role. The user certificate list only returns records owned by the current user. Linking a certificate is restricted to admins.

| Method | Route                                                          | Access         | Purpose                                                                                       |
| ------ | -------------------------------------------------------------- | -------------- | --------------------------------------------------------------------------------------------- |
| `GET`  | `/api/certificates/preview/{certificateNo}`                    | Public         | Return safe preview fields for one certificate.                                               |
| `GET`  | `/api/certificates/search?welder_identification_no={welderId}` | Public         | Search public previews by welder ID.                                                          |
| `GET`  | `/api/certificates/{certificateNo}/detail`                     | Owner or admin | Return full certificate details.                                                              |
| `GET`  | `/api/certificates/{certificateNo}/pdf`                        | Owner or admin | Check PDF availability. Currently returns placeholder JSON; PDF streaming is not implemented. |
| `GET`  | `/api/user/certificates`                                       | Signed in      | List the current user's certificates.                                                         |
| `POST` | `/api/admin/certificates/{id}/link-user`                       | Admin          | Link a certificate to a user. Send JSON: `{"user_id": 2}`.                                    |

Certificate numbers include `/`, so URL-encode the full number in the path. For example, `GMF/WQT/AWS/0612` becomes `GMF%2FWQT%2FAWS%2F0612`:

```bash
curl "http://localhost:8000/api/certificates/preview/GMF%2FWQT%2FAWS%2F0612"
curl "http://localhost:8000/api/certificates/search?welder_identification_no=GMF-533"
```

### Dashboard resources

All product, service, and pricing routes require authentication. Collection `GET` and item `GET` responses wrap records in a `data` property.

| Resource | List / create               | Item read / update / delete                             |
| -------- | --------------------------- | ------------------------------------------------------- |
| Products | `GET`, `POST /api/products` | `GET`, `PUT`, `PATCH`, `DELETE /api/products/{product}` |
| Services | `GET`, `POST /api/services` | `GET`, `PUT`, `PATCH`, `DELETE /api/services/{service}` |
| Pricing  | `GET`, `POST /api/pricing`  | `GET`, `PUT`, `PATCH`, `DELETE /api/pricing/{pricing}`  |

Successful list and item responses use `{ "data": [...] }` and `{ "data": {...} }`, respectively. Create requests return `201 Created`; delete requests return a message.

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
DB_DATABASE=gmf_backend_prod
DB_USERNAME=gmf_backend
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

CORS applies to `/api/*` and does not allow credentialed cookies. Authentication uses bearer tokens in the `Authorization` header. In production, the allowed browser origin is set by `FRONTEND_URL`; restrict it to the exact frontend origin and do not use `*`. Local development uses the Vite proxy to avoid cross-origin requests.

## Verification

```bash
php artisan test
php artisan route:list --path=api
curl http://localhost:8000/api/health
```
