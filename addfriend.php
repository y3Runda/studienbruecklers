<?php

header('Location: /');

require 'db.php';
$id = $_GET['id'];

if (empty($_SESSION['user'])) {
    header('Location: /');
}
if ( !(R::findOne('friends', 'friend_1 = ?', [$id])) || !(R::findOne('friends', 'friend_2 = ?', [$id])) ) {
    $friendship = R::dispense('friends');
    $friendship->friend_1 = $_SESSION['user']->id;
    $friendship->friend_2 = $id;
    R::store($friendship);
    header('Location: /profile.php?id=' . $id);
} else {
    header('Location: /');
}