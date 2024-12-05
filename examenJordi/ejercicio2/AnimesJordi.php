<?php

/**
 * @author Jordi
 * @version 0.0.1
 * Script donde se muestra una tabla HTML con el contenido de la tabla animes de la BD
 */

 require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

 try {
    //  me conecto a la bd
     $connection = getDBConnection();
     $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     // Preparo la query con todos los campos de la tabla anime 
     $query = 'SELECT id, title, genre, episodes, studio, release_year, rating FROM animes ORDER BY title ASC;';

     $preparada = $connection->prepare($query);
     $preparada->execute();
     $preparada = $preparada->fetchAll(PDO::FETCH_OBJ);
     $animes = $preparada;
 
     unset($preparada);
     unset($connection);
 } catch (PDOException $e) {
     echo 'Error en la consulta: ' . $e->getMessage();
     echo 'Error al intentar conectarnos con la base de datos: ' . $e->getMessage();
 }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejer2</title>
</head>
<body>
    <h1>Animes</h1>
    

    <thead class="table">
        <tr>
            <td>Id</td>
            <td>Title</td>
            <td>Genre</td>
            <td>Episodes</td>
            <td>Studio</td>
            <td>Release Year</td>
            <td>Rating</td>            
        </tr>
    </thead>
    <br>

<?php

foreach ($animes as $anime) {
    echo '<tbody class="table">';
    echo '<tr>';
    echo '<td>' . $anime->id. '</td>';
    echo '<td>' . $anime->title . '</td>';
    echo '<td>' . $anime->genre . '</td>';
    echo '<td>' . $anime->episodes . '</td>';
    echo '<td>' . $anime->studio . '</td>';
    echo '<td>' . $anime->release_year . '</td>';
    echo '<td>' . $anime->rating . '</td>';
    echo '</tr>';
    echo '<br>';
    echo '</tbody>';
}
?>
    
</body>
</html>