<?php

namespace Tqdev\PhpCrudUi;

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudUi\Config;
use Tqdev\PhpCrudUi\Ui;

require '../vendor/autoload.php';

$config = new Config([
    'api' => [
        'username' => 'sakila',
        'password' => 'sakila',
        'database' => 'sakila',
    ],
    'templatePath' => '../templates',
]);
$request = RequestFactory::fromGlobals();
$ui = new Ui($config);
$response = $ui->handle($request);
ResponseUtils::output($response);
