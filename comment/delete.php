<?php

require '../db.php';
$id = $_GET['id'];
$comment = R::findOne('comments', 'id = ?', [$id]);
if ( $_SESSION['user']->id == $comment['author_id'] ) {
    R::trash( $comment );
    header("Location: /discussion.php?id=".$comment['discussion_id']);
} else {
    header("Location: /");
}