ASE 230 – Project 2
Secure REST API with Laravel 12, Sanctum, and Docker

This is my full backend for Project 2. I rebuilt my Project 1 REST API using Laravel 12, added Sanctum token authentication, and set up a full Docker environment so the API is easy to run on any machine. Everything you need to run the backend is included here.

What’s Included

Laravel 12 REST API (re-implementation of Project 1)

Sanctum authentication with token-based login

User CRUD (create, read, update, delete)

Friends system (add friends and list friends)

MySQL 8 running inside Docker

phpMyAdmin container for database management

docker-compose.yml to run everything at once

Dockerfile for building the Laravel application container

Shell scripts (setup.sh and run.sh) for automation

Browser-based API tester located in public/test_api.html

Migrations, models, controllers, and all project files

How To Run The Project

Clone the repository

git clone https://github.com/DUNCANM14/project2.git
cd project2


Create the .env file

cp .env.example .env


Update the database section to match the docker-compose settings:

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=project2
DB_USERNAME=project2
DB_PASSWORD=project2


Start Docker containers

docker-compose up -d --build


Generate the Laravel app key

docker exec -it laravel-app php artisan key:generate


Run the database migrations

docker exec -it laravel-app php artisan migrate


The API should now be running at:

http://localhost:8000/api


phpMyAdmin is available at:

http://localhost:8080

API Testing

Login endpoint:

POST /api/users/login


Returns:

{ "token": "your_api_token_here" }


Create a user:

POST /api/users


Delete a user (requires Bearer token):

DELETE /api/users/1
Authorization: Bearer <token>


You can also open the browser-based tester:

public/test_api.html

Docker Commands

Start all containers:

docker-compose up -d


Stop everything:

docker-compose down


Rebuild the application container:

docker-compose build --no-cache

Notes

The vendor/ folder and .env file are ignored using .gitignore

This repository contains only the backend for Project 2

Documentation for this project is hosted separately at:

https://duncanm14.github.io/project2-docs/

End of README

This should cover everything needed to understand and run my Project 2 backend. If you follow the steps above, the API should run without any issues.
