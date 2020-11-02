# log-smart-choice
## System Requirements:
* Laravel 8.x
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