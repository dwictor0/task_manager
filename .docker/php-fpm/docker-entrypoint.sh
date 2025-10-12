#!/bin/bash
set -e

echo "Corrigindo permissões de storage..."
chown -R www-data:www-data /app/storage
chmod -R 775 /app/storage

echo "Instalando dependências Composer..."
composer install --no-interaction --prefer-dist

echo "Aguardando banco de dados ficar pronto..."
until php artisan migrate:status > /dev/null 2>&1; do
    sleep 2
    echo "Esperando DB..."
done

echo "Executando migrações..."
php artisan migrate --force

echo "Gerando chave de aplicação..."
php artisan key:generate

echo "Instalando Laravel Horizon..."
php artisan horizon:install

echo "Iniciando scheduler em background..."
(
  while true; do
    php artisan schedule:run
    sleep 5
  done
) &

echo "Iniciando PHP-FPM..."
exec php-fpm
