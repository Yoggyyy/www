<?php
/**
 * Página para Eliminar Cuenta.
 *
 * - Muestra un formulario de confirmación para eliminar la cuenta del usuario.
 * - Si el usuario confirma, elimina su cuenta, publicaciones y comentarios.
 * - Cierra la sesión y redirige a la página principal.
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
    header('Location: /front-end/login.php');
    exit;
}

// Incluir la conexión a la base de datos
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
$pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);

// Inicializar variables
$errors = [];

/**
 * Manejo de la confirmación de eliminación de cuenta.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $confirm = $_POST['confirm'] ?? null;

    if ($confirm === 'on') {
        try {
            $userId = $_SESSION['user_id'];

            // Eliminar datos relacionados
            $stmt = $pdo->prepare('DELETE FROM likes WHERE user_id = :userId');
            $stmt->execute([':userId' => $userId]);

            $stmt = $pdo->prepare('DELETE FROM dislikes WHERE user_id = :userId');
            $stmt->execute([':userId' => $userId]);

            $stmt = $pdo->prepare('DELETE FROM comments WHERE entry_id IN (SELECT id FROM entries WHERE user_id = :userId)');
            $stmt->execute([':userId' => $userId]);

            $stmt = $pdo->prepare('DELETE FROM comments WHERE user_id = :userId');
            $stmt->execute([':userId' => $userId]);

            $stmt = $pdo->prepare('DELETE FROM entries WHERE user_id = :userId');
            $stmt->execute([':userId' => $userId]);

            $stmt = $pdo->prepare('DELETE FROM follows WHERE user_id = :userId OR user_followed = :userId');
            $stmt->execute([':userId' => $userId]);

            $stmt = $pdo->prepare('DELETE FROM users WHERE id = :userId');
            $stmt->execute([':userId' => $userId]);

            session_unset();
            session_destroy();

            header('Location: /index.php');
            exit;
        } catch (Exception $e) {
            $errors['database'] = 'Error al eliminar la cuenta: ' . $e->getMessage();
        }
    } else {
        $errors['confirm'] = 'Debe marcar la casilla de confirmación para eliminar su cuenta.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Cuenta</title>
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
        <section class="cancel-section">
            <h1>Eliminar Cuenta</h1>
            <p>Esta acción eliminará permanentemente tu cuenta, tus publicaciones y tus comentarios. Esta acción no se puede deshacer.</p>

            <?php if (isset($errors['database'])) { ?>
                <p class="error"><?= $errors['database'] ?></p>
            <?php } ?>

            <form method="POST" action="/back-office/cancel.php">
                <div class="confirm">
                    <input type="checkbox" id="confirm" name="confirm">
                    <label for="confirm">Confirmo que deseo eliminar mi cuenta de forma permanente.</label>
                </div>
                <?php if (isset($errors['confirm'])) { ?>
                    <p class="error"><?= $errors['confirm'] ?></p>
                <?php } ?>
                <button type="submit">Eliminar Cuenta</button>
            </form>
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
