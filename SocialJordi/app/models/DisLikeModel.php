<?php
/**
 * Modelo para la gestión de "dislikes".
 */
class DislikeModel {
    /**
     * Añade un "dislike" a una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @param int $userId ID del usuario que realiza el "dislike".
     */
    public static function addDislike($entryId, $userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('INSERT INTO dislikes (entry_id, user_id) VALUES (?, ?)');
        $stmt->execute([$entryId, $userId]);
    }

    /**
     * Elimina un "dislike" de una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @param int $userId ID del usuario que realiza el "dislike".
     */
    public static function removeDislike($entryId, $userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('DELETE FROM dislikes WHERE entry_id = ? AND user_id = ?');
        $stmt->execute([$entryId, $userId]);
    }

    /**
     * Cuenta el número de "dislikes" en una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @return int Número de "dislikes".
     */
    public static function countDislikes($entryId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM dislikes WHERE entry_id = ?');
        $stmt->execute([$entryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /**
     * Comprueba si un usuario ha dado "dislike" a una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @param int $userId ID del usuario.
     * @return bool Verdadero si el usuario ha dado "dislike".
     */
    public static function hasDisliked($entryId, $userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM dislikes WHERE entry_id = ? AND user_id = ?');
        $stmt->execute([$entryId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] > 0;
    }
}
?>
