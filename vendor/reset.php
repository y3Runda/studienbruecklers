<?php

require '../db.php';
$title = 'Смена пароля';

$data = $_POST;
if ( !empty($data) ) {
    $user = R::findOne('users', 'email = ?', [$data['email']]);
    $errors = array();
    if ( $user ) {
        $token = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 30)), 0, 30);
        $user->token = $token;
        R::store($user);
        $actual_link = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/change.php?token='.$token;
        $success = array();
        mail($data['email'], 'Смена пароля', "Перейдите по ссылке, чтобы сменить пароль: $actual_link");
        $success[] = 'Письмо отправлено';
    } else {
        $errors[] = "Аккаунта с такой электронной почтой не существует";
    }
}

include '../includes/header.php';
?>

<div class="form-signin">
    <form action="/vendor/reset.php" method="post">
        <h1 class="h2 mb-3 fw-normal">Смена пароля</h1>
        <p class="h6 mb-3 fw-normal">Введите почту своего аккаунта</p>
        <?php if ( !empty($errors) ): ?>
            <div class="card text-white bg-secondary mb-3" style="width: 100%;">
                <div class="card-header">Ошибка</div>
                <div class="card-body">
                    <p class="card-text"><?php echo array_shift($errors); ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ( !empty($success) ): ?>
            <div class="card text-white bg-primary mb-3" style="width: 100%;">
                <div class="card-header">Успех</div>
                <div class="card-body">
                    <p class="card-text"><?php echo array_shift($success); ?></p>
                </div>
            </div>
        <?php endif; ?>
        <div class="form-floating">
            <input type="email" class="form-control" id="floatingInput" name="email" placeholder="Email" required>
            <label for="floatingInput">Email</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit" name="do_login">Получить письмо</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
