#!/bin/bash

# Update and install PHP and Composer
apt-get update && apt-get install -y php-cli php-mbstring unzip curl
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
composer install
npm install

# Build the project
npm run build
