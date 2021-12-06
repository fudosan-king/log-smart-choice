#!/bin/sh
rsync --delete -e  'ssh -i deployment/fdk-production.pem' -rlpcgz -v --exclude-from=excludes-view ./ ec2-user@3.112.13.136:/var/www/log-smart-choice/
ssh ec2-user@3.112.13.136 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && composer install'
ssh ec2-user@3.112.13.136 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && npm install'
ssh ec2-user@3.112.13.136 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && php artisan migrate && php artisan db:seed'
ssh ec2-user@3.112.13.136 -i deployment/fdk-production.pem -t 'cd /var/www/log-smart-choice && npm run production'