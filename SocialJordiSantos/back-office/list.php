<?php
/**
 * Página de Listado de Publicaciones del Usuario.
 *
 * - Muestra todas las publicaciones del usuario autenticado.
 * - Permite eliminar publicaciones específicas mediante un botón.
 * - Muestra mensajes de éxito o error según las operaciones realizadas.
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

// Obtener todas las publicaciones del usuario autenticado
try {
    $stmt = $pdo->prepare('
        SELECT id, text, date
        FROM entries
        WHERE user_id = ?
        ORDER BY date DESC
    ');
    $stmt->execute([$_SESSION['user_id']]);
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $errors['database'] = 'No se pudieron cargar las publicaciones.';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Publicaciones</title>
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
        <section class="list-section">
            <h1>Mis Publicaciones</h1>

            <!-- Mensajes de éxito y error -->
            <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted') { ?>
                <p class="success">¡La publicación se ha eliminado correctamente!</p>
            <?php } ?>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'delete_failed') { ?>
                <p class="error">Error al intentar eliminar la publicación. Inténtalo más tarde.</p>
            <?php } ?>

            <?php if (isset($errors['database'])) { ?>
                <p class="error"><?= $errors['database'] ?></p>
            <?php } ?>

            <?php if (!empty($entries)) { ?>
                <ul class="entry-list">
                    <?php foreach ($entries as $entry) { ?>
                        <li>
                            <p><strong>Fecha:</strong> <?= $entry['date'] ?></p>
                            <p><strong>Texto:</strong> <?= substr($entry['text'], 0, 50) ?>...</p>
                            <form method="GET" action="/front-end/delete.php">
                                <input type="hidden" name="id" value="<?= $entry['id'] ?>">
                                <button type="submit" class="delete-button">Eliminar</button>
                            </form>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>No tienes publicaciones en este momento.</p>
            <?php } ?>
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

