<?php

require 'ui.php';

//session_start();
$ui = new PHP_CRUD_UI(array(
    'url' => 'http://localhost:8000/blog.php',
));
echo $ui->executeCommand();
