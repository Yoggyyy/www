<?php
/**
 * Controlador para la gestión de comentarios.
 */
class CommentController {
    /**
     * Agrega un nuevo comentario a una publicación.
     *
     * @param int $entryId ID de la publicación a la que se agrega el comentario.
     */
    public function addComment($entryId) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $text = trim($_POST['text']);
            if (empty($text)) {
                $error = 'El comentario no puede estar vacío.';
                require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/post/entry.php');
                return;
            }

            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/CommentModel.php');
            CommentModel::create($entryId, $_SESSION['user']['id'], $text);

            header('Location: /index.php?page=entry&id=' . $entryId);
            exit;
        }
    }

    /**
     * Elimina un comentario.
     *
     * @param int $commentId ID del comentario a eliminar.
     */
    public function deleteComment($commentId) {
        session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: /index.php?page=login');
            exit;
        }

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/CommentModel.php');
        $comment = CommentModel::findById($commentId);

        if ($comment && $comment['user_id'] === $_SESSION['user']['id']) {
            CommentModel::delete($commentId);
            header('Location: /index.php?page=entry&id=' . $comment['entry_id']);
            exit;
        } else {
            http_response_code(403);
            echo 'No tienes permiso para eliminar este comentario.';
        }
    }

    /**
     * Lista todos los comentarios de una publicación.
     *
     * @param int $entryId ID de la publicación.
     */
    public function listComments($entryId) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/CommentModel.php');
        $comments = CommentModel::findByEntryId($entryId);

        require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/comment/list.php');
    }
}
?>

