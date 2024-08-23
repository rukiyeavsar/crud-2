FROM php:8.3-fpm

# Gerekli paketleri ve PHP uzantılarını kuruyoruz
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install intl \
    && docker-php-ext-configure zip --with-zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Composer'ı kuruyoruz
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . .

# Composer ile bağımlılıkları kuruyoruz
RUN composer install

# Laravel uygulamasını başlatıyoruz
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=82"]
