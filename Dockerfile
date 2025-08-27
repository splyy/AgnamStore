# Image PHP 7.4 avec Apache - simple et stable
FROM php:7.4-apache

# Active mod_rewrite
RUN a2enmod rewrite

# Installe les dépendances système
RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*

# Installe les extensions PHP de base
RUN docker-php-ext-install pdo pdo_mysql

# Installe Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Configure Apache pour pointer vers /var/www/html/web
RUN sed -i 's|/var/www/html|/var/www/html/web|g' /etc/apache2/sites-available/000-default.conf

# Copie tout le projet
COPY . /var/www/html/

# Permissions basiques
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

WORKDIR /var/www/html

# Dépendances seront installées manuellement

EXPOSE 80