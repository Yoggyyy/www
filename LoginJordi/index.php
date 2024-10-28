<?php
/**
 * Archivo principal para el procesamiento de inicio de sesión.
 * Verifica el envío del formulario, valida el usuario y contraseña,
 * y muestra un mensaje de éxito o errores según el resultado.
 * @author Jordi
 * @version 0.0.1
 */

// Ruta absoluta para incluir el archivo de lista de usuarios
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/usersList.inc.php');

$exito = false; // Indicador de éxito del login

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /**
     * Procesa el formulario enviado por método POST
     * y limpia los datos de entrada.
     */
    
    // Limpia cada campo de $_POST eliminando espacios en blanco
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
    }

    // Busca si el usuario existe en la lista de usuarios
    $user = userExists($_POST['user'], $users);
    if ($user != null) {
        // Verifica la contraseña del usuario
        if ($user->login($_POST['password'])) {
            $exito = true;
        } else {
            $errors['password'] = 'La contraseña no coincide';
        }
    } else {
        $errors['user'] = 'Usuario no registrado';
    }

    // Verifica si no hay errores y marca éxito en el inicio de sesión
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
        /**
         * Muestra un mensaje de éxito y detalles del usuario
         * si el login ha sido exitoso.
         */
        echo '<span>Login Correcto.</span><br>';
        echo '<span>' . $user->__toString() . '</span><br>';
        echo '<a class="return" href="index.php">Volver al formulario</a>';
    } else {
        /**
         * Muestra el formulario de inicio de sesión con los datos
         * previamente ingresados y mensajes de error si existen.
         */
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
    <br>
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
