<?php
/**
 * Página para Guardar Comentarios.
 *
 * - Recibe los datos del formulario enviado desde `entry.php`.
 * - Valida los datos recibidos.
 * - Si los datos son válidos, guarda el comentario en la base de datos.
 * - Redirige a la página de la publicación (`entry.php`).
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
$entryId = $_POST['entry_id'] ?? null;
$text = $_POST['text'] ?? '';

/**
 * Manejo del formulario de comentarios.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = trim($text);

    // Validar datos
    if (empty($entryId) || !is_numeric($entryId)) {
        $errors['entry'] = 'ID de publicación inválido.';
    }
    if (empty($text)) {
        $errors['text'] = 'El comentario no puede estar vacío.';
    }

    // Si no hay errores, insertar el comentario en la base de datos
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO comments (entry_id, user_id, text, date) VALUES (?, ?, ?, NOW())');
            $stmt->execute([$entryId, $_SESSION['user_id'], $text]);

            // Redirigir a la página de la publicación
            header('Location: /front-end/entry.php?id=' . $entryId);
            exit;
        } catch (Exception $e) {
            $errors['database'] = 'No se pudo guardar el comentario. Por favor, inténtalo más tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialLink-Error en el Comentario</title>
    <link rel="icon" href="/assets/images/favicon.png" type="image/png">
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
        <section class="error-section">
            <h1>Error al Procesar el Comentario</h1>
            <?php if (!empty($errors)) { ?>
                <ul class="error-list">
                    <?php foreach ($errors as $error) { ?>
                        <li><?= $error ?></li>
                    <?php } ?>
                </ul>
                <a href="/front-end/entry.php?id=<?= $entryId ?>">Volver a la publicación</a>
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
