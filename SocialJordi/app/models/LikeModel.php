<?php
/**
 * Modelo para la gestión de "likes".
 */
class LikeModel {
    /**
     * Añade un "like" a una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @param int $userId ID del usuario que realiza el "like".
     */
    public static function addLike($entryId, $userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('INSERT INTO likes (entry_id, user_id) VALUES (?, ?)');
        $stmt->execute([$entryId, $userId]);
    }

    /**
     * Elimina un "like" de una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @param int $userId ID del usuario que realiza el "like".
     */
    public static function removeLike($entryId, $userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('DELETE FROM likes WHERE entry_id = ? AND user_id = ?');
        $stmt->execute([$entryId, $userId]);
    }

    /**
     * Cuenta el número de "likes" en una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @return int Número de "likes".
     */
    public static function countLikes($entryId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM likes WHERE entry_id = ?');
        $stmt->execute([$entryId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    /**
     * Comprueba si un usuario ha dado "like" a una publicación.
     *
     * @param int $entryId ID de la publicación.
     * @param int $userId ID del usuario.
     * @return bool Verdadero si el usuario ha dado "like".
     */
    public static function hasLiked($entryId, $userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM likes WHERE entry_id = ? AND user_id = ?');
        $stmt->execute([$entryId, $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] > 0;
    }
}
?>
