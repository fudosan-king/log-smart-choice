#!/bin/bash
./vendor/phpcheckstyle/phpcheckstyle/phpcheckstyle --src . --exclude ./vendor --exclude ./database --exclude ./storage --exclude ./resources/views --outdir report --config ./check_php.xml
./vendor/bin/phpunit