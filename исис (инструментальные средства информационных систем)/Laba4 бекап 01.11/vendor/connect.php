<?php

    $connect = mysqli_connect('localhost', 'root', '', 'Komercheskaya firma2');

    if (!$connect) {
        die('Error connect to DataBase');
    }