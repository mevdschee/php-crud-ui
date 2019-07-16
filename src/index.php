<?php
use Tqdev\PhpCrudApi\RequestFactory;
use Tqdev\PhpCrudApi\ResponseUtils;
use Tqdev\PhpCrudUi\Config;
use Tqdev\PhpCrudUi\Ui2;

require '../vendor/autoload.php';

$config = new Config([
    'url' => 'http://localhost:8000/api.php',
]);
$request = RequestFactory::fromGlobals();
$ui = new Ui2($config);
$response = $ui->handle($request);
ResponseUtils::output($response);
