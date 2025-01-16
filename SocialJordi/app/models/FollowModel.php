<?php
/**
 * Modelo para la gestión de relaciones de seguimiento entre usuarios.
 */
class FollowModel {
    /**
     * Sigue a un usuario.
     *
     * @param int $userId ID del usuario que sigue.
     * @param int $userFollowed ID del usuario seguido.
     */
    public static function follow($userId, $userFollowed) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('INSERT INTO follows (user_id, user_followed) VALUES (?, ?)');
        $stmt->execute([$userId, $userFollowed]);
    }

    /**
     * Deja de seguir a un usuario.
     *
     * @param int $userId ID del usuario que sigue.
     * @param int $userFollowed ID del usuario seguido.
     */
    public static function unfollow($userId, $userFollowed) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('DELETE FROM follows WHERE user_id = ? AND user_followed = ?');
        $stmt->execute([$userId, $userFollowed]);
    }

    /**
     * Comprueba si un usuario sigue a otro.
     *
     * @param int $userId ID del usuario que sigue.
     * @param int $userFollowed ID del usuario seguido.
     * @return bool Verdadero si el usuario sigue al otro usuario.
     */
    public static function isFollowing($userId, $userFollowed) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT COUNT(*) AS total FROM follows WHERE user_id = ? AND user_followed = ?');
        $stmt->execute([$userId, $userFollowed]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'] > 0;
    }

    /**
     * Obtiene una lista de usuarios seguidos por un usuario.
     *
     * @param int $userId ID del usuario.
     * @return array Lista de usuarios seguidos.
     */
    public static function getFollowed($userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT user_followed FROM follows WHERE user_id = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene una lista de seguidores de un usuario.
     *
     * @param int $userId ID del usuario.
     * @return array Lista de seguidores.
     */
    public static function getFollowers($userId) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT user_id FROM follows WHERE user_followed = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
