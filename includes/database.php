<?php

function boda_db(): mysqli
{
    static $connection = null;

    if ($connection instanceof mysqli) {
        return $connection;
    }

    $host = getenv('BODA_DB_HOST') ?: '127.0.0.1';
    $port = (int) (getenv('BODA_DB_PORT') ?: 8889);
    $user = getenv('BODA_DB_USER') ?: 'root';
    $password = getenv('BODA_DB_PASSWORD') ?: 'root';
    $database = getenv('BODA_DB_NAME') ?: 'baseboda';

    $connection = new mysqli($host, $user, $password, $database, $port);
    $connection->set_charset('utf8mb4');

    return $connection;
}

