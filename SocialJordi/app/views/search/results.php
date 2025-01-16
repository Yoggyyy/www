<h1>Resultados de Búsqueda</h1>

<?php if (!empty($results)) { ?>
    <ul>
        <?php foreach ($results as $user) { ?>
            <li>
                <p><strong>Usuario:</strong> <?= $user['user'] ?></p>
                <p><strong>Email:</strong> <?= $user['email'] ?></p>
                <a href="/index.php?page=userProfile&id=<?= $user['id'] ?>">Ver perfil</a>
            </li>
        <?php } ?>
    </ul>
<?php } else { ?>
    <p>No se encontraron resultados para tu búsqueda.</p>
<?php } ?>

<a href="/index.php?page=index">Volver al inicio</a>
