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
### Check modules has been loaded:<br>
`$ php -m`

## Install packages<br>
`composer install`<br>
`npm install`

## Install MongoDB Driver for PHP<br>
Install the PHP MongoDB Extension before installing the PHP Library for MongoDB. You can install the extension using PECL on the command line<br>

`$ sudo pecl install mongodb`<br><br>

Finally, add the following line to your php.ini file:<br>

`extension=mongodb.so`<br>
`extension=pdo.so`

## Voyager - The Missing Laravel Admin<br>
https://voyager-docs.devdojo.com/getting-started/installation

## Access database
mysql -u root
> CREATE DATABASE log_smart;<br>
> CREATE USER 'log_smart'@'localhost';<br>
> GRANT ALL PRIVILEGES ON log_smart.* TO log_smart@localhost WITH GRANT OPTION;<br>
> FLUSH PRIVILEGES;<br>


## Docker

# Build docker
```
docker-compose build --no-cache
```
# Run docker
```
docker-compose up
```
# Run docker as background
```
docker-compose up -d
```
# Clean docker image
```
docker image rm -f $(docker image ls | awk -F' ' '/none/{print $3}')
```
# How to install composer and npm
```
docker-compose build
docker-compose up
docker ps
docker exec -it [CONTAINER ID of log-smart-choice_laravel_1] /bin/bash;
./docker-config/install.sh
php artisan voyager:admin your@email.com --create
```
