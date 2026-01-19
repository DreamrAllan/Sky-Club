#!/bin/bash

# Install Node dependencies and build assets
npm install
npm run build

# Setup Laravel
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Create database if not exists
touch /app/database/database.sqlite

# Run migrations
php artisan migrate --force

# Run seeders
php artisan db:seed --force || true
php artisan db:seed --class=ContentSeeder --force || true
php artisan db:seed --class=PhotoSeeder --force || true

# Create storage link
php artisan storage:link --force || true

echo "Build complete!"
