<?php

/**
 * 
 * @author Jordi
 * @version 0.0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

$connection = connectToDatabase();

// Verificar si se envió un término de búsqueda
$busqueda = isset($_POST['search']) ? $_POST['search'] : '';

try {
    if (empty($_POST['search'])) {
        // Mostrar todos los grupos en orden alfabético ascendente
        $query = "SELECT id, name, photo FROM groups ORDER BY name ASC;";
        $preparada = $connection->prepare($query);
    } else {
        // Mostrar grupos que contengan el término de búsqueda en el nombre
        $query = "SELECT id, name, photo FROM groups WHERE name LIKE :busqueda ORDER BY name ASC;";
        $preparada = $connection->prepare($query);
        $busqueda_param = '%' . $busqueda . '%';
        $preparada->bindParam(':busqueda', $busqueda_param, PDO::PARAM_STR);
    }

    $preparada->execute();
    $preparada = $preparada->fetchAll(PDO::FETCH_OBJ);
    $grupos = $preparada;

    unset($preparada);
    unset($connection);
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
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

    <form action="#" method="POST">
        <label for="">Búsqueda</label>
        <input type="text" name="search" id="search">
        <input type="submit" value="Buscar">
    </form>

    <h2>Grupos:</h2>

    <?php
    foreach ($grupos as $grupo) {
        echo '<div>';
        echo '<a href= "/groups.php?id=' . strval($grupo->id) . '">' . $grupo->name . '</a>';
        echo '<img src="images/grupos/' . $grupo->photo . '" alt="photo_group">';
        echo '</div>';
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>

</body>

</html>