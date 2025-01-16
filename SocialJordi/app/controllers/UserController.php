<?php
/**
 * Controlador para la gestión de usuarios.
 */
class UserController {
    /**
     * Sigue a un usuario.
     *
     * @param int $id ID del usuario que será seguido.
     */
    public function followUser($id) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/FollowModel.php');
        FollowModel::follow($_SESSION['user']['id'], $id);
        header('Location: /index.php?page=userProfile&id=' . $id);
        exit;
    }

    /**
     * Deja de seguir a un usuario.
     *
     * @param int $id ID del usuario que será dejado de seguir.
     */
    public function unfollowUser($id) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/FollowModel.php');
        FollowModel::unfollow($_SESSION['user']['id'], $id);
        header('Location: /index.php?page=userProfile&id=' . $id);
        exit;
    }

    /**
     * Muestra el perfil de un usuario junto con sus seguidores y seguidos.
     *
     * @param int $id ID del usuario.
     */
    public function viewProfile($id) {
        session_start();

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/UserModel.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/FollowModel.php');

        $user = UserModel::findById($id);
        $followers = FollowModel::getFollowers($id);
        $followed = FollowModel::getFollowed($id);

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/user/profile.php');
    }
}
?>
