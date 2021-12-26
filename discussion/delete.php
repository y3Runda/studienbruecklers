<?php

require '../db.php';
$id = $_GET['id'];
$discussion = R::findOne('discussions', 'id = ?', [$id]);
if ( $_SESSION['user']->id == $discussion['author_id'] ) {
    $comments = R::findAll('comments', 'discussion_id = ?', [$discussion['id']]);
    R::trashAll( $comments );
    R::trash( $discussion );
    header("Location: /");
} else {
    header("Location: /");
}