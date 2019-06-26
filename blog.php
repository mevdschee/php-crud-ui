<?php
include "ui.php";

session_start();
$ui = new PHP_CRUD_UI(array(
    'url' => 'http://localhost:8000/api.php',
));
echo $ui->executeCommand();







