FROM kkarczmarczyk/node-yarn as build
COPY web/app/themes/sage/package.json web/app/themes/sage/yarn.lock ./
RUN yarn
COPY web/app/themes/sage ./
RUN yarn run build:production

FROM composer/composer:alpine as dependencies
ARG ACF_PRO_KEY
WORKDIR /composer/
COPY composer.json composer.lock ./
RUN composer install
WORKDIR /theme/
COPY web/app/themes/sage/composer.json web/app/themes/sage/composer.lock ./
RUN composer install

FROM php:fpm-alpine as app
RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    mariadb-client
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) iconv mcrypt mysqli zip gd
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /bin/wp
COPY . ./
COPY --from=dependencies /composer ./
WORKDIR /var/www/html/web/app/themes/sage/
COPY --from=build /workspace ./
COPY --from=dependencies /theme ./
WORKDIR /var/www/html/
USER root
RUN chown -R www-data:www-data ./
USER www-data
