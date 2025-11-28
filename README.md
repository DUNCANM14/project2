# ASE 230 – Project 2  
## Secure REST API with Laravel 12 + Sanctum + Docker

This is my full Project 2 backend. For this project I rebuilt my Project 1 REST API using **Laravel 12**, added full **Sanctum token authentication**, set up a **Docker environment**, and created some shell scripts to make running everything a lot easier.

Everything you need to run the API is in this repo.

---

## 🚀 What’s Included

- Laravel 12 REST API (Users + Friends system)
- Login endpoint that returns a real API token
- Sanctum auth handling protected routes
- MySQL 8 database running in Docker
- phpMyAdmin container for quick DB access
- `docker-compose.yml` for the whole stack
- Shell scripts (`setup.sh`, `run.sh`) to automate everything
- Browser-based API tester (`public/test_api.html`)
- Clean project structure, migrations, controllers, and models

---

## 🔧 How To Run The Project

### 1. Clone the repo
git clone https://github.com/DUNCANM14/project2.git
cd project2

shell
Copy code

### 2. Make your `.env` file
cp .env.example .env

yaml
Copy code
Change the DB settings if needed:
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=project2
DB_USERNAME=project2
DB_PASSWORD=project2

shell
Copy code

### 3. Start Docker containers
docker-compose up -d --build

shell
Copy code

### 4. Generate Laravel app key
docker exec -it laravel-app php artisan key:generate

shell
Copy code

### 5. Run migrations
docker exec -it laravel-app php artisan migrate

csharp
Copy code

That’s it. The API is now live at:
http://localhost:8000/api

makefile
Copy code

phpMyAdmin:
http://localhost:8080

yaml
Copy code

---

## 🧪 Testing the API

### Login
POST /api/users/login

makefile
Copy code
Returns:
{ "token": "yourtokenhere" }

shell
Copy code

### Create a user
POST /api/users

shell
Copy code

### Protected example (delete user)
DELETE /api/users/1
Authorization: Bearer <token>

makefile
Copy code

### Browser API tester
Open:
public/test_api.html

yaml
Copy code

---

## 🐳 Docker Commands

Start all containers:
docker-compose up -d

vbnet
Copy code

Stop everything:
docker-compose down

makefile
Copy code

Rebuild:
docker-compose build --no-cache

yaml
Copy code

---

## 📌 Notes

- `vendor/` and `.env` are ignored using `.gitignore`
- This backend is separate from the Hugo documentation site
- All documentation is hosted at:
  https://duncanm14.github.io/project2-docs/

---

## 👍 Done!

If you follow the steps above, the API should run without any issues.  
This is the backend portion of my Project 2 for ASE 230.
