#!/bin/bash

# Defina as permissões para o diretório de armazenamento
echo "Definindo permissões..."
chown -R www-data:www-data /app/storage

# Instalar as dependências do Composer
echo "Instalando dependências com Composer..."
composer install --no-interaction --prefer-dist

# Rodar as migrações do banco de dados
echo "Executando migrações do banco de dados..."
php artisan migrate --force

# Rodar os comandos do Laravel Scheduler em loop
echo "Iniciando o Laravel Scheduler em loop..."
while true; do
    php artisan schedule:run
    sleep 5
done &

# Credenciais
echo "Gerando credenciais"
php artisan key:generate

# Iniciar o PHP-FPM em segundo plano
echo "Iniciando o PHP-FPM..."
php-fpm
