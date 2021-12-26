<?php

require '../db.php';
$title = 'Регистрация';
if (isset($_SESSION['user'])) header("Location: /");

$universities = R::getAll("SELECT * FROM universities");
$specialities = R::getAll('SELECT * FROM specialities');

function createToken() {
    return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 30)), 0, 30);
}

$data = $_POST;
if ( isset($data['do_signup']) ) {
    $errors = array();
    if ( R::findOne('users', 'email = ?', [$data['email']]) ) {
        $errors[] = 'Этот e-mail уже используется';
    } else if ( empty($data['priority1']) || empty($data['priority2']) ) {
        $errors[] = 'Выберете приоритеты';
    } else if ( $data['priority1'] == $data['priority2'] ) {
        $errors[] = 'Выбранные приоритеты не могут совпадать';
    } else if ( $data['password1'] != $data['password2'] ) {
        $errors[] = 'Повторный пароль введён неверно';
    }

    if ( empty($errors) ) {

        //$token = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 30)), 0, 30);

        $token = createToken();

        $user = R::dispense('users');
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->birthdate = $data['birthdate'];
        $user->priority1 = $data['priority1'];
        $user->priority2 = $data['priority2'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password1'], PASSWORD_BCRYPT);
        $user->token = $token;
        $user->status = 0;
        $user->is_banned = 0;
        $user->about = '';
        $user->telegram = '';
        $user->instagram = '';
        R::store($user);

        $actual_link = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/confirm.php?token='.$token;
        $success = array();
        mail($data['email'], 'Подтверждение почты', "Перейдите по ссылке, чтобы подтвердить свою почту: $actual_link");
        $success[] = 'Подтвердите почту';

    }
}

include '../includes/header.php';
?>

<section>
    <div class="form-signin">
        <form action="/vendor/signup.php" method="post">
            <h1 class="h2 mb-3 fw-normal">Регистрация</h1>
            <p class="h6 mb-3 fw-normal">Уже есть аккаунт? <a href="/vendor/login.php">Авторизуйтесь</a></p>

            <?php if ( !empty($errors) ): ?>
            <div class="card text-white bg-secondary mb-3" style="width: 100%;">
                <div class="card-header">Ошибка регистрации</div>
                <div class="card-body">
                    <p class="card-text"><?php echo array_shift($errors); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <?php if ( !empty($success) ): ?>
                <div class="card text-white bg-primary mb-3" style="width: 100%;">
                    <div class="card-header">Успешная регистрация</div>
                    <div class="card-body">
                        <p class="card-text"><?php echo array_shift($success); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-floating">
                <input type="text" class="form-control br-blr" name="surname" id="floatingInput" placeholder="Фамилия" value="<?php echo @$data['surname']; ?>">
                <label for="floatingInput">Фамилия</label>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control br-tlr" name="name" id="floatingInput" placeholder="Имя" value="<?php echo @$data['name']; ?>">
                <label for="floatingInput">Имя</label>
            </div>

            <div class="mt-2 form-floating">
                <input type="date" class="form-control" name="birthdate" id="floatingPassword" placeholder="Дата рождения" value="<?php echo @$data['birthdate']; ?>">
                <label for="floatingPassword">Дата рождения</label>
            </div>

            <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
                <label class="form-label">Первый приоритет</label>
                <select required class="form-select" name="priority1" style="margin-bottom: 10px;">
                    <option selected disabled>Университет и специальнось</option>
                    <?php
                    for ($i = 0; $i <= 7; $i++) {
                        ?>
                        <optgroup label="<?=$universities[$i]["uname"]?>">
                            <?php for ($j = 0; $j < count($specialities); $j++) { ?>
                                <?php if ($specialities[$j]["university_id"] == $i + 1) { ?>
                                    <option value="<?php echo $specialities[$j]["id"]; ?>"><?php echo $specialities[$j]["sname"]; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group" style="margin-bottom: 20px;">
                <label for="exampleSelect1" class="form-label">Второй приоритет</label>
                <select required class="form-select" name="priority2" style="margin-bottom: 10px;">
                    <option selected disabled>Университет и специальнось</option>
                    <?php for ($i = 0; $i <= 7; $i++) { ?>
                        <optgroup label="<?=$universities[$i]["uname"]?>">
                            <?php for ($j = 0; $j < count($specialities); $j++) { ?>
                                <?php if ($specialities[$j]["university_id"] == $i + 1) { ?>
                                    <option value="<?php echo $specialities[$j]["id"]; ?>"><?php echo $specialities[$j]["sname"]; ?></option>
                                <?php } ?>
                            <?php } ?>
                        </optgroup>
                    <?php } ?>
                </select>
            </div>

            <div class="form-floating">
                <input type="email" class="form-control br-blr" name="email" id="floatingInput" placeholder="Email" required>
                <label for="floatingInput">Email</label>
            </div>
            <div class="mt-2 form-floating">
                <input type="password" class="form-control br-tlr br-blr" name="password1" id="floatingPassword" placeholder="Пароль" required>
                <label for="floatingPassword">Пароль</label>
            </div>
            <div class="mt-2 form-floating">
                <input type="password" class="form-control br-tlr" name="password2" id="floatingPassword" placeholder="Пароль" required>
                <label for="floatingPassword">Повтор пароля</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit" name="do_signup">Регистрация</button>
        </form>
    </div>
</section>

<?php include '../includes/footer.php'; ?>