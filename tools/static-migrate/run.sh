#!/usr/bin/env bash
#
# Migration du site PHP vers HTML statique.
# Lance le conteneur Apache+PHP (fidèle à la production), exécute migrate.php dedans.
#
# Usage : ./tools/static-migrate/run.sh
# Variables d'environnement : IMAGE (défaut: ct-webserver:latest), PORT (défaut: 8123)
#
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SITE_DIR="$(cd "$SCRIPT_DIR/../.." && pwd)"
IMAGE="${IMAGE:-ct-webserver:latest}"
CONTAINER="${CONTAINER:-ct-migrate}"
PORT="${PORT:-8123}"

echo "==> Site   : $SITE_DIR"
echo "==> Image  : $IMAGE"

docker rm -f "$CONTAINER" >/dev/null 2>&1 || true

echo "==> Démarrage du conteneur Apache+PHP..."
# - AllowOverride All : autorise le .htaccess du site (rewrite extensionless, comme en production)
# - zz-migrate.ini : display_errors=Off dans le conteneur de crawl. NB : la production a en
#   réalité display_errors=On (elle émet les mêmes warnings), mais ils atterrissent tous dans
#   des attributs class="..." du menu — invisibles pour le visiteur (jetons CSS inertes).
#   On génère volontairement un HTML propre : rendu identique, sans ~2,5 Ko de garbage/page.
#   Sans cet ini, l'image php:5.6 (aucun php.ini chargé => display_errors=On) cuit les
#   warnings latents du code (ex. get_menu_class() à 1 argument dans navbar.php) dans le HTML.
#   Les erreurs restent loggées sur stderr (visibles via docker logs).
docker run -d --rm --name "$CONTAINER" \
    -v "$SITE_DIR":/var/www/html \
    -p "127.0.0.1:${PORT}:80" \
    "$IMAGE" \
    bash -c "sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf && printf 'display_errors=Off\nlog_errors=On\nerror_log=/dev/stderr\ndate.timezone=Europe/Paris\n' > /usr/local/etc/php/conf.d/zz-migrate.ini && exec apache2-foreground" >/dev/null

cleanup() { docker rm -f "$CONTAINER" >/dev/null 2>&1 || true; }
trap cleanup EXIT

echo "==> Attente du serveur..."
ok=0
for _ in $(seq 1 30); do
    if curl -sf -o /dev/null "http://127.0.0.1:${PORT}/index.php"; then ok=1; break; fi
    sleep 1
done
[ "$ok" = 1 ] || { echo "ERREUR : Apache ne répond pas (logs : docker logs $CONTAINER)"; exit 1; }

echo "==> Génération du site statique..."
docker exec "$CONTAINER" php /var/www/html/tools/static-migrate/migrate.php

# Les fichiers sont créés par root dans le conteneur : on les rend à l'utilisateur courant
docker exec "$CONTAINER" chown -R "$(id -u):$(id -g)" /var/www/html/dist

echo ""
echo "==> Terminé : $SITE_DIR/dist/"
echo "    Rapport          : $SCRIPT_DIR/report.txt"
echo "    Fonction CF      : $SCRIPT_DIR/cloudfront-function.js"
