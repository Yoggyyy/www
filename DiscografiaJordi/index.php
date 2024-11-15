<?php
/**
 * 
 * @author Jordi
 * @version 0.0.1
 */

// Configuración de conexión a la base de datos
$host = '';
$user = '';
$password = '';
$database = '';

try {
    $connection = new PDO('mysql:host=' . $host . ';dbname=' . $database . ';charset=utf8', $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar con la base de datos: ' . $e->getMessage();
    die();
}

// Verificar si se envió un término de búsqueda
$busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

if ($busqueda == '') {
    // Mostrar todos los grupos en orden alfabético ascendente
    $sql = 'SELECT codigo, nombre FROM grupos ORDER BY nombre ASC';
    $stmt = $connection->prepare($sql);
} else {
    // Mostrar grupos que contengan el término de búsqueda en el nombre
    $sql = 'SELECT codigo, nombre FROM grupos WHERE nombre LIKE :busqueda ORDER BY nombre ASC';
    $stmt = $connection->prepare($sql);
    $busqueda_param = '%' . $busqueda . '%';
    $stmt->bindParam(':busqueda', $busqueda_param, PDO::PARAM_STR);
}

try {
    $stmt->execute();
    $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
    die();
}
?>




<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/styles/style.css">
	<title>Discografía</title>
</head>

<body>
	<header>
        Discografía
        Canciones
    </header>

	<form action="" method="">
		<label for="">Búsqueda</label>
		<input type="text" name="" id="">
		<input type="submit" value="Buscar">
	</form>
	
	<h2>Grupos:</h2>
	
	<?php
    if (count($grupos) > 0) {
        foreach ($grupos as $grupo) {
            echo '<div>';
            echo '<p>' . htmlspecialchars($grupo['nombre']) . '</p>';
            echo '<img src="/images/' . htmlspecialchars($grupo['codigo']) . '.jpg" alt="Foto de ' . htmlspecialchars($grupo['nombre']) . '">';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron grupos con el término de búsqueda proporcionado.</p>';
    }
    ?>
	
    <footer class="footer">
        <div class="Name">
            <span>Jordi Santos Torres</span>
            <img src="/images/fotoJordi.png" alt="Foto mia de ejemplo">
        </div>
        <div class="wrap-footer">
            <div class="rrss">
                <h5>Redes Sociales</h5>
                <ul>
                    <li><a href="https://www.facebook.com">
                            <img src="/images/face.png" alt="Facebook">
                        </a></li>
                    <li><a href="https://www.instagram.com">
                            <img src="/images/insta.png" alt="Instagram">
                        </a></li>
                    <li><a href="https://twitter.com">
                            <img src="/images/x.png" alt="X">
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="footer-creds">
            <div class="copy-creds">
                <p>©2024 · Todos los derechos reservados.</p>
            </div>
            <div class="legal-creds">
                <ul>
                    <li><a href="">Política de Privacidad</a></li>
                    <li><a href="">Política de Cookies</a></li>
                    <li><a href="">Aviso Legal</a></li>
                </ul>
            </div>
        </div>
    </footer>
</html>