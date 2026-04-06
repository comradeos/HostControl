FROM php:8.3-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    zip \
    && docker-php-ext-install \
    pdo_mysql \
    intl \
    zip \
    opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]