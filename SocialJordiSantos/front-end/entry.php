<?php
/**
 * Página de Detalle de Publicación.
 *
 * - Muestra una publicación específica basada en su ID.
 * - Permite a los usuarios realizar acciones como "me gusta" o "no me gusta".
 * - Lista los comentarios existentes y proporciona un formulario para agregar nuevos comentarios.
 *
 * PHP version 8.1
 *
 * @category Página_Web
 * @package  SocialLink
 * @author   Jordi
 * @license  MIT License
 * @version  1.0
 * @link     http://localhost/front-end/entry.php
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

// Obtener el ID de la publicación desde la URL
$entryId = $_GET['id'] ?? null;

// Inicializar variables
$errors = [];
$entry = null;
$comments = [];

// Verificar y realizar acciones de "me gusta" o "no me gusta"
if ($entryId && isset($_GET['action'])) {
    $action = $_GET['action'];
    try {
        if ($action === 'like') {
            $stmt = $pdo->prepare('INSERT IGNORE INTO likes (entry_id, user_id) VALUES (?, ?)');
            $stmt->execute([$entryId, $_SESSION['user_id']]);
        } elseif ($action === 'dislike') {
            $stmt = $pdo->prepare('INSERT IGNORE INTO dislikes (entry_id, user_id) VALUES (?, ?)');
            $stmt->execute([$entryId, $_SESSION['user_id']]);
        }
    } catch (Exception $e) {
        $errors['action'] = 'No se pudo realizar la acción. Inténtalo más tarde.';
    }
}

// Obtener los datos de la publicación
if ($entryId) {
    try {
        $stmt = $pdo->prepare('
            SELECT entries.text, entries.date, users.user,
                   (SELECT COUNT(*) FROM likes WHERE likes.entry_id = entries.id) AS likes,
                   (SELECT COUNT(*) FROM dislikes WHERE dislikes.entry_id = entries.id) AS dislikes
            FROM entries
            JOIN users ON entries.user_id = users.id
            WHERE entries.id = ?
        ');
        $stmt->execute([$entryId]);
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtener comentarios de la publicación
        $stmt = $pdo->prepare('
            SELECT comments.text, comments.date, users.user
            FROM comments
            JOIN users ON comments.user_id = users.id
            WHERE comments.entry_id = ?
            ORDER BY comments.date ASC
        ');
        $stmt->execute([$entryId]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $errors['database'] = 'No se pudieron cargar los datos de la publicación.';
    }
} else {
    $errors['entry'] = 'No se especificó ninguna publicación.';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicación</title>
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
        <section class="entry-section">
            <?php if ($entry) { ?>
                <h1>Publicación</h1>
                <p><strong>Autor:</strong> <?= $entry['user'] ?></p>
                <p><?= $entry['text'] ?></p>
                <p><strong>Fecha:</strong> <?= $entry['date'] ?></p>

                <div class="actions">
                    <a href="?id=<?= $entryId ?>&action=like">Me gusta (<?= $entry['likes'] ?>)</a>
                    <a href="?id=<?= $entryId ?>&action=dislike">No me gusta (<?= $entry['dislikes'] ?>)</a>
                </div>

                <h2>Comentarios</h2>
                <?php if (!empty($comments)) { ?>
                    <ul class="comments">
                        <?php foreach ($comments as $comment) { ?>
                            <li>
                                <p><strong><?= $comment['user'] ?>:</strong> <?= $comment['text'] ?></p>
                                <p><small><?= $comment['date'] ?></small></p>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>No hay comentarios en esta publicación. Sé el primero en comentar.</p>
                <?php } ?>

                <h3>Añadir un comentario</h3>
                <form method="POST" action="/front-end/comment.php">
                    <textarea name="text" placeholder="Escribe tu comentario aquí..." required></textarea>
                    <input type="hidden" name="entry_id" value="<?= $entryId ?>">
                    <button type="submit">Comentar</button>
                </form>
            <?php } else { ?>
                <p class="error"><?= $errors['entry'] ?? 'Error al cargar la publicación.' ?></p>
            <?php } ?>

            <?php if (isset($errors['action'])) { ?>
                <p class="error"><?= $errors['action'] ?></p>
            <?php } ?>

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
