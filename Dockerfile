# Gunakan PHP 8.4 dengan Apache
FROM php:8.4-apache

# Install mysqli extension dan mysql client
RUN apt-get update && apt-get install -y default-mysql-client \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# Copy semua kode dari folder src ke /var/www/html (web root)
COPY ./src /var/www/html/

# Buka port 80 untuk web server
EXPOSE 80

# Jalankan Apache di foreground
CMD ["apache2-foreground"]
