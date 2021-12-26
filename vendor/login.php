<?php

require '../db.php';
$title = 'Авторизация';
if (isset($_SESSION['user'])) header("Location: /");

$data = $_POST;
if ( isset($data['do_login']) ) {

    $errors = array();
    $user = R::findOne('users', 'email = ?', [$data['email']]);
    if ( $user ) {
        // 123
        if ( $user->is_banned == 1 ) {
            if ( $user->status == 1 ) {
                if (password_verify($data['password'], $user->password)) {
                    $_SESSION['user'] = $user;
                    header("Location: /");
                } else {
                    $errors[] = 'Неверный пароль';
                }
            } else {
                $errors[] = 'Аккаунт не подтверждён';
            }
        } else {
            $errors[] = 'Аккаунт заблокирован';
        }
    } else {
        $errors[] = 'Пользователя с таким e-mail не найдено';
    }

}

include '../includes/header.php';
?>

<section>
    <div class="form-signin">
        <form action="/vendor/login.php" method="post">
            <h1 class="h2 mb-3 fw-normal">Авторизация</h1>
            <p class="h6 mb-3 fw-normal">Если у вас нет аккаунта <a href="/vendor/signup.php">зарегистрируйтесь</a></p>

            <?php if ( !empty($errors) ): ?>
                <div class="card text-white bg-secondary mb-3" style="width: 100%;">
                    <div class="card-header">Ошибка входа</div>
                    <div class="card-body">
                        <p class="card-text"><?php echo array_shift($errors); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-floating">
                <input type="email" class="form-control br-blr" id="floatingInput" name="email" placeholder="Email" required>
                <label for="floatingInput">Email</label>
            </div>
            <div class="mt-2 form-floating">
                <input type="password" class="form-control br-tlr" id="floatingPassword" name="password" placeholder="Пароль" required>
                <label for="floatingPassword">Пароль</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="do_login">Войти</button>
        </form>
        <p class="h6 mt-3 fw-normal">Забыли пароль? <a href="/vendor/reset.php">Перейдите сюда</a></p>
    </div>
</section>

<?php include '../includes/footer.php'; ?>