#!/bin/bash

###############################################################################
# iLab UNMUL - Deployment Script
# This script automates the deployment process for production updates
###############################################################################

set -e  # Exit on error

echo "========================================="
echo "iLab UNMUL Deployment Script"
echo "========================================="
echo ""

# Get the directory where the script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd "$SCRIPT_DIR"

echo "[1/9] Enabling maintenance mode..."
php artisan down --render="errors::503" --secret="ilab-maintenance-$(date +%s)" || true

echo ""
echo "[2/9] Pulling latest changes from Git..."
git pull origin main

echo ""
echo "[3/9] Installing/Updating Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

echo ""
echo "[4/9] Running database migrations..."
php artisan migrate --force

echo ""
echo "[5/9] Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

echo ""
echo "[6/9] Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "[7/9] Creating storage link (if not exists)..."
php artisan storage:link || true

echo ""
echo "[8/9] Setting correct permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

echo ""
echo "[9/9] Disabling maintenance mode..."
php artisan up

echo ""
echo "========================================="
echo "✓ Deployment completed successfully!"
echo "========================================="
echo ""
echo "Deployment Summary:"
echo "  - Code updated from Git"
echo "  - Dependencies installed"
echo "  - Database migrated"
echo "  - Caches cleared and rebuilt"
echo "  - Application is now live"
echo ""
