#!/bin/bash

if [ $# -ne 1 ]; then
    echo "Usage: $0 <nom_d_utilisateur>"
    exit 1
fi

utilisateur="$1"

PROJECT_DIR="/home/$utilisateur/Téléchargement"

# Clone du backend Symfony
echo "Clonage du projet Symfony"
git clone https://gitlab.eemi.tech/morgane.dassonville/partiel_symfony "$PROJECT_DIR"
cd "$PROJECT_DIR/backend"


composer install --no-interaction --optimize-autoloader
php bin/console assets:install

echo "Lancement du serveur Symfony"
php bin/console server:start --env=prod &

sleep 5





echo "Construction du frontend"
yarn encore dev

symfony serve

echo "Les serveurs sont lancés. Utilisez Ctrl+C pour les arrêter."

