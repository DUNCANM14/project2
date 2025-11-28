#!/usr/bin/env bash

echo "=========================================="
echo "   Project 2 – Docker Deployment Script"
echo "   Git Bash / Windows Compatible Version"
echo "=========================================="

set -e  # stop on any error

echo ""
echo ">>> Building Docker containers..."
docker-compose build

echo ""
echo ">>> Starting Docker containers..."
docker-compose up -d

echo ""
echo ">>> Waiting for MySQL to initialize (10 seconds)..."
sleep 10

echo ""
echo ">>> Running Laravel migrations inside container..."
docker-compose exec app php artisan migrate --force

echo ""
echo "=========================================="
echo "      Deployment Complete!"
echo "------------------------------------------"
echo " Laravel API:     http://localhost:8000"
echo " phpMyAdmin:      http://localhost:8080"
echo " MySQL Port:      3307"
echo "=========================================="
