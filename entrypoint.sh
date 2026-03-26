#!/bin/sh

# Exit immediately if a command exits with a non-zero status
set -e

echo "Waiting for database to be ready..."
php artisan optimize
# Loop until connection to DB_HOST on DB_PORT is successful
# We use the env variables Laravel already uses
while ! nc -z $DB_HOST ${DB_PORT:-3306}; do
  sleep 1
done

echo "Database is up! Running migrations..."

php artisan migrate --force  --seed

echo "Starting Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=8000
