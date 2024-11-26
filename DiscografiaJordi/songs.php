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

    // orderar canciones según el campo y el orden especificados en la URL
    $campo = isset($_GET['field']) ? $_GET['field'] : 'title';
    $order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';
    if (empty($_GET['field'] ) && empty($_GET['order'])) {
        $query = 'SELECT s.id, s.title, s.length, a.title AS album, g.name AS group_name
            FROM songs s
            LEFT JOIN albums a ON album_id = a.id
            LEFT JOIN groups g ON group_id = g.id
            ORDER BY s.title ASC';
    } else {
        $query = 'SELECT s.id, s.title, s.length, a.title AS album, g.name AS group_name
            FROM songs s
            LEFT JOIN albums a ON album_id = a.id
            LEFT JOIN groups g ON group_id = g.id
            ORDER BY ' . $campo . ' ' . $order;
    }
    
    $preparada = $connection->prepare($query);
    $preparada->execute();
    $preparada = $preparada->fetchAll(PDO::FETCH_OBJ);
    $canciones = $preparada;


    unset($preparada);
    unset($connection);
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
    echo 'Error al conectar con la base de datos: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Discografía</title>
</head>

<body>
    <a href="index.php">Inicio</a>
    <a href="songs.php">Canciones</a>
    <header>
        Discografía
        Canciones
    </header>

    <h2>Canciones:</h2>

    <table>
        <thead>
            <tr>
                <th>Título
                    <a href='songs.php?campo=title&order=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=title&order=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Duración
                    <a href='songs.php?campo=length&order=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=length&order=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Álbum
                    <a href='songs.php?campo=album&order=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=album&order=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Grupo
                    <a href='songs.php?campo=group&order=asc'><img src='images/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?campo=group&order=desc'><img src='images/sort-desc.png' alt='Descendente'></a>
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
                echo '<td>' . $cancion->group_name. '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>

</html>