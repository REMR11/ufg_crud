#!/usr/bin/env sh
set -e

cd /var/www/html

if [ ! -f artisan ]; then
  echo "No se encontró artisan en /var/www/html."
  echo "Inicializa primero un proyecto Laravel en laravel_app."
  echo "Ejemplo: docker compose run --rm app composer create-project laravel/laravel ."
  exit 1
fi

if [ -f composer.json ]; then
  composer install --no-interaction
fi

if [ ! -f .env ] && [ -f .env.example ]; then
  cp .env.example .env
fi

php artisan key:generate --force || true
php artisan config:clear || true

exec php artisan serve --host=0.0.0.0 --port=8000
