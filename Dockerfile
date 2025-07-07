FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip zip git curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory first
WORKDIR /var/www/html

# Copy Laravel app
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set Apache to use public folder as web root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Set permissions and run Laravel setup (after files are copied!)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache \
    && php artisan config:clear \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force

EXPOSE 80
CMD ["apache2-foreground"]
