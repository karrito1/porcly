#!/bin/sh
set -e

mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/testing
mkdir -p /var/www/html/storage/logs

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

exec apache2-foreground
