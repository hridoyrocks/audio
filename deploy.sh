#!/bin/bash

# Navigate to project directory
cd /home/forge/book.banglaielts.com

# Pull latest changes
git pull origin main

# Install/update composer dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create necessary directories if they don't exist
mkdir -p public/audios
mkdir -p public/pdfs

# Set proper permissions
chmod -R 755 public/audios
chmod -R 755 public/pdfs
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Restart PHP-FPM
sudo service php8.2-fpm reload
