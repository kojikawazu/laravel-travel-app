#!/bin/bash

# Install dependencies
composer install
npm install

# Build the project
npm run build
