FROM php:8.1-apache

# Copy your CodeIgniter files
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable Apache rewrite module for CodeIgniter
RUN a2enmod rewrite

EXPOSE 80

CMD ["apache2-foreground"]