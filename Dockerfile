# Usa una imagen base de PHP
FROM php:7.4-apache

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copia el contenido de tu proyecto al directorio de Apache
COPY . /var/www/html/

# Instala las extensiones necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Exponer el puerto 80
EXPOSE 80
