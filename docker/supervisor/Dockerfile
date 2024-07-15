FROM php:8.2.13-fpm-alpine3.18

RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        curl \
        wget \
        icu-dev \
        git \
        linux-headers \
        libzip-dev \
        supervisor \
     && pecl install \
        xdebug \
    && docker-php-ext-enable \
        xdebug

RUN docker-php-ext-install -j$(nproc) \
        sockets \
        pcntl

RUN mkdir /var/log/supervisor
