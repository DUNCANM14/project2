#!/usr/bin/env bash

echo "======================================"
echo "  Starting Project 2 Deployment Script"
echo "======================================"

# Stop on any error
set -e

echo "Checking PHP version..."
php -v

echo "Installing Composer dependencies..."
composer install --no-interaction --prefer-dist

# Set environment file if missing
if [ ! -f ".env" ]; then
    echo "Copying .env example..."
    cp .env.example .env
fi

echo "Generating application key..."
php artisan key:generate

echo "Running database migrations..."
php artisan migrate

echo "Starting Laravel development server..."
php artisan serve --host=0.0.0.0 --port=8000
