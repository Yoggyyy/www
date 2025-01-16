<?php
/**
 * Controlador para la página principal.
 * Gestiona la visualización del feed principal.
 */
class IndexController {
    /**
     * Muestra la página principal.
     */
    public function showIndex() {
        session_start();

        // Verificar si el usuario está logueado
        $isLoggedIn = isset($_SESSION['user']);
        $posts = [];

        if ($isLoggedIn) {
            // Obtener publicaciones desde el modelo
            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/PostModel.php');
            $posts = PostModel::getAll();
        }

        // Cargar la vista principal
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/common/index.php');
    }
}
?>