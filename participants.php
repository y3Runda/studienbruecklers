<?php

require 'db.php';

if (!isset($_SESSION['user'])) header("Location: /");

$users = R::getAll('SELECT * FROM users ORDER BY surname ASC');

include 'includes/header.php';
?>

<div class="container my-4">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Фото</th>
                <th scope="col">Фамилия, Имя</th>
                <th scope="col">День рождение</th>
                <th scope="col">Приоритет 1</th>
                <th scope="col">Приоритет 2</th>
            </tr>
        </thead>
        <tbody>

            <?php for ($i = 0; $i < count($users); $i++): ?>
            <?php if ($users[$i]["id"] == $_SESSION['user']->id): ?>
                <tr class="table-active">
                    <td><img src="/public/images/default-photo.jpg" alt="" width="50" height="50"></td>
                    <th scope="row"><a href="/profile.php?id=<?php echo $users[$i]["id"]; ?>"><?php echo $users[$i]["surname"] . ' ' . $users[$i]["name"]; ?></a></th>
                    <td><?php echo $users[$i]["birthdate"]; ?></td>
                    <?php
                        $spe = R::getCell('SELECT sname FROM specialities WHERE id = ?', [$users[$i]["priority1"]]);
                        $uni_id = R::getCell('SELECT university_id FROM specialities WHERE id = ?', [$users[$i]["priority1"]]);
                        $uni = R::getCell('SELECT uname FROM universities WHERE id = ?', [$uni_id]);
                    ?>
                    <td><?php echo $uni . ', ' . $spe ?></td>
                    <?php
                        $spe = R::getCell('SELECT sname FROM specialities WHERE id = ?', [$users[$i]["priority2"]]);
                        $uni_id = R::getCell('SELECT university_id FROM specialities WHERE id = ?', [$users[$i]["priority2"]]);
                        $uni = R::getCell('SELECT uname FROM universities WHERE id = ?', [$uni_id]);
                    ?>
                    <td><?php echo $uni . ', ' . $spe ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><img src="/public/images/default-photo.jpg" alt="" width="50" height="50"></td>
                    <th scope="row"><a href="/profile.php?id=<?php echo $users[$i]["id"]; ?>"><?php echo $users[$i]["surname"] . ' ' . $users[$i]["name"]; ?></a></th>
                    <td><?php echo $users[$i]["birthdate"]; ?></td>
                    <?php
                        $spe = R::getCell('SELECT sname FROM specialities WHERE id = ?', [$users[$i]["priority1"]]);
                        $uni_id = R::getCell('SELECT university_id FROM specialities WHERE id = ?', [$users[$i]["priority1"]]);
                        $uni = R::getCell('SELECT uname FROM universities WHERE id = ?', [$uni_id]);
                    ?>
                    <td><?php echo $uni . ', ' . $spe ?></td>
                    <?php
                        $spe = R::getCell('SELECT sname FROM specialities WHERE id = ?', [$users[$i]["priority2"]]);
                        $uni_id = R::getCell('SELECT university_id FROM specialities WHERE id = ?', [$users[$i]["priority2"]]);
                        $uni = R::getCell('SELECT uname FROM universities WHERE id = ?', [$uni_id]);
                    ?>
                    <td><?php echo $uni . ', ' . $spe ?></td>
                </tr>
            <?php endif; ?>
            <?php endfor; ?>

        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>