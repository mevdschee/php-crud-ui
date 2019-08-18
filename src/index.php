<?php

namespace Tqdev\PhpCrudUi;

use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudUi\Config;
use Tqdev\PhpCrudUi\Ui;

require '../vendor/autoload.php';

$config = new Config([
    'url' => 'http://localhost:8000/src',
    'templatePath' => '../templates',
]);
$request = RequestFactory::fromGlobals();
$ui = new Ui($config);
$response = $ui->handle($request);
ResponseUtils::output($response);
