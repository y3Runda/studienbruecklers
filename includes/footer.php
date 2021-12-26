</div>
<footer class="container d-flex flex-wrap justify-content-between align-items-center py-3 border-top">
    <p class="col-md-4 mb-0 text-muted">© 2021 Created by Andrii Snurnikov</p>
    <ul class="nav col-md-4 justify-content-end">
        <?php if ( !isset($_SESSION['user']) ) : ?>
        <li class="nav-item"><a href="/vendor/login.php" class="nav-link px-2 text-muted">Войти</a></li>
        <li class="nav-item"><a href="/vendor/signup.php" class="nav-link px-2 text-muted">Зарегистрироваться</a></li>
        <?php else: ?>
            <li class="nav-item"><a href="/participants.php" class="nav-link px-2 text-muted">Участники</a></li>
        <?php endif; ?>
    </ul>
</footer>
</div>
</body>
</html>