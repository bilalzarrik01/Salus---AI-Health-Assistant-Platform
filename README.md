# Salus AI Health Assistant API

REST API for symptom tracking, medical appointments, and AI-generated wellness advice.

## Features
- Authentication with Laravel Sanctum
- Symptoms CRUD for the authenticated user
- Doctors listing, details, and search
- Appointments CRUD with future date validation
- AI health advice generation + history
- Unified JSON response structure
- OpenAPI/Swagger docs via Scribe

## Tech Stack
- Laravel 12
- PHP 8.2+
- MySQL or PostgreSQL
- Sanctum for API tokens

## Setup
1. Install dependencies
```
composer install
```
2. Configure environment
```
copy .env.example .env
```
Edit `.env` with DB credentials and Gemini settings.

3. Generate app key
```
php artisan key:generate
```
4. Run migrations
```
php artisan migrate
```
5. Seed doctors (optional)
```
php artisan db:seed --class=DoctorSeeder
```
6. Start server
```
php artisan serve
```

## Gemini Settings
Set these in `.env`:
- `GEMINI_API_KEY`
- `GEMINI_BASE_URL` (default `https://generativelanguage.googleapis.com`)
- `GEMINI_MODEL` (default `gemini-2.5-flash`)
- `GEMINI_TIMEOUT`

## API Documentation (Scribe)
Generate docs:
```
php artisan scribe:generate
```
Docs endpoint:
- `/docs` (HTML)
- `/docs.openapi` (OpenAPI)
- `/docs.postman` (Postman collection)

## UML Diagrams
- `docs/uml/use-case.puml`
- `docs/uml/class-diagram.puml`

## Response Format
Success:
```
{
  "success": true,
  "data": { ... },
  "message": "Operation reussie"
}
```
Error:
```
{
  "success": false,
  "errors": { ... },
  "message": "Erreur de validation"
}
```

## AWS Deployment (Target)
- EC2 for Laravel app
- RDS for database

---
If you want the AWS steps or Postman collection, ask and I will add them.
