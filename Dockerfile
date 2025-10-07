FROM php:8.4-cli

RUN apt-get update && apt-get install -y default-mysql-client \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# Copy semua file di root project ke root container /
COPY . /     

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/"]
