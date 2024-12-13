<header>
    <h1><a href="/">MerchaShop</a></h1>

    <a href="/">Principal</a>

    <div id="zonausuario">
        <!-- Si el usuario no está logueado (no existe su variable de sesión): -->
        <?php
        if (!isset($_SESSION['user'])) {
        ?>
            <span>¿Ya tienes cuenta? <a href="/login">Loguéate aquí</a>.</span>
            <!-- Fin usuario no logueado -->

        <?php
        }
        ?>

        <!-- quitar estos br --><br><br>

        <?php
        if (isset($_SESSION['user'])) {
        ?>
            <!-- Si el usuario está logueado (existe su variable de sesión): -->
            <span id="usuario"><?= $_SESSION['user'] ?></span>

            <?php
            if ($_SESSION['rol'] === 'admin') {
            ?>
                <!-- Solo si el usuario es administrador -->
                <a href="/users">Ver usuarios</a>
                <br>
            <?php
            }
            ?>
            <span id="logout"><a href="/logout">Desconectar</a></span>
            <!-- Fin usuario logueado -->
        <?php
        }
        ?>
    </div>
</header>