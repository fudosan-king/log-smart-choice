#!/usr/bin/env bash
a2enmod rewrite && service apache2 reload
chmod -R 777 /var/www/html/storage
cp /var/www/html/.env.docker /var/www/html/.env
cd /var/www/html && composer install && npm install
cd /var/www/html && php artisan migrate && php artisan key:generate && php artisan voyager:install && php artisan passport:install && php artisan db:seed