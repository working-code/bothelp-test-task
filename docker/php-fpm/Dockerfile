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
     && pecl install \
        xdebug \
    && docker-php-ext-enable \
        xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
