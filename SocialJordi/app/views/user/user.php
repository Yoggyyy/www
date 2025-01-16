<h1>Perfil de <?= $user['user'] ?></h1>

<p><strong>Email:</strong> <?= $user['email'] ?></p>

<?php if ($isFollowing) { ?>
    <a href="/index.php?page=unfollowUser&id=<?= $user['id'] ?>">Dejar de seguir</a>
<?php } else { ?>
    <a href="/index.php?page=followUser&id=<?= $user['id'] ?>">Seguir</a>
<?php } ?>

<h2>Seguidores:</h2>
<ul>
    <?php foreach ($followers as $follower) { ?>
        <li>Usuario: <?= $follower['user_id'] ?></li>
    <?php } ?>
</ul>

<h2>Siguiendo:</h2>
<ul>
    <?php foreach ($followed as $follow) { ?>
        <li>Usuario: <?= $follow['user_followed'] ?></li>
    <?php } ?>
</ul>
