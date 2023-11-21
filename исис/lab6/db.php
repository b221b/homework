<?php

require 'rb.php';

R::setup('mysql:host=localhost;dbname=miroslav','root','');

// if (!R::testConnection()){
//     echo('Нет ');
// } else{
//     exit('есть');
// }