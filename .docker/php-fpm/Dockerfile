# Usar a imagem base oficial do PHP 8.3 com FPM
FROM php:8.3-fpm

# Verificar a distribuição do sistema operacional
RUN cat /etc/os-release

# Definir o ambiente da aplicação (local ou produção)
ARG APP_ENV=local
ENV APP_ENV=$APP_ENV

# Definir o diretório de trabalho
WORKDIR /app

# Instalar dependências do sistema e bibliotecas necessárias
RUN apt-get update && apt-get install -y \
    autoconf \
    g++ \
    make \
    libtool \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zlib1g-dev \
    zip \
    wget \
    curl \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

# Configurar o tempo máximo de execução do PHP
RUN echo "max_execution_time = 5000" >> /usr/local/etc/php/conf.d/docker-php-max-execution-time.ini

# Expor a porta necessária para o PHP-FPM
EXPOSE 9000

# Comando padrão ao iniciar o container
ENTRYPOINT ["sh", "-c", "composer install && php-fpm"]
