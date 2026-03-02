FROM php:8.2-fpm

WORKDIR /var/www

# Remove pasta padrão
RUN rm -rf /var/www/html

# Dependências necessárias para Laravel API
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/*

# Extensões PHP necessárias
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif

# GD (se realmente usar)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Redis via PECL (forma mais simples)
RUN pecl install redis \
    && docker-php-ext-enable redis

# Composer oficial (mais seguro)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Criar usuário
RUN groupadd -g 1000 laravel \
    && useradd -u 1000 -ms /bin/bash -g laravel laravel

USER laravel

EXPOSE 9000

CMD ["php-fpm"]