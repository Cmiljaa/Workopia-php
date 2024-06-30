<?php

require __DIR__ . '/../vendor/autoload.php';

require '../helpers.php';

session_start();

use Framework\Router;

// Instantiate the router
$router = new Router();

// Get routes
require basePath('routes.php');

// Get current URI and HTTP method
$uri =  parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Route the request
$router -> route($uri, $method);