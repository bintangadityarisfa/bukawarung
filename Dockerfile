FROM php:8.4-cli

RUN apt-get update && apt-get install -y default-mysql-client \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# Tidak perlu set WORKDIR karena kamu ingin pakai root /
COPY ./src /      # Copy isi src ke root container /

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/"]
