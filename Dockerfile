FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install --quiet --yes --no-install-recommends \
libfreetype6-dev \
libjpeg62-turbo-dev \
libpng-dev \
libzip-dev \
zip unzip \
libpq-dev \
&& docker-php-ext-install pdo pdo_mysql pdo_pgsql pcntl zip gd bcmath\
# && pecl install -o -f redis-5.3.7 \
&& pecl install redis \
&& docker-php-ext-enable redis

# RUN apt get install php8.1-zip

# RUN docker-php-ext-install zip gd

COPY .docker/php/limit.ini /usr/local/etc/php/conf.d/limit.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -g appuser \
        -G www-data,root --shell /bin/bash \
        --create-home appuser

USER appuser
