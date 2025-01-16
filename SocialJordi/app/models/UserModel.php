<?php
/**
 * Modelo para la gestión de usuarios.
 */
class UserModel {
    /**
     * Encuentra un usuario por su ID.
     *
     * @param int $id ID del usuario.
     * @return array|null Usuario encontrado o null si no existe.
     */
    public static function findById($id) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Encuentra un usuario por su nombre de usuario.
     *
     * @param string $username Nombre de usuario.
     * @return array|null Usuario encontrado o null si no existe.
     */
    public static function findByUsername($username) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('SELECT * FROM users WHERE user = ?');
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo usuario.
     *
     * @param string $username Nombre de usuario.
     * @param string $email Correo electrónico.
     * @param string $password Contraseña encriptada.
     */
    public static function create($username, $email, $password) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);
        $stmt = $pdo->prepare('INSERT INTO users (user, email, password) VALUES (?, ?, ?)');
        $stmt->execute([$username, $email, $password]);
    }

    /**
     * Elimina un usuario por su ID.
     * También elimina todas las dependencias relacionadas con el usuario (publicaciones, comentarios, likes, follows, etc.).
     *
     * @param int $id ID del usuario a eliminar.
     */
    public static function delete($id) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);

        // Iniciar una transacción para asegurar la integridad de los datos
        $pdo->beginTransaction();

        try {
            // Eliminar comentarios del usuario
            $stmt = $pdo->prepare('DELETE FROM comments WHERE user_id = ?');
            $stmt->execute([$id]);

            // Eliminar likes y dislikes del usuario
            $stmt = $pdo->prepare('DELETE FROM likes WHERE user_id = ?');
            $stmt->execute([$id]);

            $stmt = $pdo->prepare('DELETE FROM dislikes WHERE user_id = ?');
            $stmt->execute([$id]);

            // Eliminar relaciones de seguimiento
            $stmt = $pdo->prepare('DELETE FROM follows WHERE user_id = ? OR user_followed = ?');
            $stmt->execute([$id, $id]);

            // Eliminar publicaciones del usuario
            $stmt = $pdo->prepare('DELETE FROM entries WHERE user_id = ?');
            $stmt->execute([$id]);

            // Finalmente, eliminar al usuario
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);

            // Confirmar transacción
            $pdo->commit();
        } catch (Exception $e) {
            // Revertir cambios en caso de error
            $pdo->rollBack();
            throw $e;
        }
    }

    /**
     * Busca usuarios según un término proporcionado.
     *
     * @param string $query Término de búsqueda.
     * @return array Lista de usuarios que coinciden con el término de búsqueda.
     */
    public static function search($query) {
        $pdo = connectDb(DB_NAME, DB_USERNAME, DB_PASSWORD);

        // Usar comodines para buscar coincidencias parciales
        $searchTerm = '%' . $query . '%';

        $stmt = $pdo->prepare('SELECT * FROM users WHERE user LIKE ? OR email LIKE ?');
        $stmt->execute([$searchTerm, $searchTerm]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

