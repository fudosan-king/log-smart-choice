#!/bin/sh
rsync --delete -e  'ssh -i deployment/fdk-production.pem' -rlpcgz -v --exclude-from=excludes-view ./ ec2-user@54.238.184.234:/var/www/log-smart-choice/
ssh ec2-user@54.238.184.234 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && composer install'
ssh ec2-user@54.238.184.234 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && npm install'
ssh ec2-user@54.238.184.234 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && php artisan migrate && php artisan db:seed'
ssh ec2-user@54.238.184.234 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && npm run production'