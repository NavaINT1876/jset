<?php
include_once('db_conf.php');

function __autoload($class_name) {
    include $class_name . '.php';
}

$controller = new Controller();

$route = $controller->getRoute();