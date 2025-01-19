<?php
/**
 * Página de Resultados de Búsqueda de Usuarios.
 *
 * - Recibe los datos del formulario de búsqueda de usuarios.
 * - Muestra una lista de usuarios que coincidan con la búsqueda.
 * - Cada usuario es un enlace que redirige a `user.php` con su ID.
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
$searchQuery = $_POST['search'] ?? '';
$users = [];
$errors = [];

/**
 * Manejo del formulario de búsqueda.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchQuery = trim($searchQuery);

    // Validar datos
    if (empty($searchQuery)) {
        $errors['search'] = 'El campo de búsqueda no puede estar vacío.';
    } else {
        try {
            // Buscar usuarios que coincidan con el término de búsqueda
            $stmt = $pdo->prepare('
                SELECT id, user, email
                FROM users
                WHERE user LIKE :search OR email LIKE :search
                ORDER BY user ASC
            ');
            $searchPattern = '%' . $searchQuery . '%';
            $stmt->bindParam(':search', $searchPattern);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $errors['database'] = 'Error al buscar usuarios. Inténtalo más tarde.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
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
        <section class="results-section">
            <h1>Resultados de Búsqueda</h1>

            <form method="POST" action="/front-end/results.php">
                <label for="search">Buscar Usuarios</label>
                <input type="text" id="search" name="search" value="<?= $searchQuery ?>" placeholder="Introduce un nombre o correo electrónico" required>
                <button type="submit">Buscar</button>
            </form>

            <?php if (isset($errors['search'])) { ?>
                <p class="error"><?= $errors['search'] ?></p>
            <?php } ?>
            <?php if (isset($errors['database'])) { ?>
                <p class="error"><?= $errors['database'] ?></p>
            <?php } ?>

            <?php if (!empty($users)) { ?>
                <h2>Usuarios Encontrados</h2>
                <ul class="user-list">
                    <?php foreach ($users as $user) { ?>
                        <li>
                            <a href="/front-end/user.php?id=<?= $user['id'] ?>">
                                <?= $user['user'] ?> (<?= $user['email'] ?>)
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($users)) { ?>
                <p>No se encontraron usuarios que coincidan con la búsqueda.</p>
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
