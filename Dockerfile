FROM php:8.2-apache

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable mod_rewrite for Laravel
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project into container
COPY . .

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expose port
EXPOSE 80

# Start Laravel server using Apache
CMD ["apache2-foreground"]
