<?php

namespace Tqdev\PhpCrudUi;

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudUi\Config;
use Tqdev\PhpCrudUi\Ui;

require '../vendor/autoload.php';

$config = new Config([
    'api' => [
        'username' => 'php-crud-api',
        'password' => 'php-crud-api',
        'database' => 'php-crud-api',
    ],
    'passwordMapping' => 'string,password$',
    'colorMapping' => 'string,_color$',
    'emailMapping' => 'string,_email$',
    'urlMapping' => 'string,_url$',
    'pointMapping' => 'geometry,_point$',
    'polygonMapping' => 'geometry,_polygon$',
    'templatePath' => '../templates',
]);
$request = RequestFactory::fromGlobals();
$ui = new Ui($config);
$response = $ui->handle($request);
ResponseUtils::output($response);
