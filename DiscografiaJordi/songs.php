<?php

/**
 * 
 * @author Jordi
 * @version 0.0.1
 */


require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

// Configuración de conexión a la base de datos
$host = 'localhost';
$user = 'vetustamorla';
$password = '15151';
$database = 'discografia';

try {
    $connection = connectToDatabase($host, $database, $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ordenar canciones según el campo y el orden especificados en la URL
    $campo = isset($_GET['campo']) ? $_GET['campo'] : 'title';
    $orden = isset($_GET['orden']) && in_array($_GET['orden'], ['asc', 'desc']) ? $_GET['orden'] : 'asc';

    $query = 'SELECT s.id, s.title, s.length, a.title AS album, g.name AS group_name
        FROM songs s
        LEFT JOIN albums a ON album_id = a.id
        LEFT JOIN groups g ON group_id = g.id
        ORDER BY ' . $campo . ' ' . $orden;
    $preparada = $connection->prepare($query);

    $preparada->execute();
    $canciones = $preparada->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
    echo 'Error al conectar con la base de datos: ' . $e->getMessage();
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
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
                    <a href='songs.php?campo=title&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=title&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Duración
                    <a href='songs.php?campo=length&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=length&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Álbum
                    <a href='songs.php?campo=album&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=album&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Grupo
                    <a href='songs.php?campo=group&orden=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=group&orden=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($canciones as $cancion) {
                echo '<tr>';
                echo '<td>' . $cancion->title . '</td>';
                echo '<td>' . gmdate("i:s", $cancion->length). '</td>';
                echo '<td>' . $cancion->album . '</td>';
                echo '<td>' . $cancion->group. '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>

</html>