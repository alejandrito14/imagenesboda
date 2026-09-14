<?php

$path = trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
$segments = explode('/', $path);
$code = end($segments);

if ($code !== '' && mb_strtolower($code) !== 'i') {
    $_GET['code'] = rawurldecode($code);
}

require dirname(__DIR__) . '/index.php';

