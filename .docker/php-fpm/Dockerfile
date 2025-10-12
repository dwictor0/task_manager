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
    libxml2-dev \
    cron \
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
    && docker-php-ext-install gd mysqli pdo pdo_mysql zip pcntl dom \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pcntl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'ed0feb545ba87161262f2d45a633e34f591ebb3381f2e0063c345ebea4d228dd0043083717770234ec00c5a9f9593792') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"


COPY . /app

RUN composer install --no-interaction --prefer-dist --optimize-autoloader


RUN git config --global --add safe.directory /app

# Configurar o tempo máximo de execução do PHP
RUN echo "max_execution_time = 100" >> /usr/local/etc/php/conf.d/docker-php-max-execution-time.ini



COPY .docker/cron/laravel-scheduler /etc/cron.d/laravel-scheduler

RUN chmod 0644 /etc/cron.d/laravel-scheduler

RUN crontab /etc/cron.d/laravel-scheduler


# Expor a porta necessária para o PHP-FPM
EXPOSE 9000


COPY .docker/php-fpm/docker-entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
ENV PATH="/usr/local/bin:$PATH"

RUN mkdir -p /app/storage /app/bootstrap/cache \
    && chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache
