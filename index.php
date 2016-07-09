<?php
//Configuration file is included at first.
include_once('db_conf.php');
function __autoload($class_name) {
    include $class_name . '.php';
}
//New instance of Controller
$controller = new Controller();

//Getting route from global array $_GET
$route = $controller->getRoute();

/**
 * In root directory configuration file is `conf.php`
 *
 * In root directory template(view) files are:
 * -- `header.php`. Header stands for top part of application.
 * -- `footer.php`. Footer stands for bottom part of application.
 * -- `sidebar.php`. Stands for sidebar. In sidebar there are no working links. It is created to feel closer to real project.
 * -- `404.php`. If route is not found.
 * -- `add-edit.php`. It stands for Adding/Editing news items
 * -- `list.php`. It stands for List Page and shows all news items with pagination.
 * -- `single-view.php`. Stands for View Page / comments page.
 *
 * In root directory Controller file is `Controller.php`. It works with Model and
 * passes data(variables) to view files.
 *
 * In root directory Model file is `Model.php`. It works with data from database and
 * passes it to Controller.
 */