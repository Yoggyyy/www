<?php
// se que debe empezar por ruta absoluta pero si nos no funciona-.
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/usersList.inc.php');
$exito = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar datos
    foreach ($_POST as $key => $value) {
        
        $_POST[$key] = trim($value);
    }
    

    $user = userExists($_POST['user'], $users);
    if ($user != null) {
        if ($user->login($_POST['password'])) {
            $exito = true;
        } else {
            $errors['password'] = 'La contraseña no coincide';
        }
    } else {
        $errors['user'] = 'Usuario no registrado';
    }

    if (empty($errors)) {
        $exito = true; 
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Formulario</title>
</head>
<body>
<?php
    if ($exito) {
        // Si el formulario ha sido enviado correctamente, mostramos un mensaje de éxito
        echo '<span>Login Correcto.</span><br>';
        // Mostramos los datos del usuario con toString si está disponible
        echo '<span>' . $user->__toString() . '</span>';
        echo '<br>';
        echo '<a href="index.php">Volver al formulario</a>';
    } else {
        // Si no ha sido exitoso, mostramos el formulario con los campos ya introducidos y los errores
        /*
        <?php echo'...'; ?> es lo mismo que <?= ... ?>, mirar de hacer snipset d esto
        */
        // El operador `??` devuelve el primer valor no null o vacío en la secuencia que se le proporciona.
?>
    <form action="#" method="post">
        Usuario: <input type="text" name="user" value="<?= $_POST['user'] ?? '' ?>"><br>
        <div class="error"><?= $errors['user'] ?? '' ?></div><br>
        
        Contraseña: <input type="password" name="password" value="<?= $_POST['password'] ?? '' ?>">
        <div class="error"><?= $errors['password'] ?? '' ?></div><br>
        <input type="submit" value="Acceder">
    </form>
<?php
    }
?>
  
    <footer class="footer">
        <div class="Name">
            <span>Jordi Santos Torres</span>
            <img src="/images/fotoJordi.png" alt="Foto mia de ejemplo">
        </div>
        <div class="wrap-footer">
            <div class="rrss">
                <h5>Redes Sociales</h5>
                <ul>
                    <li><a href="https://www.facebook.com">
                            <img src="/images/face.png" alt="Facebook">
                        </a></li>
                    <li><a href="https://www.instagram.com">
                            <img src="/images/insta.png" alt="Instagram">
                        </a></li>
                    <li><a href="https://twitter.com">
                            <img src="/images/x.png" alt="X">
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="footer-creds">
            <div class="copy-creds">
                <p>©2022 · Todos los derechos reservados.</p>
            </div>
            <div class="legal-creds">
                <ul>
                    <li><a href="">Política de Privacidad</a></li>
                    <li><a href="">Política de Cookies</a></li>
                    <li><a href="">Aviso Legal</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>
</html>