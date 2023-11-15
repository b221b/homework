<?php

//метод через rb.php:
// require 'libs/rb-mysql.php';
// try {

//     R::setup('mysql:host=127.0.0.1; port=3306;dbname=komercheskaya_test4', 'root', '');

//     if (!R::testConnection()) {
//         exit('<h1>Cannot connect to the database</h1>');
//     } else {
//         echo '<h1>You are connected.';
//     }
// } catch (Exception $e) {
//     exit('<h1>Cannot connect to the database: </h1>' . $e->getMessage());
// }



// из методы:
// include ("libs/rb-mysql.php");

// R::setup('mysql:host=localhost; dbname=test', 'root', '');

// if (!R::testConnection()) {
//         exit('<h1>Cannot connect to the database</h1>');
//     } else {
//         echo '<h1>You are connected.</h1>';
//     }

// из методы:
include("libs/rb.php");

R::setup("mysql:host=127.0.0.1;dbname=ydacha", "root", "");

if (!R::testConnection()) {
    // R::fancyDebug(TRUE);
    echo('<h1>Cannot connect to the database</h1>');
} else {
    exit('<h1>You are connected.</h1>') ;
}



// $conn = new mysqli("localhost", "root", "", "ydacha");
// $conn->query("SET NAMES 'utf8'");

// if ($conn->connect_error) {
//     echo('<h1>Cannot connect to the database</h1>');
// } else {
//     exit('<h1>You are connected.</h1>') ;
// }



//метод через pdo:
// require 'libs/rb.php';
// try{
//     $db = new PDO('mysql:host=localhost;dbname=komercheskaya_test4','root','');
// } catch(PDOException $e){
//     echo $e->getmessage();
// }
// print_r(PDO::getAvailableDrivers());




//метод через composer:
// require_once __DIR__ . '/vendor/autoload.php';
// use \RedBeanPHP\R as R;
// R::setup('mysql:host=localhost;dbname=ydacha', 'root', 'root1');
// if (!R::testConnection()    )
// {
//     exit('нет подключения к базе данных');
// }