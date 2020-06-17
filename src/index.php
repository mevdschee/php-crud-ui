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
    'formatMapping' => [
        'string' => [
            '/_color$/' => [
                'format' => 'color',
                'hint' => '#8888ff',
                'pattern' => '/#[0-9a-f]{6}/',
                'maxLength' => 7,
            ],
            '/_email$/' => [
                'format' => 'email',
                'hint' => 'xx@xx.xx',
            ],
        ],
        'geometry' => [
            '/_point$/' => 'point',
        ],
    ],
    'templatePath' => '../templates',
]);
$request = RequestFactory::fromGlobals();
$ui = new Ui($config);
$response = $ui->handle($request);
ResponseUtils::output($response);
