# Usa una imagen base de PHP con Apache para Laravel (versión 8.2)
FROM php:8.2-apache

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git libxml2-dev

# Habilitar las extensiones necesarias para Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Copiar los archivos del proyecto
COPY . /var/www/html/

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de PHP con Composer
RUN composer install --no-dev --optimize-autoloader

# Establecer permisos adecuados para Laravel
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
