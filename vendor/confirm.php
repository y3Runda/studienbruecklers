<?php

require '../db.php';

$token = $_GET['token'];
$user = R::findOne('users', 'token = ?', [$token]);
if ( $user ) {
    $user->token = '';
    $user->status = 1;
    R::store( $user );
    header("Location: /vendor/login.php");
} else {
    header("Location: /");
}