# Utiliser l'image officielle PHP avec Apache
FROM php:7.4-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copier le contenu du projet dans le dossier racine d'Apache
COPY front-end/ /var/www/html/front-end/
COPY back-end/ /var/www/html/back-end/

# Exposer le port 80 pour le serveur Apache
EXPOSE 80

# Ajouter une commande pour démarrer le serveur Apache
CMD ["apache2-foreground"]
