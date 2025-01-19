<?php
/**
 * Página para Crear Nuevas Publicaciones.
 *
 * - Si no recibe datos, muestra un formulario para crear una publicación.
 * - Si hay errores, vuelve a mostrar el formulario con los datos introducidos y un mensaje de error.
 * - Si los datos son válidos, guarda la publicación en la base de datos y redirige a la página de dicha publicación.
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
$text = $_POST['text'] ?? '';

/**
 * Manejo del formulario de creación de publicaciones.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = trim($text);

    // Validar datos
    if (empty($text)) {
        $errors['text'] = 'El texto de la publicación no puede estar vacío.';
    }

    // Si no hay errores, insertar la publicación en la base de datos
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO entries (user_id, text, date) VALUES (?, ?, NOW())');
            $stmt->execute([$_SESSION['user_id'], $text]);

            // Obtener el ID de la publicación recién creada
            $entryId = $pdo->lastInsertId();

            // Redirigir a la página de la publicación
            header('Location: /front-end/entry.php?id=' . $entryId);
            exit;
        } catch (Exception $e) {
            $errors['database'] = 'Error al guardar la publicación. Por favor, inténtalo más tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Publicación</title>
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
        <section class="new-post-section">
            <h1>Crear Nueva Publicación</h1>
            <form method="POST" action="/front-end/new.php">
                <label for="text">Texto de la publicación:</label>
                <textarea name="text" id="text" placeholder="Escribe aquí tu publicación..." required><?= $text ?></textarea>
                <?php if (isset($errors['text'])) { ?>
                    <p class="error"><?= $errors['text'] ?></p>
                <?php } ?>
                <br>
                <button type="submit">Publicar</button>
            </form>

            <?php if (isset($errors['database'])) { ?>
                <p class="error"><?= $errors['database'] ?></p>
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
