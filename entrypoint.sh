#!/bin/sh
set -e

composer dump-autoload
php artisan migrate --force --no-interaction
#php artisan db:seed --force --no-interaction
php artisan octane:install --server=roadrunner
php artisan optimize:clear --no-interaction
#php artisan optimize --no-interaction
php artisan storage:link --force --no-interaction

exec "$@"
