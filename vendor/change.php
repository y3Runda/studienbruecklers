<?php

require '../db.php';
$title = 'Создание пароля';

$token = $_GET['token'];
$user = R::findOne('users', 'token = ?', [$token]);
if (!$user) {
    header('Location: /');
}

$errors = array();
$success = array();
$data = $_POST;
if (!empty($data)) {
    if ($data['password1'] == $data['password2']) {
        $user->password = password_hash($data['password1'], PASSWORD_BCRYPT);
        $user->token = '';
        R::store($user);
        header('Location: /');
    } else {
        $errors[] = 'Пароли не совпадают';
    }
}

include '../includes/header.php';

?>


<div class="form-signin">
    <form action="/vendor/change.php?token=<?php echo $_GET['token']; ?>" method="post">
        <h1 class="h2 mb-3 fw-normal">Смена пароля</h1>
        <p class="h6 mb-3 fw-normal">Создайте новый пароль</p>
        <?php if ( !empty($errors) ): ?>
            <div class="card text-white bg-secondary mb-3" style="width: 100%;">
                <div class="card-header">Ошибка</div>
                <div class="card-body">
                    <p class="card-text"><?php echo array_shift($errors); ?></p>
                </div>
            </div>
        <?php endif; ?>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingInput" name="password1" placeholder="Новый пароль" required>
            <label for="floatingInput">Новый пароль</label>
        </div>
        <div class="form-floating">
            <input type="password" class="form-control" id="floatingInput" name="password2" placeholder="Повтор пароля" required>
            <label for="floatingInput">Повтор пароля</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="do_change">Установить пароль</button>
    </form>
</div>


<?php include '../includes/footer.php'; ?>

