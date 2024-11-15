<?php
// Configuración de conexión a la base de datos
$host = '';
$usuario = '';
$contrasena = '';
$basedatos = '';

try {
    $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $basedatos . ';charset=utf8', $usuario, $contrasena);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar con la base de datos: ' . $e->getMessage();
    die();
}

// Ordenar canciones según el campo y el orden especificados en la URL
$campo = isset($_GET['campo']) ? $_GET['campo'] : 'titulo';
$orden = isset($_GET['orden']) && in_array($_GET['orden'], ['asc', 'desc']) ? $_GET['orden'] : 'asc';

$sql = 'SELECT canciones.codigo, canciones.titulo, canciones.duracion, albumes.titulo AS album, grupos.nombre AS grupo
        FROM canciones
        LEFT JOIN albumes ON canciones.album = albumes.codigo
        LEFT JOIN grupos ON albumes.grupo = grupos.codigo
        ORDER BY ' . $campo . ' ' . $orden;
$stmt = $conexion->prepare($sql);

try {
    $stmt->execute();
    $canciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
	
	<h2>Canciones:</h2>

	<table>
        <thead>
            <tr>
                <th>Título
                    <a href='songs.php?campo=titulo&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=titulo&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Duración
                    <a href='songs.php?campo=duracion&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=duracion&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Álbum
                    <a href='songs.php?campo=album&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=album&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Grupo
                    <a href='songs.php?campo=grupo&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=grupo&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($canciones as $cancion) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($cancion['titulo']) . '</td>';
                echo '<td>' . htmlspecialchars(gmdate('i:s', $cancion['duracion'])) . '</td>';
                echo '<td>' . htmlspecialchars($cancion['album']) . '</td>';
                echo '<td>' . htmlspecialchars($cancion['grupo']) . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
	
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