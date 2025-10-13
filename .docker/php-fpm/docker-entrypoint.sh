#!/bin/bash
set -e

echo "Corrigindo permissões de storage..."
chown -R www-data:www-data /app/storage /app/bootstrap/cache
chmod -R 775 /app/storage /app/bootstrap/cache

echo "Instalando dependências Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Aguardando banco de dados ficar pronto..."
# Você pode adicionar um loop de espera aqui se quiser garantir que o MySQL esteja pronto

echo "Gerando chave de aplicação..."
php artisan key:generate

echo "Executando migrações..."
# php artisan migrate --force

php artisan horizon

echo "Limpando caches..."

echo "Otimizando autoload..."
composer dump-autoload --optimize

echo "Configurando cron..."
crontab /app/.docker/cron/laravel-scheduler
service cron start

echo "Iniciando scheduler em background..."
(
  while true; do
    php artisan schedule:run
    sleep 60
  done
) &

echo "Iniciando PHP-FPM..."
exec php-fpm
