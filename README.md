# PHP-CRUD-UI

Single file PHP script that adds a UI to a [PHP-CRUD-API](https://github.com/mevdschee/php-crud-api) project

## Requirements

  - PHP 7.0 or higher with PDO drivers for MySQL, PgSQL or SqlSrv enabled

## Installation

This is a single file application! Upload "`ui.php`" somewhere and enjoy!

For local development you may run PHP's built-in web server:

    php -S localhost:8080

Test the script by opening the following URL:

    http://localhost:8080/ui.php/

Don't forget to modify the configuration at the bottom of the file.

## Compilation

You can install all dependencies of this project using the following command:

    php install.php

You can compile all files into a single "`ui.php`" file using:

    php build.php

NB: The install script will patch the dependencies in the vendor directory for PHP 7.0 compatibility.

### Development

You can access the non-compiled code at the URL:

    http://localhost:8080/src/editor/posts/list

The non-compiled code resides in the "`src`" and "`vendor`" directories. The "`vendor`" directory contains the dependencies.

### Updating dependencies

You can update all dependencies of this project using the following command:

    php update.php

This script will install and run [Composer](https://getcomposer.org/) to update the dependencies.

NB: The update script will patch the dependencies in the vendor directory for PHP 7.0 compatibility.
