FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    procps \
    curl \
    zip \
    unzip \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
