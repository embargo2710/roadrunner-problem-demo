FROM composer/composer:2-bin AS composer

FROM ghcr.io/roadrunner-server/roadrunner:2023.1.2 AS roadrunner

FROM mlocati/php-extension-installer:2 AS php_extension_installer

FROM php:8.2-cli-alpine AS php

RUN apk add --no-cache --update \
    curl \
    nano \
    gettext \
    git \
    sudo \
    acl

COPY --from=php_extension_installer /usr/bin/install-php-extensions /usr/local/bin/install-php-extensions

COPY --from=roadrunner /usr/bin/rr /usr/local/bin/rr

RUN install-php-extensions sockets

ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer /composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install

COPY . .
