FROM php:8.3-cli

RUN apt-get update && apt-get install -y unzip libzip-dev libpq-dev libonig-dev libxml2-dev \
    && docker-php-ext-install zip pdo pdo_pgsql mbstring xml \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN chmod +x start.sh

CMD ["sh", "start.sh"]
