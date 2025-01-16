<h1>Registrarse</h1>

<?php if (isset($error)) { ?>
    <p style="color: red;"><?= $error ?></p>
<?php } ?>

<form method="POST" action="/index.php?page=signup">
    <label for="user">Usuario:</label>
    <input type="text" id="user" name="user" required>
    
    <label for="email">Correo Electrónico:</label>
    <input type="email" id="email" name="email" required>
    
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Registrarse</button>
</form>

<p>¿Ya tienes cuenta? <a href="/index.php?page=login">Inicia sesión</a>.</p>
