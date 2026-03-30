FROM php:8.3-apache

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    curl \
    && docker-php-ext-install pdo_pgsql pgsql zip gd

# Installation de Node.js (nécessaire pour Vite/Tailwind)
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Installation des dépendances PHP et JS
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configuration Apache
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

EXPOSE 80

# On garde la migration automatique au démarrage
CMD php artisan migrate --force && apache2-foreground
