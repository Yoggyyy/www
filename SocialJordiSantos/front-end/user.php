<?php
/**
 * Página de Perfil de Usuario.
 *
 * - Muestra los datos del usuario basado en el ID recibido.
 * - Muestra una lista de publicaciones del usuario.
 * - Permite seguir o dejar de seguir al usuario visitado y actualiza el número de seguidores en tiempo real.
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

// Obtener el ID del usuario desde la URL
$userId = $_GET['id'] ?? null;

// Inicializar variables
$errors = [];
$userData = null;
$userPosts = [];
$isFollowing = false;

// Manejo de las acciones de seguir y dejar de seguir al usuario
if ($userId && is_numeric($userId)) {
    try {
        // Verificar si el usuario autenticado ya sigue al usuario visitado
        $stmt = $pdo->prepare('SELECT * FROM follows WHERE user_id = :currentUserId AND user_followed = :userId');
        $stmt->execute([
            ':currentUserId' => $_SESSION['user_id'],
            ':userId' => $userId
        ]);
        $isFollowing = $stmt->rowCount() > 0;

        // Manejar acción de seguir
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
            if ($_POST['action'] === 'follow' && !$isFollowing) {
                $stmt = $pdo->prepare('INSERT INTO follows (user_id, user_followed) VALUES (:currentUserId, :userId)');
                $stmt->execute([
                    ':currentUserId' => $_SESSION['user_id'],
                    ':userId' => $userId
                ]);
                $isFollowing = true; // Actualizar estado
            }

            // Manejar acción de dejar de seguir
            if ($_POST['action'] === 'unfollow' && $isFollowing) {
                $stmt = $pdo->prepare('DELETE FROM follows WHERE user_id = :currentUserId AND user_followed = :userId');
                $stmt->execute([
                    ':currentUserId' => $_SESSION['user_id'],
                    ':userId' => $userId
                ]);
                $isFollowing = false; // Actualizar estado
            }
        }

        // Datos del usuario y cantidad de seguidores
        $stmt = $pdo->prepare('
            SELECT user, email,
                   (SELECT COUNT(*) FROM follows WHERE user_followed = users.id) AS followers
            FROM users
            WHERE id = ?
        ');
        $stmt->execute([$userId]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        // Publicaciones del usuario
        $stmt = $pdo->prepare('
            SELECT entries.id, SUBSTRING(entries.text, 1, 50) AS text, 
                   (SELECT COUNT(*) FROM likes WHERE likes.entry_id = entries.id) AS likes,
                   (SELECT COUNT(*) FROM dislikes WHERE dislikes.entry_id = entries.id) AS dislikes
            FROM entries
            WHERE user_id = ?
            ORDER BY date DESC
        ');
        $stmt->execute([$userId]);
        $userPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $errors['database'] = 'No se pudieron cargar los datos del usuario.';
    }
} else {
    $errors['user'] = 'ID de usuario inválido o no especificado.';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
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
        <section class="user-section">
            <?php if ($userData) { ?>
                <h1>Perfil de <?= $userData['user'] ?></h1>
                <p><strong>Email:</strong> <?= $userData['email'] ?></p>
                <p><strong>Seguidores:</strong> <?= $userData['followers'] ?></p>

                <form method="POST" action="/front-end/user.php?id=<?= $userId ?>">
                    <?php if (!$isFollowing) { ?>
                        <input type="hidden" name="action" value="follow">
                        <button type="submit">Seguir</button>
                    <?php } else { ?>
                        <input type="hidden" name="action" value="unfollow">
                        <button type="submit">Dejar de Seguir</button>
                    <?php } ?>
                </form>

                <h2>Publicaciones</h2>
                <?php if (!empty($userPosts)) { ?>
                    <ul class="user-posts">
                        <?php foreach ($userPosts as $post) { ?>
                            <li>
                                <p>
                                    <a href="/front-end/entry.php?id=<?= $post['id'] ?>">
                                        <?= $post['text'] ?>...
                                    </a>
                                </p>
                                <div class="post-stats">
                                    <span>Me gusta: <?= $post['likes'] ?></span>
                                    <span>No me gusta: <?= $post['dislikes'] ?></span>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Este usuario aún no ha publicado nada.</p>
                <?php } ?>
            <?php } else { ?>
                <p class="error"><?= $errors['user'] ?? 'Error al cargar el perfil.' ?></p>
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



