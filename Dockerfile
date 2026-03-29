FROM richarvey/php-apache-heroku:latest

# Copie ton code dans le serveur
COPY . /var/www/app

# Configuration de la racine de Laravel
ENV WEBROOT /var/www/app/public
ENV APP_ENV production

# Installation des dépendances
RUN composer install --no-dev
