FROM php:8.1-fpm-alpine

RUN apk update
RUN apk upgrade
RUN apk add bash

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli
RUN docker-php-ext-enable mysqli

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN sed -i -e "s/^ *memory_limit.*/memory_limit = 4G/g" -e "s/^ *max_execution_time.*/max_execution_time = 0/g" /usr/local/etc/php/php.ini

ENTRYPOINT [ "composer", "--ignore-platform-reqs" ]
