<?php
/**
 * Controlador para la gestión de publicaciones.
 */
class PostController {
    /**
     * Muestra el formulario para crear una nueva publicación.
     */
    public function createPost() {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = trim($_POST['text']);
            if (empty($text)) {
                $error = 'La publicación no puede estar vacía.';
                require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/post/new.php');
                return;
            }

            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/PostModel.php');
            PostModel::create($_SESSION['user']['id'], $text);

            header('Location: /index.php?page=index');
            exit;
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/post/new.php');
        }
    }

    /**
     * Muestra una publicación individual junto con sus comentarios y sus "likes"/"dislikes".
     *
     * @param int $id ID de la publicación.
     */
    public function viewPost($id) {
        session_start();

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/PostModel.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/CommentModel.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/LikeModel.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/DislikeModel.php');

        $post = PostModel::findById($id);
        $comments = CommentModel::findByEntryId($id);
        $likeCount = LikeModel::countLikes($id);
        $dislikeCount = DislikeModel::countDislikes($id);

        // Si el usuario está autenticado, verificar si ha dado "like" o "dislike"
        $userLike = $userDislike = false;
        if (isset($_SESSION['user'])) {
            $userLike = LikeModel::hasLiked($id, $_SESSION['user']['id']);
            $userDislike = DislikeModel::hasDisliked($id, $_SESSION['user']['id']);
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/post/entry.php');
    }

    /**
     * Agrega un "like" a una publicación.
     *
     * @param int $id ID de la publicación.
     */
    public function addLike($id) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/LikeModel.php');
        LikeModel::addLike($id, $_SESSION['user']['id']);
        header('Location: /index.php?page=entry&id=' . $id);
        exit;
    }

    /**
     * Agrega un "dislike" a una publicación.
     *
     * @param int $id ID de la publicación.
     */
    public function addDislike($id) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/DislikeModel.php');
        DislikeModel::addDislike($id, $_SESSION['user']['id']);
        header('Location: /index.php?page=entry&id=' . $id);
        exit;
    }

    /**
     * Lista todas las publicaciones.
     */
    public function listPosts() {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/PostModel.php');
        $posts = PostModel::getAll();
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/post/list.php');
    }
}
?>

