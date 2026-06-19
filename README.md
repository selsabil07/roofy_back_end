# Roofy API

Real estate API backend for the Roofy web application. Powers the public property site, **admin dashboard**, and **agent dashboard**.

Built with Laravel 10, Sanctum (token auth), and MySQL.

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate

# Create database "roofy" in MySQL, then:
php artisan migrate --seed

npm install
npm run dev
php artisan serve
```

API base URL: `http://localhost:8000/api`

## Default accounts (after seeding)

| Role  | Email            | Password  |
|-------|------------------|-----------|
| Admin | admin@admin.com  | admin123  |
| Agent | agent@agent.com  | agent123  |

## Authentication

All protected endpoints require a Bearer token:

```
Authorization: Bearer {access_token}
```

### Register (public clients only)

```
POST /api/register
```

```json
{
  "name": "John Doe",
  "userName": "johndoe",
  "phone": "5551234567",
  "address": "123 Main St",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

Role is always forced to `user`. Agents are created by admins.

### Login

```
POST /api/login
```

```json
{
  "email": "admin@admin.com",
  "password": "admin123",
  "role": "admin"
}
```

`role` must be `admin`, `agent`, or `user` and must match the account.

### Logout

```
POST /api/logout
```

### Current user

```
GET /api/user
```

### Update password

```
PUT /api/password
```

```json
{
  "current_password": "admin123",
  "password": "newpassword",
  "password_confirmation": "newpassword"
}
```

## Public property browsing (main website)

### List properties

```
GET /api/properties
```

Query params: `status` (sell|rent), `location`, `min_price`, `max_price`, `search`, `per_page`

Only available listings are shown to unauthenticated visitors.

### Show property

```
GET /api/properties/{id}
```

## Property management (agents & admins)

```
POST   /api/properties
PUT    /api/properties/{id}
PATCH  /api/properties/{id}
DELETE /api/properties/{id}
```

Required fields for create: `name`, `status`, `location`, `price`

Admins can optionally pass `user_id` to assign a listing to an agent.

## Agent dashboard

```
GET /api/agent/dashboard
GET /api/agent/properties
```

## Admin dashboard

```
GET    /api/admin/dashboard
GET    /api/admin/users
POST   /api/admin/users
GET    /api/admin/users/{id}
PUT    /api/admin/users/{id}
DELETE /api/admin/users/{id}
GET    /api/admin/properties
```

### Create agent (admin only)

```
POST /api/admin/users
```

```json
{
  "name": "Jane Agent",
  "userName": "janeagent",
  "phone": "5559876543",
  "address": "456 Oak Ave",
  "email": "jane@example.com",
  "password": "password",
  "password_confirmation": "password",
  "role": "agent"
}
```

## Roles

| Role    | Access                                              |
|---------|-----------------------------------------------------|
| `admin` | Full dashboard, manage users/agents, all properties |
| `agent` | Agent dashboard, manage own property listings       |
| `user`  | Public client account, browse properties            |

## SPA frontend integration

1. Set `FRONTEND_URL` and `SANCTUM_STATEFUL_DOMAINS` in `.env`
2. Call `GET /sanctum/csrf-cookie` before login if using cookie-based SPA auth
3. Or use Bearer tokens from `/api/login` (recommended for separate frontend)

## CORS

Configure your frontend origin in `config/cors.php` for production.
