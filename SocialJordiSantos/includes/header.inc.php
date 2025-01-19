<header>
    <div class="logo">
    <img src="/assets/images/favicon.png" alt="logo">
    <h1><a href="/">SocialLink</a></h1>
    </div>
    <nav>
        <a href="/">Principal</a>
        <?php if (isset($_SESSION['user'])) { ?>
            <a href="/back-office/account.php">Mi Cuenta</a>
            <a href="/front-end/new.php">Nueva Publicación</a>
            <a href="/front-end/close.php">Cerrar Sesión</a>
        <?php } ?>
        <a href="/front-end/autor.php">Acerca del Autor</a>
    </nav>

    <div id="zonausuario">
        <?php if (!isset($_SESSION['user'])) { ?>
            <span>¿Ya tienes cuenta? <a href="/front-end/login.php">Inicia Sesión</a>.</span>
        <?php } ?>
    </div>
</header>

