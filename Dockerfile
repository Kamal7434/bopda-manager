FROM richarvey/php-apache-heroku:latest

# Définir le répertoire de travail
WORKDIR /var/www/app

# Copier tout le projet Laravel
COPY . .

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Installer les dépendances JS et compiler les assets (Vite/Tailwind)
RUN apk add --no-cache nodejs npm && \
    npm install && \
    npm run build

# Configuration Apache pour Laravel
ENV WEBROOT /var/www/app/public
ENV APP_ENV production

# Droits d'écriture pour Laravel
RUN chown -R www-data:www-data storage bootstrap/cache
