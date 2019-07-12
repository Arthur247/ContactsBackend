<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));

include_once ROOT . '/vendor/autoload.php';

try {
    $router = new Contacts\Components\Router();
    $router->run();
} catch (Exception $exception) {
    new Contacts\Components\JsonResponse('exception', $exception->getMessage());
}