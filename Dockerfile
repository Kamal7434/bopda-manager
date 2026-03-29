# On utilise l'image officielle PHP avec Apache
FROM php:8.3-apache

# Le reste du code reste exactement le même que le précédent
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libpq-dev \
    libzip-dev \
    unzip \
    zip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_pgsql pgsql zip gd

# Installer Composer proprement
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers du projet
COPY . .

# Donner les permissions à Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Installer les dépendances PHP et JS
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Configurer Apache pour pointer vers le dossier public/ de Laravel
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80

# Lancer la migration et démarrer Apache
CMD php artisan migrate --force && apache2-foreground
