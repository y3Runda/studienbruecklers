<?php

require 'db.php';
$title = 'Профиль';
if (!isset($_SESSION['user'])) header("Location: /");

$profile_id = $_GET['id'];
$flag = false;
if ( $profile_id == $_SESSION['user']->id ) $flag = true;

$user = R::findOne('users', 'id = ?', [$profile_id]);

$priority1 = [];
$priority1[0] = R::getCell('SELECT uname FROM universities WHERE id = (SELECT university_id FROM specialities WHERE id = :id)', [':id' => $user->priority1]);
$priority1[1] = R::getCell('SELECT sname FROM specialities WHERE id = :id', [':id' => $user->priority1]);
$priority2 = [];
$priority2[0] = R::getCell('SELECT uname FROM universities WHERE id = (SELECT university_id FROM specialities WHERE id = :id)', [':id' => $user->priority2]);
$priority2[1] = R::getCell('SELECT sname FROM specialities WHERE id = :id', [':id' => $user->priority2]);

$data = $_POST;
if ( isset($data['save-about']) ) {
    $user->about = $data['about'];
    $user->telegram = $data['telegram'];
    $user->instagram = $data['instagram'];
    R::store( $user );
    header("Location: /");
}

include 'includes/header.php';
?>

<div class="container">
    <?php //echo $_GET['id']; ?>
</div>

<section class="container top-profile d-flex justify-content-between">
    <div class="photo-settings">
        <div class="image">
            <img src="public/images/default-photo.jpg" alt="">
        </div>
        <?php if ( $flag ): ?>
        <div class="change-photo-btn">
            <button type="button" class="btn btn-primary disabled"><i class="fas fa-camera"></i> Изменить фото</button>
        </div>
        <div class="change-password-btn">
            <button type="button" class="btn btn-primary" onclick="window.location.href='/vendor/reset.php'"><i class="fas fa-key"></i> Изменить пароль</button>
        </div>
        <?php else: ?>
        <?php if ( !(R::findOne('friends', 'friend_1 = ?', [$_SESSION['user']->id])) || !(R::findOne('friends', 'friend_1 = ?', [$_SESSION['user']->id])) ): ?>
        <div class="change-password-btn">
            <button type="button" class="btn btn-primary disabled" onclick="window.location.href='/addfriend.php?id=<?=$user->id;?>'"><i class="fas fa-user-plus"></i> Добавить в друзья</button>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="info-settings">
        <div class="name-bar text-white"><?php echo $user->name . ' ' . $user->surname; ?></div>
        <div class="birthdate">Дата рождения: <strong><?=$user->birthdate;?></strong></div>
        <div class="universities d-flex justify-content-between">
            <div class="priority card border-primary mb-3" style="margin-right: 1%;">
                <div class="card-header">Приоритет 1</div>
                <div class="card-body">
                    <h4 class="card-title"><?=$priority1[0]?></h4>
                    <p class="card-text"><?=$priority1[1]?></p>
                </div>
            </div>
            <div class="priority card border-primary mb-3" style="">
                <div class="card-header">Приоритет 2</div>
                <div class="card-body">
                    <h4 class="card-title"><?=$priority2[0]?></h4>
                    <p class="card-text"><?=$priority2[1]?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($flag): ?>
<section class="container about-info d-flex justify-content-between">
    <div class="about">
        <h4>О себе</h4>
        <p class="lead">Напишите о своих хобби, увлечениях.</p>
        <form action="/profile.php?id=<?=$_GET['id']?>" method="post">
            <textarea class="form-control" name="about" id="exampleTextarea" rows="5"><?php echo $user->about; ?></textarea>
            <div class="d-flex justify-content-between mt-3">
                <div class="social-networks d-flex justify-content-center mt-2">
                    <div class="form-group" id="telegram_social">
                        <label for="inputTelegram" class="form-label"><i class="fab fa-telegram"></i> Telegram (без @)</label>
                        <input type="text" name="telegram" class="form-control" id="inputTelegram" value="<?php echo $user->telegram; ?>">
                    </div>
                    <div class="form-group">
                        <label for="inputInstagram" class="form-label"><i class="fab fa-instagram"></i> Instagram (без @)</label>
                        <input type="text" name="instagram" class="form-control" id="inputInstagram" value="<?php echo $user->instagram; ?>">
                    </div>
                </div>
                <div class="align-self-end">
                    <button type="submit" name="save-about" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</section>
<?php else: ?>
    <?php if ( !empty($user->telegram) || !empty($user->instagram) || !empty($user->about) ): ?>
    <section class="container about-info d-flex justify-content-between">
        <div class="about">
            <?php if (!empty($user->telegram)) {
                echo '<p class="fs-5"><i class="fab fa-telegram"></i> Telegram: <a href="https://t.me/' . $user->telegram . '"> ' . $user->telegram . '</a></p>';
            }
            ?>
            <?php if (!empty($user->instagram)) {
                echo '<p class="fs-5"><i class="fab fa-instagram"></i> Instagram: <a href="https://instagram.com/' . $user->instagram . '"> ' . $user->instagram . '</a></p>';
            }
            ?>
            <p class="fs-5"><?php echo $user->about; ?></p>
        </div>
    </section>
    <?php endif; ?>
<?php endif; ?>

<!--<section class="container mt-3 friends-info">
    <div class="friends">
        <h4>Друзья</h4>
        <div class="d-flex flex-wrap justify-content-center mt-3">
            <a class="friend d-flex justify-content-center flex-column" href="/index.php">
                <div class="f-photo">
                    <img src="/public/images/default-photo.jpg" alt="">
                </div>
                <div class="f-name">
                    Андрей Снурников
                </div>
            </a>
        </div>
    </div>
</section>-->

<?php include 'includes/footer.php'; ?>
