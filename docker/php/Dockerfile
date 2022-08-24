FROM php:8.1-fpm

ARG PHP_VERSION=8.1
ENV PHP_VERSION ${PHP_VERSION}

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    sqlite3-pcre

WORKDIR /var/www/app
