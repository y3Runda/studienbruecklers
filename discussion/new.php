<?php

require '../db.php';
$title = 'Новое обсуждение';

$data = $_POST;
if (!empty($data)) {
    $discussion = R::dispense('discussions');
    $discussion->title = $data['title'];
    $discussion->text = $data['text'];
    $discussion->author_id = $_SESSION['user']->id;
    $discussion->cdate = date("Y-m-d h:i:s");
    $discussion->number_comments = 0;
    R::store($discussion);
    header('Location: /');
}

include '../includes/header.php';

?>

<section class="container mt-4">
    <h3 class="mb-3">Создать новое обсуждение</h3>
    <form action="/discussion/new.php" method="post">
        <div class="form-floating">
            <input type="text" class="form-control" id="floatingInput" name="title" placeholder="Заголовок" required>
            <label for="floatingInput">Заголовок</label>
        </div>
        <div class="form-group">
            <label for="exampleTextarea" class="form-label mt-4">Хорошо распишите тему нового обсуждения</label>
            <textarea class="form-control" id="exampleTextarea" rows="7" name="text" required></textarea>
        </div>
        <button class="btn btn-lg btn-primary mt-3" type="submit" name="create"><i class="fas fa-plus"></i> Создать</button>
    </form>
</section>

<?php include '../includes/footer.php'; ?>
