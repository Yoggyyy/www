<h3>Comentarios</h3>

<?php if (!empty($comments)) { ?>
    <ul>
        <?php foreach ($comments as $comment) { ?>
            <li>
                <strong>Usuario <?= $comment['user_id'] ?>:</strong>
                <p><?= $comment['text'] ?></p>
                <span>Fecha: <?= $comment['date'] ?></span>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>No hay comentarios en esta publicación. Sé el primero en comentar.</p>
<?php } ?>

<form method="POST" action="/index.php?page=addComment&entryId=<?= $post['id'] ?>">
    <textarea name="text" placeholder="Escribe un comentario..." required></textarea>
    <button type="submit">Comentar</button>
</form>
