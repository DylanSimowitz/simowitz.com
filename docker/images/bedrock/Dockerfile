FROM toxicsalt/bedrock:latest

COPY composer.json composer.lock ./
RUN composer install
COPY web/app/themes/sage/package.json web/app/themes/sage/yarn.lock ./web/app/themes/sage/
RUN npm install
RUN npm build:production
COPY . ./
