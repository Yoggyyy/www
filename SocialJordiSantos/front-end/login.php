<?php
/**
 * Página de Inicio de Sesión.
 *
 * - Muestra un formulario para autenticarse si no se han enviado datos.
 * - Valida los datos recibidos e intenta autenticar al usuario.
 * - Si la autenticación es exitosa, redirige a `index.php`.
 * - Si hay errores, los muestra junto con el formulario.
 *
 * PHP version 8.1
 *
 * @package  SocialLink
 * @author   Jordi Santos
 * @version  1.0
 */

// Configuración e inicio de sesión
ini_set('session.cookie_lifetime', 300);
session_start();

// Verificar si el usuario ya está autenticado
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

// Incluir la conexión a la base de datos
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
$pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);

// Inicializar variables
$errors = [];
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

/**
 * Manejo del formulario de inicio de sesión.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($username);
    $password = trim($password);

    // Validar datos
    if (empty($username)) {
        $errors['username'] = 'El nombre de usuario no puede estar vacío.';
    }
    if (empty($password)) {
        $errors['password'] = 'La contraseña no puede estar vacía.';
    }

    // Si no hay errores, intentar autenticar al usuario
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('SELECT id, user, password FROM users WHERE user = :username OR email = :username');
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Autenticación exitosa
                session_regenerate_id();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user['user'];

                // Redirigir al índice
                header('Location: /index.php');
                exit;
            } else {
                // Error de autenticación
                $errors['login'] = 'Usuario o contraseña incorrectos.';
            }
        } catch (Exception $e) {
            $errors['database'] = 'Error al procesar la solicitud. Intente más tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <?php
    /**
     * Incluye la cabecera reutilizable.
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php'); 
    ?>

    <main>
    <div class="main-content">
        <section class="login-section">
            <h1>Iniciar Sesión</h1>

            <?php if (isset($errors['login'])) { ?>
                <p class="error"><?= $errors['login'] ?></p>
            <?php } ?>
            <?php if (isset($errors['database'])) { ?>
                <p class="error"><?= $errors['database'] ?></p>
            <?php } ?>

            <form method="POST" action="/front-end/login.php">
                <label for="username">Usuario o Correo Electrónico</label>
                <input type="text" id="username" name="username" value="<?= $username ?>" required>
                <?php if (isset($errors['username'])) { ?>
                    <p class="error"><?= $errors['username'] ?></p>
                <?php } ?>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])) { ?>
                    <p class="error"><?= $errors['password'] ?></p>
                <?php } ?>

                <button type="submit">Iniciar Sesión</button>
            </form>

            <p>¿No tienes una cuenta? <a href="/index.php">Regístrate aquí</a>.</p>
        </section>
    </div>
    </main>

    <?php
    /**
     * Incluye el pie de página reutilizable.
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php'); 
    ?>
</body>

</html>
