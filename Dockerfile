FROM php:7-cli
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo_mysql
WORKDIR /var/www/html
EXPOSE 8080
CMD ["php", "-S", "0:8080", "-t", "public"]
