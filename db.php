<?php

require 'libs/rb.php';

$host = 'localhost';
$name = 'studienbruecklers';
$user = 'root';
$pass = '';

R::setup( "mysql:host=$host;dbname=$name", $user, $pass );

function debug($str) {
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}

session_start();