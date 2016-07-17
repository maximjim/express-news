<?php

ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Autoload.php');

session_start();

$router = new Router();

$router->run();


