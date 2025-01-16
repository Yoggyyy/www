<?php
/**
 * Controlador para búsquedas en la red social.
 */
class SearchController {
    /**
     * Realiza una búsqueda de usuarios y muestra los resultados.
     *
     * @param string $query Término de búsqueda proporcionado por el usuario.
     */
    public function search($query) {
        session_start();

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/UserModel.php');
        $results = UserModel::search($query);

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/search/results.php');
    }
}
?>


