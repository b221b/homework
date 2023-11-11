<?php

//метод через rb.php:

require 'rb-mysql.php';
R::setup('mysql:host=localhost;dbname=komercheskaya_test4', 'root', 'root');
    

//метод через composer:
// require_once __DIR__ . '/vendor/autoload.php';
// use \RedBeanPHP\R as R;
// R::setup('mysql:host=localhost;dbname=komercheskaya_test4', 'root', 'root');

?>