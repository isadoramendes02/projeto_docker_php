FROM php:8.2-apache

# Instala extensão do PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copia o projeto pro servidor Apache
COPY . /var/www/html/

# Permissão básica
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80