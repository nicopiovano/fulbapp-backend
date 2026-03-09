#!/bin/sh
set -e

php artisan config:clear

if [ "$APP_ENV" = "local" ]; then
    php artisan migrate:fresh --seed --force
else
    php artisan migrate --force
    php artisan db:seed --force
fi

php artisan serve --no-reload --host=0.0.0.0 --port=8000
