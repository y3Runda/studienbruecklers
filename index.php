<?php 

require 'db.php';
include 'includes/header.php';

?>

<?php if ( empty($_SESSION['user']) ): ?>
<div class="container mt-4">
    Зарегистрируйтесь или войдите
</div>
<?php else: ?>

    <?php $user = R::findOne('users', 'id = ?', [$_SESSION['user']->id]); ?>
    <?php if ( empty($user->about) || empty($user->telegram) || empty($user->instagram) ): ?>
    <div class="container mt-4 alert alert-dismissible alert-warning">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <h4 class="alert-heading">Заполните свой профиль!</h4>
        <p class="mb-0">Это нужно для того, чтобы другие узнали о вас больше и имели возможность с Вами связаться.</p>
    </div>
    <?php endif; ?>
    <section class="container mt-4">
        <div class="d-flex justify-content-between">
            <h1 style="margin-bottom: 0!important;">Форум</h1>
            <button type="button" onclick="window.location.href='/discussion/new.php'" class="btn btn-primary"><i class="fas fa-plus"></i> Новое обсуждение</button>
        </div>
    </section>

    <?php $discussions = R::getAll('SELECT * FROM discussions ORDER BY cdate DESC'); ?>
    <?php foreach ($discussions as $discussion): ?>
    <section class="container discussion bg-white">
        <div class="f-title"><h4><?=$discussion['title']?></h4></div>
        <div class="f-text fs-5"><?=$discussion['text']?></div>
        <?php $number_comments = count(R::getAll('SELECT * FROM comments WHERE discussion_id = ?', [$discussion['id']])); ?>
        <?php $author = R::findOne('users', 'id = ?', [$discussion['author_id']]); ?>
        <div class="f-info mt-3 align-items-center">
            <div class="f-creator"><a href="/profile.php?id=<?=$author['id']?>"><?=$author['name']?> <?=$author['surname']?></a> | <?=$discussion['cdate']?> | Комментарии: <?=$number_comments?></div>
            <div><button class="btn btn-primary" onclick="window.location.href='/discussion.php?id=<?=$discussion['id']?>'"><i class="fas fa-comment"></i> Добавить комментарий</button></div>
        </div>
    </section>
    <?php endforeach; ?>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>