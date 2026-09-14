FROM php:8.5-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libsqlite3-dev curl ca-certificates \
    nodejs npm \
    && docker-php-ext-install pdo pdo_sqlite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/html
COPY .env.example /var/www/html/.env

RUN composer install --no-interaction --prefer-dist --no-progress --no-scripts --optimize-autoloader
RUN php artisan key:generate --force
RUN npm install && npm run build

EXPOSE 8000

CMD bash -lc "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"
