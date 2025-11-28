# ASE 230 – Project 2
## Secure REST API with Laravel 12, Sanctum, and Docker
This is the backend for my ASE 230 Project 2. I rebuilt my Project 1 REST API using Laravel 12, added
Sanctum token authentication, and deployed everything using Docker so the API is easy to run
anywhere. This repo contains the full Laravel codebase, migrations, controllers, and automation scripts.
---
# What’s Included
- Laravel 12 REST API
- Sanctum authentication (token-based login)
- User CRUD (create, read, update, delete)
- Friends system (add friends and list friends)
- MySQL 8 container
- phpMyAdmin container
- Fully configured `docker-compose.yml`
- Dockerfile for the Laravel app container
- Automation scripts (`setup.sh` and `run.sh`)
- Browser-based API tester (`public/test_api.html`)
- Full migrations, models, controllers, and routing
---
# How To Run the Project
## 1. Clone the repository
git clone https://github.com/DUNCANM14/project2.git
cd project2
## 2. Create your `.env` file
cp .env.example .env
Update these values to match Docker:
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=project2
DB_USERNAME=project2
DB_PASSWORD=project2
## 3. Start Docker containers
docker-compose up -d --build
## 4. Generate Laravel app key
docker exec -it laravel-app php artisan key:generate
## 5. Run database migrations
docker exec -it laravel-app php artisan migrate
---
# URLs
API Base URL:
http://localhost:8000/api
phpMyAdmin:
http://localhost:8080
---
# API Testing
## Login (returns API token)
POST /api/users/login
Response:
{ "token": "your_api_token_here" }
## Create a user
POST /api/users
## Delete a user (requires Bearer token)
DELETE /api/users/1
Authorization: Bearer
## Browser-based API Tester
public/test_api.html
---
# Docker Commands
Start all containers:
docker-compose up -d
Stop everything:
docker-compose down
Rebuild Laravel app container:
docker-compose build --no-cache
---
# Notes
- vendor/ and .env are excluded using .gitignore
- This repo contains only the backend
- Documentation is hosted at:
https://duncanm14.github.io/project2-docs/
