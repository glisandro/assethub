#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down) || true
    # Update codebase
    git fetch origin main
    git reset --hard origin/main

    composer self-update --2

    # Verifico Compativilidad https://styde.net/composer-2-0-ya-esta-disponible/
    composer check-platform-reqs --no-dev

    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader

    # Migrate database
    php artisan migrate --force

    # Note: If you're using queue workers, this is the place to restart them.
    # ...

    # Clear cache
    php artisan optimize

    # Reload PHP to update opcache
    echo "" | sudo -S service php7.4-fpm reload 
    
    npm install
    
    npm run dev #TODO: Esta temporalmente con dev porque con prod desaparecen los estilos indigos de los botones
# Exit maintenance mode
php artisan up

echo "Application deployed!"