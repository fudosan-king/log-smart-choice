# log-smart-choice
## System Requirements:
* NPM >= 7.0.3
* Composer >= 2.0.6
* <a href="https://laravel.com/docs/8.x/installation">Laravel 8.x</a>
* PHP >= 7.3
* Mongodb >= 3
* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* PDO PHP Extension
* <a href="https://laravel.com/docs/8.x/passport">Passport >= 10.1</a>
### Check modules has been loaded:<br>
`$ php -m`

## Install packages<br>
`composer install`<br>
`npm install`

## Install MongoDB Driver for PHP<br>
Install the PHP MongoDB Extension before installing the PHP Library for MongoDB. You can install the extension using PECL on the command line<br>

`$ sudo pecl install mongodb` <br>
`$ sudo yum install libsodium libsodium-devel` <br>
`$ sudo pecl install libsodium` <br>

Finally, add the following line to your php.ini file:<br>

`extension=mongodb.so`<br>
`extension=sodium.so`<br>

## Voyager - The Missing Laravel Admin<br>
https://voyager-docs.devdojo.com/getting-started/installation

## Access database
mysql -u root
> CREATE DATABASE log_smart;<br>
> CREATE USER 'log_smart'@'localhost';<br>
> GRANT ALL PRIVILEGES ON log_smart.* TO log_smart@localhost WITH GRANT OPTION;<br>
> FLUSH PRIVILEGES;<br>

## Import estates in FDK
Config in .env
```
FDK_HOST=fudosan-king.jp
FDK_URL=http://fudosan-king.jp
LOG_SMART_CHOICE_API_PATH=/api/log_smart_choice // path(log_smart_choice): define return estates checked log_smart_choice
```
How to run
>php artisan estates:import_from_fdk

Add crontab to Schedule
```
* * * * * php ~/project/log-smart-choice/artisan schedule:run
```


# Docker

## Build docker
```
docker-compose build --no-cache
```
## Run docker
```
docker-compose up
```
## Run docker as background
```
docker-compose up -d
```
## Clean docker image
```
docker image rm -f $(docker image ls | awk -F' ' '/none/{print $3}')
```
## How to install composer and npm
```
docker-compose build
docker-compose up
docker ps
docker exec -it [CONTAINER ID of log-smart-choice_laravel_1] /bin/bash;
./docker-config/install.sh
php artisan voyager:admin your@email.com --create

php artisan passport:client --personal
```


```
ALTER USER 'root'@'localhost' IDENTIFIED BY 'hgLJ8-8FW9#vD[jM';
CREATE USER 'log_smart'@'localhost' IDENTIFIED BY 'sP9m%c7cDUy.ey}{';
```
