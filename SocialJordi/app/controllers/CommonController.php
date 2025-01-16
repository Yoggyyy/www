<?php
/**
 * Controlador para las páginas comunes de la aplicación.
 */
class CommonController {
    /**
     * Muestra la página del autor.
     */
    public function showAuthor() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/common/author.php');
    }

    /**
     * Muestra la página de términos de uso
     */
    public function showTerms() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/common/terms.php');
    }

    /**
     * Muestra una página de error 404 personalizada.
     */
    public function show404() {
        http_response_code(404);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/common/404.php');
    }

    /**
     * Muestra una página de error genérico 500.
     */
    public function show500() {
        http_response_code(500);
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/common/500.php');
    }
}
?>
