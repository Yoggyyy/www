<?php

/**
 * 
 * @author Jordi
 * @version 0.0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

try {
    $connection = connectToDatabase();
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // orderar canciones según el campo y el orden especificados en la URL=
    $field = isset($_GET['field']) ? $_GET['field'] : 'title';
    $order = isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc']) ? $_GET['order'] : 'asc';

    if (empty($_GET['field']) && empty($_GET['order'])) {
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
            ORDER BY ' . $field . ' ' . $order . ';';
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

    <header>
        <nav>
            <a href="index.php">Discografía</a>
            <a href="songs.php">Canciones</a>
        </nav>
    </header>

    <h2>Canciones:</h2>

    <table>
        <thead>
            <tr>
                <th>Título
                    <a href='songs.php?field=title&order=asc'><img src='images/iconos/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?field=title&order=desc'><img src='images/iconos/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Duración
                    <a href='songs.php?field=length&order=asc'><img src='images/iconos/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?field=length&order=desc'><img src='images/iconos/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Álbum
                    <a href='songs.php?field=album&order=asc'><img src='images/iconos/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?field=album&order=desc'><img src='images/iconos/sort-desc.png' alt='Descendente'></a>
                </th>
                <th>Grupo
                    <a href='songs.php?field=group_name&order=asc'><img src='images/iconos/sort-asc.png' alt='Ascendente'></a>
                    <a href='songs.php?field=group_name&order=desc'><img src='images/iconos/sort-desc.png' alt='Descendente'></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($canciones as $cancion) {
                echo '<tr>';
                echo '<td>' . $cancion->title . '</td>';
                echo '<td>' . gmdate("i:s", $cancion->length) . '</td>';
                echo '<td>' . $cancion->album . '</td>';
                echo '<td>' . $cancion->group_name . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>

</html>