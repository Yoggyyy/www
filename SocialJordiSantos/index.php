<?php
/**
 * Página Principal de la Red Social.
 *
 * Esta página sirve como punto de entrada para usuarios autenticados y no autenticados.
 * - Los usuarios no autenticados pueden registrarse.
 * - Los usuarios autenticados pueden ver las publicaciones de los usuarios que siguen.
 *
 * PHP version 8.1
 *
 * @package  SocialLink
 * @author   Jordi Santos
 * @version  1.0
 */

// Iniciar y configurar la sesión
ini_set('session.cookie_lifetime', 300);
session_start();

// Incluir la conexión a la base de datos
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
$pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);

/**
 * Registro de usuarios si no están logueados.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_SESSION['user'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($username && $password && $email) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare('INSERT INTO users (user, password, email) VALUES (?, ?, ?)');
        if ($stmt->execute([$username, $hashedPassword, $email])) {
            echo '<p>Registro exitoso. Ahora puedes iniciar sesión.</p>';
        } else {
            echo '<p>Error: No se pudo registrar. Verifica los datos.</p>';
        }
    } else {
        echo '<p>Por favor, completa todos los campos.</p>';
    }
}

/**
 * Consulta de publicaciones si el usuario está logueado.
 */
$publications = [];
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare('
        SELECT entries.id, entries.text, entries.date, users.user,
               (SELECT COUNT(*) FROM likes WHERE likes.entry_id = entries.id) AS likes,
               (SELECT COUNT(*) FROM dislikes WHERE dislikes.entry_id = entries.id) AS dislikes,
               (SELECT COUNT(*) FROM comments WHERE comments.entry_id = entries.id) AS comments
        FROM entries
        JOIN follows ON follows.user_followed = entries.user_id
        JOIN users ON users.id = entries.user_id
        WHERE follows.user_id = ?
        ORDER BY entries.date DESC
    ');
    $stmt->execute([$userId]);
    $publications = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialLink</title>
    <link rel="icon" href="/assets/images/favicon.png" type="image/png">
    <link rel="stylesheet" href="/assets/css/style.css"> <!-- Cambia al estilo que uses -->
</head>

<body>
    <?php
    /**
     * Incluye la cabecera reutilizable.
     * Proporciona navegación y enlaces comunes para todas las páginas.
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php'); 
    ?>

    <main>
        <?php if (!isset($_SESSION['user_id'])) { ?>
            <section class="welcome">
                <p>Bienvenido Nakama únete a SocialLink para compartir con todos!.</p>
                <h2>Regístrate ahora</h2>
                <form method="POST" action="/index.php">
                    <input type="text" name="username" placeholder="Nombre de usuario" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <button type="submit">Registrarse</button>
                </form>
            </section>
        <?php } else { ?>
            <section class="dashboard">
                <h1>Tu Tablón</h1>
                <?php if (!empty($publications)) { ?>
                    <ul class="publications">
                        <p><a href="/front-end/results.php">Sigue a más personas!</a></p>
                        <?php foreach ($publications as $post) { ?>
                            <li class="publication">
                                <p><a href="/front-end/entry.php?id=<?= $post['id'] ?>"><?= $post['text'] ?></a></p>
                                <p><strong>Autor:</strong> <a href="/front-end/user.php?id=<?= $post['id'] ?>"><?= $post['user'] ?></a></p>
                                <div class="actions">
                                    <img src="/assets/images/like.png" alt="Me gusta"> <?= $post['likes'] ?>
                                    <img src="/assets/images/dislike.png" alt="No me gusta"> <?= $post['dislikes'] ?>
                                    <span>Comentarios: <?= $post['comments'] ?></span>
                                </div>
                                <span class="date"><?= $post['date'] ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>Aún no hay publicaciones para mostrar. ¡<a href="/front-end/results.php">Sigue</a> a más usuarios para llenar tu tablón!</p>
                <?php } ?>
            </section>
        <?php } ?>
    </main>

    <?php
    /**
     * Incluye el pie de página reutilizable.
     * Proporciona información legal y enlaces secundarios.
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php'); 
    ?>
</body>

</html>
