FROM node:8-stretch as build
WORKDIR /build
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

FROM toxicsalt/wordpress as app
COPY . ./
COPY --from=dependencies /composer ./
WORKDIR /var/www/html/web/app/themes/sage/
COPY --from=build /build ./
COPY --from=dependencies /theme ./
WORKDIR /var/www/html/
