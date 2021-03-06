<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?>></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/bootstrap/bootstrap.min.css">
    <!--<script src="../public/bootstrap/bootstrap.min.js"></script>-->
    <!--<script src="../public/js/jquery.js"></script>-->
    <!--<script src="../public/js/popper.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!--<script src="../public/bootstrap/bootstrap.bundle.min.js"></script>-->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>-->
</head>
<body>
<div id="wrapper">
    <div id="content">
        <header class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a href="../" class="navbar-brand">Studienbrücklers</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <?php if ( isset($_SESSION['user']) ) : ?>
                    <ul class="navbar-nav">
                        <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" id="themes">Themes <span class="caret"></span></a>
                            <div class="dropdown-menu" aria-labelledby="themes">
                                <a class="dropdown-item" href="../default/">Default</a>
                            </div>
                        </li>-->
                        <li class="nav-item">
                            <a class="nav-link" href="/participants.php">Участники</a>
                        </li>
                    </ul>
                    <?php endif; ?>
                    <ul class="navbar-nav ms-md-auto">
                        <?php if ( !isset($_SESSION['user']) ) : ?>
                        <li class="nav-item">
                            <a rel="noopener" class="nav-link" href="/vendor/login.php">Войти</a>
                        </li>
                        <li class="nav-item">
                            <a rel="noopener" class="nav-link" href="/vendor/signup.php">Зарегистрироваться</a>
                        </li>
                        <?php else: ?>
                        <li class="nav-item">
                            <a rel="noopener" class="nav-link" href="/profile.php?id=<?php echo $_SESSION['user']->id; ?>">Профиль</a>
                        </li>
                        <li class="nav-item">
                            <a rel="noopener" class="nav-link" href="/vendor/logout.php">Выйти</a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </header>
