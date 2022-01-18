FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libzip-dev \
        zip \
        libpng-dev \
        libpq-dev \
        libedit-dev \
        libxml2-dev \
	&& docker-php-ext-configure zip \
	&& docker-php-ext-install zip \
	&& docker-php-ext-install pdo pdo_mysql \
	&& docker-php-ext-install xml \
    && docker-php-ext-install opcache
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
