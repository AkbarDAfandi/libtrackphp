# Use PHP 8.2 with Apache as the base image
FROM php:8.2-apache

# Install required system dependencies and PHP extensions for MySQL
RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache rewrite module if your project uses .htaccess
RUN a2enmod rewrite

# Set the working directory inside the container
WORKDIR /var/www/html

# Copy project files to the container
COPY . /var/www/html/

# Set correct permissions for the web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for Coolify's reverse proxy
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]