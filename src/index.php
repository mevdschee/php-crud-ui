<?php
use Tqdev\PhpCrudUi\Ui;
use Tqdev\PhpCrudUi\Config;
use Tqdev\PhpCrudUi\RequestFactory;
use Tqdev\PhpCrudUi\ResponseUtils;

require '../vendor/autoload.php';

$config = new Config([
    'url' => 'http://localhost:8000/api.php',
]);
$request = RequestFactory::fromGlobals();
$ui = new Ui($config);
$response = $ui->handle($request);
ResponseUtils::output($response);