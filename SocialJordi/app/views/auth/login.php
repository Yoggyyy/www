<h1>Iniciar Sesión</h1>

<?php if (isset($error)) { ?>
    <p style="color: red;"><?= $error ?></p>
<?php } ?>

<form method="POST" action="/index.php?page=login">
    <label for="user">Usuario:</label>
    <input type="text" id="user" name="user" required>
    
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Iniciar sesión</button>
</form>

<p>¿No tienes cuenta? <a href="/index.php?page=signup">Regístrate aquí</a>.</p>
