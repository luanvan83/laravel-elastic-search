#!/bin/sh

echo "Setting up file permission"
chown -R www-data:www-data /var/www/html/app/
chmod -R 0775 /var/www/html/app/storage/framework /var/www/html/app/storage/logs

echo "Run composer install"
composer install --no-dev

echo "Run migration"
php artisan migrate --force

exec "$@"