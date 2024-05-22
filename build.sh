#!/bin/bash

# Composer install
composer install --no-dev --optimize-autoloader

# NPM install and build
npm install
npm run build

# Laravel cache commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
