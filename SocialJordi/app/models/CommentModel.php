<?php
/**
 * Modelo para la gestión de comentarios.
 */


class CommentModel {
    /**
     * Crea un nuevo comentario.
     *
     * @param int $entryId ID de la publicación.
     * @param int $userId ID del usuario que realiza el comentario.
     * @param string $text Contenido del comentario.
     */
    public static function create($entryId, $userId, $text) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('INSERT INTO comments (entry_id, user_id, text, date) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$entryId, $userId, $text]);
    }

    /**
     * Elimina un comentario.
     *
     * @param int $commentId ID del comentario.
     */
    public static function delete($commentId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('DELETE FROM comments WHERE id = ?');
        $stmt->execute([$commentId]);
    }

    /**
     * Encuentra un comentario por su ID.
     *
     * @param int $commentId ID del comentario.
     * @return array|null Comentario encontrado o null si no existe.
     */
    public static function findById($commentId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE id = ?');
        $stmt->execute([$commentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Encuentra todos los comentarios de una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @return array Lista de comentarios.
     */
    public static function findByEntryId($entryId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT * FROM comments WHERE entry_id = ? ORDER BY date DESC');
        $stmt->execute([$entryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
