<h2><?= $post['text'] ?></h2>
<p>Publicado por el usuario <?= $post['user_id'] ?> el <?= $post['date'] ?></p>

<div>
    <span>👍 <?= $likeCount ?> Likes</span>
    <a href="/index.php?page=addLike&id=<?= $post['id'] ?>">Dar Like</a>
</div>

<div>
    <span>👎 <?= $dislikeCount ?> Dislikes</span>
    <a href="/index.php?page=addDislike&id=<?= $post['id'] ?>">Dar Dislike</a>
</div>

<h3>Comentarios:</h3>
<?php require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/comment/list.php'); ?>
