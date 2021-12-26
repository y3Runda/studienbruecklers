<?php

require 'db.php';
$did = $_GET['id'];
$discussion = R::findOne('discussions', 'id = ?', [$did]);
if (empty($discussion)) {
    header('Location: /');
    exit();
}
$title = $discussion['title'];

$data = $_POST;
if (!empty($data)) {
    $comment = R::dispense('comments');
    $comment->comment = $data['text'];
    $comment->discussion_id = $discussion['id'];
    $comment->author_id = $_SESSION['user']->id;
    $comment->cdate = date("Y-m-d h:i:s");
    R::store($comment);
    header('Location: /discussion.php?id=' . $discussion['id']);
}

include 'includes/header.php';
?>

<section class="container discussion bg-white">
    <div class="f-title"><h4><?=$discussion['title']?></h4></div>
    <div class="f-text fs-5"><?=$discussion['text']?></div>
    <?php $author = R::findOne('users', 'id = ?', [$discussion['author_id']]); ?>
    <div class="f-info d-flex justify-content-between mt-3 align-items-center">
        <div class="f-creator"><a href="/profile.php?id=<?=$author['id']?>"><?=$author['name']?> <?=$author['surname']?></a> | <?=$discussion['cdate']?> | Комментарии: <?=$discussion['number_comments']?></div>
        <?php if ( $author['id'] == $_SESSION['user']->id ): ?>
        <div><button class="btn btn-danger" onclick="window.location.href='/discussion/delete.php?id=<?=$discussion['id']?>'"><i class="fas fa-trash-alt"></i> Удалить</button></div>
        <?php endif; ?>
    </div>
</section>

<section class="container">
    <form action="discussion.php?id=<?=$discussion['id']?>" method="post">
        <div class="form-group d-flex justify-content-between">
            <textarea class="form-control" id="exampleTextarea" rows="1" name="text" required></textarea>
            <button class="btn btn-lg btn-primary" type="submit" name="create" style="margin-left: 10px;"><i class="fas fa-comment"></i></button>
        </div>
    </form>
</section>

<?php $comments = R::getAll('SELECT * FROM comments WHERE discussion_id = ? ORDER BY cdate DESC', [$discussion['id']]); ?>
<?php foreach ($comments as $comment): ?>
<section class="container">
    <div class="discussion bg-white">
        <div class="f-text fs-5"><?=$comment['comment']?></div>
        <?php $comment_author = R::findOne('users', 'id = ?', [$comment['author_id']]); ?>
        <div class="f-info d-flex justify-content-between mt-3 align-items-center">
            <div class="f-creator"><a href="/profile.php?id=<?=$comment_author['id']?>"><?=$comment_author['name']?> <?=$comment_author['surname']?></a> | <?=$comment['cdate']?></div>
            <?php if ( $comment_author['id'] == $_SESSION['user']->id ): ?>
                <div><button class="btn btn-danger" onclick="window.location.href='/comment/delete.php?id=<?=$comment['id']?>'"><i class="fas fa-trash-alt"></i> Удалить</button></div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endforeach; ?>

<?php include 'includes/footer.php'; ?>