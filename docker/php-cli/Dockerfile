FROM node:18.13.0-alpine AS node
FROM php:8.2-cli-alpine3.17

COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
COPY --from=node /usr/local/bin/node /usr/local/bin/node
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN apk add --no-cache autoconf g++ make linux-headers \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN apk add --no-cache postgresql-dev bash coreutils unzip icu \
    && docker-php-ext-install pdo pdo_pgsql intl \
    && docker-php-ext-enable pdo_pgsql intl

RUN apk add --no-cache libxml2-dev \
    && docker-php-ext-install soap \
    && docker-php-ext-enable soap

RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev libzip-dev && \
   docker-php-ext-configure gd \
       --with-freetype=/usr/include/ \
       --with-jpeg=/usr/include/ && \
  docker-php-ext-install gd zip pcntl && \
  apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./php-cli/conf.d /usr/local/etc/php/conf.d

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /app
