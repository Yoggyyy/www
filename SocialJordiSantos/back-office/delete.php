<?php
/**
 * Página para Eliminar una Publicación.
 *
 * - Elimina una publicación específica basada en el ID recibido.
 * - Elimina todos los comentarios, "me gusta" y "no me gusta" asociados.
 * - Redirige al usuario a la página `list.php`.
 *
 * PHP version 8.1
 *
 * @category Página_Web
 * @package  SocialLink
 */

// Configuración e inicio de sesión
ini_set('session.cookie_lifetime', 300);
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Verificar si se proporciona un ID de publicación válido
$entryId = $_GET['id'] ?? null;
if (!$entryId || !is_numeric($entryId)) {
    header('Location: /front-end/list.php');
    exit;
}

// Incluir la conexión a la base de datos
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
$pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);

try {
    // Iniciar una transacción para asegurar la eliminación completa
    $pdo->beginTransaction();

    // Eliminar los "me gusta" asociados a la publicación
    $stmt = $pdo->prepare('DELETE FROM likes WHERE entry_id = :entryId');
    $stmt->execute([':entryId' => $entryId]);

    // Eliminar los "no me gusta" asociados a la publicación
    $stmt = $pdo->prepare('DELETE FROM dislikes WHERE entry_id = :entryId');
    $stmt->execute([':entryId' => $entryId]);

    // Eliminar los comentarios asociados a la publicación
    $stmt = $pdo->prepare('DELETE FROM comments WHERE entry_id = :entryId');
    $stmt->execute([':entryId' => $entryId]);

    // Eliminar la publicación del usuario autenticado
    $stmt = $pdo->prepare('DELETE FROM entries WHERE id = :entryId AND user_id = :userId');
    $stmt->execute([':entryId' => $entryId, ':userId' => $_SESSION['user_id']]);

    // Confirmar la transacción
    $pdo->commit();
} catch (Exception $e) {
    // Revertir la transacción si ocurre un error
    $pdo->rollBack();
    // Redirigir con un mensaje de error en caso de fallo (opcional, depende del sistema)
    header('Location: /front-end/list.php?error=delete_failed');
    exit;
}

// Redirigir al usuario a la página `list.php` después de la eliminación
header('Location: /front-end/list.php?success=deleted');
exit;
