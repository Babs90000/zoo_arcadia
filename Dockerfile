FROM php:8.2-apache

# Extensions nécessaires pour PDO + MySQL/MariaDB
RUN docker-php-ext-install pdo pdo_mysql

# Activer le mod_rewrite Apache (utile pour les .htaccess)
RUN a2enmod rewrite

# Copier tout le code source dans le dossier Apache
COPY . /var/www/html/

# Droits corrects sur les fichiers
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80