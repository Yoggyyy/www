<?php
/**
 * Vista para la página principal (index).
 * Muestra un mensaje de bienvenida para usuarios no autenticados
 * y un feed de publicaciones para usuarios autenticados.
 */

// Si no está definida la variable $isLoggedIn, asumir que el usuario no está autenticado
$isLoggedIn = $isLoggedIn ?? false;
$posts = $posts ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Network</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/app/includes/header.inc.php'); ?>
    
    <main>
        <?php if (!$isLoggedIn) { ?>
            <!-- Contenido para usuarios no autenticados -->
            <section class="welcome">
                <h1>Bienvenido a Social Network</h1>
                <p>Conéctate con tus amigos y comparte tus momentos favoritos.</p>
                <a href="/index.php?page=signup" class="btn">Regístrate ahora</a>
                <a href="/index.php?page=login" class="btn">Inicia sesión</a>
            </section>
        <?php } else { ?>
            <!-- Feed de publicaciones para usuarios autenticados -->
            <section class="feed">
                <h1>Tu Feed</h1>

                <?php if (!empty($posts)) { ?>
                    <ul class="post-list">
                        <?php foreach ($posts as $post) { ?>
                            <li class="post">
                                <div class="post-header">
                                    <span class="user">Usuario: <?= $post['user_id'] ?></span>
                                    <span class="date"><?= $post['date'] ?></span>
                                </div>
                                <p class="post-content"><?= $post['text'] ?></p>
                                <a href="/index.php?page=entry&id=<?= $post['id'] ?>" class="btn">Ver más</a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>No hay publicaciones en tu feed. ¡Sigue a más usuarios para ver contenido!</p>
                <?php } ?>
            </section>
        <?php } ?>
    </main>

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/app/includes/footer.inc.php'); ?>
</body>
</html>

