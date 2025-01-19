<?php
/**
 * Página de Configuración de Cuenta.
 *
 * - Muestra un formulario con los datos actuales del usuario para modificarlos.
 * - Si recibe datos del formulario, actualiza los datos en la base de datos.
 * - Proporciona enlaces a `list.php` y `cancel.php`.
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

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Incluir la conexión a la base de datos
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
$pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);

// Inicializar variables
$errors = [];
$success = false;
$userData = [];

/**
 * Manejo de la edición de datos del usuario.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username'] ?? '');
    $newEmail = trim($_POST['email'] ?? '');
    $newPassword = trim($_POST['password'] ?? '');

    // Validar datos
    if (empty($newUsername)) {
        $errors['username'] = 'El nombre de usuario no puede estar vacío.';
    }
    if (empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El correo electrónico no es válido.';
    }
    if (!empty($newPassword) && strlen($newPassword) < 6) {
        $errors['password'] = 'La contraseña debe tener al menos 6 caracteres.';
    }

    // Si no hay errores, actualizar los datos en la base de datos
    if (empty($errors)) {
        try {
            $query = 'UPDATE users SET user = :username, email = :email';
            $params = [
                ':username' => $newUsername,
                ':email' => $newEmail,
                ':id' => $_SESSION['user_id']
            ];

            // Si se proporciona una nueva contraseña, se incluye en la actualización
            if (!empty($newPassword)) {
                $query .= ', password = :password';
                $params[':password'] = password_hash($newPassword, PASSWORD_BCRYPT);
            }
            $query .= ' WHERE id = :id';

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);

            $success = true;

            // Actualizar la información de la sesión
            $_SESSION['user'] = $newUsername;
        } catch (Exception $e) {
            $errors['database'] = 'Error al actualizar los datos. Intente más tarde.';
        }
    }
} else {
    // Obtener los datos actuales del usuario para rellenar el formulario
    try {
        $stmt = $pdo->prepare('SELECT user, email FROM users WHERE id = ?');
        $stmt->execute([$_SESSION['user_id']]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $errors['database'] = 'Error al cargar los datos del usuario.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Cuenta</title>
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
        <section class="account-section">
            <h1>Configuración de Cuenta</h1>

            <?php if ($success) { ?>
                <p class="success">¡Los datos se han actualizado correctamente!</p>
            <?php } ?>

            <?php if (isset($errors['database'])) { ?>
                <p class="error"><?= $errors['database'] ?></p>
            <?php } ?>

            <form method="POST" action="/back-office/account.php">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" value="<?= $userData['user'] ?? '' ?>" required>
                <?php if (isset($errors['username'])) { ?>
                    <p class="error"><?= $errors['username'] ?></p>
                <?php } ?>

                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" value="<?= $userData['email'] ?? '' ?>" required>
                <?php if (isset($errors['email'])) { ?>
                    <p class="error"><?= $errors['email'] ?></p>
                <?php } ?>

                <label for="password">Nueva Contraseña (opcional)</label>
                <input type="password" id="password" name="password">
                <?php if (isset($errors['password'])) { ?>
                    <p class="error"><?= $errors['password'] ?></p>
                <?php } ?>

                <button type="submit">Actualizar Datos</button>
            </form>

            <div class="links">
                <a href="/back-office/list.php">Mis Publicaciones</a>
                <a href="/back-office/cancel.php">Eliminar Cuenta</a>
            </div>
        </section>
    </main>

    <?php
    /**
     * Incluye el pie de página reutilizable.
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php'); 
    ?>
</body>

</html>
