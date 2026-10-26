FROM php:8.2-apache 

# Instalar extensión para la base de datos
RUN docker-php-ext-install pdo pdo_mysql

# Cambiar la raíz de Apache a la carpeta public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Activar mod_rewrite (muy importante para que funcionen las rutas de tu MVC)
RUN a2enmod rewrite