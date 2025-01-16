<?php
/**
 * Controlador para la gestión de cuentas de usuario.
 */
class AccountController {
    /**
     * Muestra la página de la cuenta del usuario.
     */
    public function viewAccount() {
        // iniciamos y configuramos la sesion
        /* ini_set('session.name', 'SocialLinkSesion'); */
        ini_set('session.cookie_lifetime', 300);
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/user/account.php');
    }

    /**
     * Elimina la cuenta del usuario actual.
     */
    public function deleteAccount() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/UserModel.php');
        try {
            UserModel::delete($_SESSION['user']['id']);
            session_destroy();
            header('Location: /index.php?page=index');
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Error al eliminar la cuenta: ' . $e->getMessage();
        }
    }
}
?>