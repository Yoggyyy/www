<?php
/**
 * Modelo para la gestión de publicaciones.
 */
class PostModel {
    /**
     * Crea una nueva publicación.
     *
     * @param int $userId ID del usuario.
     * @param string $text Contenido de la publicación.
     */
    public static function create($userId, $text) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('INSERT INTO entries (user_id, text, date) VALUES (?, ?, NOW())');
        $stmt->execute([$userId, $text]);
    }

    /**
     * Encuentra una publicación por su ID.
     *
     * @param int $id ID de la publicación.
     * @return array|null Publicación encontrada o null si no existe.
     */
    public static function findById($id) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT * FROM entries WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las publicaciones.
     *
     * @return array Lista de publicaciones.
     */
    public static function getAll() {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->query('SELECT * FROM entries ORDER BY date DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
