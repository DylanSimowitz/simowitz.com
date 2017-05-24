FROM toxicsalt/bedrock:latest

COPY composer.json composer.lock ./
COPY web/app/themes/sage/package.json web/app/themes/sage/yarn.lock ./web/app/themes/sage/
RUN chown -R www-data:www-data /var/www/html/
USER www-data
RUN composer install
WORKDIR ./web/app/themes/sage/
RUN npm install
RUN npm build:production
WORKDIR /var/www/html/
COPY . ./
