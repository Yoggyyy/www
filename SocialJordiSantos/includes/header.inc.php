<header>
    <h1><a href="/">SocialLink</a></h1>

    <a href="/">Principal</a>

    <div id="zonausuario">
        <!-- Si el usuario no está logueado (no existe su variable de sesión): -->
        <?php
        if (!isset($_SESSION['user'])) {
        ?>
            <span>¿Ya tienes cuenta? <a href="/login">Loguéate aquí</a>.</span>
            <!-- Fin usuario no logueado -->

        
        <!-- Si el usuario está logueado (existe su variable de sesión): -->
        <?php
        }
        if (isset($_SESSION['user'])) {
        ?>
           
            <span id="usuario"><?= $_SESSION['user'] ?></span>

            <span id="logout"><a href="/logout">Desconectar</a></span>
            <!-- Fin usuario logueado -->
        <?php
        }
        ?>
    </div>
</header>
