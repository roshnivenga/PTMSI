FROM php:8.2-apache

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Set working directory to Laravel's root
WORKDIR /var/www/html

# Copy everything from project
COPY . .

# Set correct document root to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config to point to the public folder
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Set correct file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80
CMD ["apache2-foreground"]
