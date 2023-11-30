<?php

include('rb.php');

R::setup('mysql:host=127.0.0.1;port=3306;dbname=test','root','');

if (!R::testConnection()){
    echo('nety');
} else{
    echo('est');
}