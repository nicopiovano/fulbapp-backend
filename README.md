# Fútbol API — Backend

API REST en **Laravel** para gestionar partidos de fútbol, jugadores y valoraciones. Expone los endpoints que consume la SPA del frontend (`fulbapp`).

## Stack

- **Laravel 12.x** (PHP 8.3)
- **PostgreSQL** (Base de datos `fulbapp`)
- **Laravel Sanctum** (auth por token tipo Bearer)
- **Docker / Docker Compose** (backend + base de datos)

## Cómo correr el backend

### Opción 1 — Docker (recomendada)

Desde el root del monorepo (`/Porfolio/futbol`):

```bash
docker compose up --build
```

Esto levanta:

- `backend` en `http://localhost:8000`
- `db` (PostgreSQL) en `localhost:5433` (útil para conectarte desde un cliente)

En entorno `local` el container corre:

- `php artisan migrate:fresh --seed --force`

Así que siempre vas a tener:

- Usuarios de prueba
- Partidos de prueba
- Tablas pivot y tokens de Sanctum creados

### Opción 2 — Local (sin Docker)

Requisitos:

- PHP 8.3 + extensiones (`pdo_pgsql`, `mbstring`, `xml`, etc.)
- Composer
- PostgreSQL corriendo y accesible

Pasos:

```bash
cd backend
cp .env.example .env   # ajustar credenciales de DB si hace falta
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve --host=0.0.0.0 --port=8000
```

La API queda en `http://localhost:8000`.

## Credenciales demo

Seeder de usuarios:

- **Admin / organizador demo**
  - Email: `nmpiovano@hotmail.com`
  - Password: `123456`
- **Jugadores mock**
  - Usuarios que replican los IDs del frontend (`u1`..`u16`, `mock-current`) para que las relaciones de partidos coincidan.

Después de loguearte, el backend devuelve:

- `token` (Sanctum, usado como `Authorization: Bearer <token>`)
- `user` normalizado

## Estructura del proyecto

```bash
app/
├── DTOs/            # Objetos de transferencia (CreateMatchDTO, UpdateMatchDTO, etc.)
├── Http/
│   ├── Controllers/Api/  # AuthController, MatchController, UserController
│   ├── Requests/Match/   # StoreMatchRequest, UpdateMatchRequest
│   └── Resources/        # MatchResource (añade flags como is_creator)
├── Models/          # User, GameMatch, MatchStatus
├── Repositories/    # Contracts + Eloquent (MatchRepository, UserRepository)
├── Services/        # AuthService, MatchService, UserService
└── Providers/       # RepositoryServiceProvider (bindings de interfaces)

database/
├── migrations/      # users, matches, match_players, match_statuses, personal_access_tokens, etc.
└── seeders/         # UserSeeder, GameMatchSeeder, MatchPlayerSeeder, MatchStatusSeeder
```

## Arquitectura

- **Controladores API (`app/Http/Controllers/Api`)**
  - Sólo orquestan: validan requests, llaman a servicios y devuelven `JsonResponse`.
  - Manejo de errores con `try/catch` (404, 401, 422, 500).

- **Services (`app/Services`)**
  - Encapsulan la lógica de negocio:
    - `AuthService`: login, logout, emisión de tokens Sanctum.
    - `MatchService`: listar, crear, actualizar, unirse, bajarse, cancelar partidos.
    - `UserService`: registro y consulta de usuarios.

- **Repositories (`app/Repositories`)**
  - Eloquent repositories detrás de interfaces:
    - `MatchRepositoryInterface` / `MatchRepository`
    - `UserRepositoryInterface` / `UserRepository`
  - `MatchRepository::paginate()` ya aplica reglas de visibilidad:
    - Partidos **de hoy o futuros** → visibles para todos.
    - Partidos **pasados o cancelados** → sólo si `created_by` es el usuario autenticado.

- **Resources (`app/Http/Resources/MatchResource`)**
  - Normaliza la salida de `GameMatch` para la API.
  - Incluye campos “contextuales” calculados en el servidor:
    - `is_creator` (boolean) → usado por el frontend para habilitar edición, cancelación y calificaciones.

## Principales endpoints

Prefijo: `/api` (Laravel 12 con routing separado).

### Auth

- `POST /api/login`
  - Body: `{ email, password }`
  - Respuesta: `{ token, user }`

- `POST /api/logout`
- `GET /api/me`

### Usuarios

- `GET /api/users`
- `GET /api/users/{id}`
- `POST /api/register` (simple registro vía `UserRegisterDTO`)

### Partidos

Protegidos por `auth:sanctum`:

- `GET /api/matches`
  - Devuelve página de partidos con:
    - `players[]` embebidos
    - `status.name`
    - `is_creator`

- `POST /api/matches`
- `GET /api/matches/{id}`
- `PUT /api/matches/{id}`
- `POST /api/matches/{id}/join`
- `DELETE /api/matches/{id}/leave`
- `PATCH /api/matches/{id}/cancel`
  - Sólo el creador puede cancelar.

## Notas de integración con el frontend

- El frontend (`fulbapp`) usa un cliente HTTP en `src/services/api.js` que:
  - Apunta a `/api` (Vite proxy a `http://localhost:8000` en dev).
  - Añade `Authorization: Bearer <token>` si existe token en `localStorage`.
- `matchService.js` y `userService.js` normalizan nombres de campos:
  - Backend: `snake_case` → Frontend: `camelCase`.
- El backend devuelve jugadores embebidos en cada partido (`players[]`) para evitar múltiples requests por card.

## Scripts útiles

Desde `backend/`:

```bash
# Migrar y seedear
php artisan migrate:fresh --seed

# Correr tests
php artisan test
```

Con Docker, estos comandos se ejecutan desde dentro del container (o usando `docker exec`).
