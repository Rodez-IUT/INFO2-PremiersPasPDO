<?php

spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\DataSource;
use yasmf\Router;

$dataSource = new DataSource(
    $host = 'localhost',
    $port = '8889',
    $db = 'my_activities',
    $user = 'root',
    $pass = 'root',
    $charset = 'utf8mb4'
);

$router = new Router() ;
$router->route($dataSource);
