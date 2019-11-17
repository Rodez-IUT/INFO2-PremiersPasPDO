<?php

// Connexion to the database

$dataSource = new \yasmf\DataSource(
    $host = 'localhost',
    $port = '8889',
    $db = 'my_activities',
    $user = 'root',
    $pass = 'root',
    $charset = 'utf8mb4'
);
