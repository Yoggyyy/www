<h1>Mi Cuenta</h1>

<p><strong>Usuario:</strong> <?= $_SESSION['user']['user'] ?></p>
<p><strong>Email:</strong> <?= $_SESSION['user']['email'] ?></p>

<a href="/index.php?page=cancel" class="btn">Eliminar mi cuenta</a>
<a href="/index.php?page=index" class="btn">Volver al inicio</a>
