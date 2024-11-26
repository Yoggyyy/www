<?php

/**
 * @author Jordi
 * @version 0.0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
 
$group_id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : '';
$album_id = isset($_GET['album']) ? $_GET['album'] : 0;

// Validación y procesado del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $year = $_POST['year'] ?? '';
    $format = $_POST['format'] ?? '';
    $buydate = $_POST['buydate'] ?? '';
    $price = $_POST['price'] ?? '';
    $photo = $_POST['photo'] ?? '';
    $group_id_post = $_POST['group_id'] ?? '';

    $errors = [];

    // Validar datos
    if (empty($title)) $errors[] = 'El título es obligatorio.';
    if (empty($year) || !is_numeric($year)) $errors[] = 'El año es obligatorio y debe ser numérico.';
    if (empty($format)) $errors[] = 'El formato es obligatorio.';
    if (empty($buydate)) $errors[] = 'La fecha de compra es obligatoria.';
    if (empty($price) || !is_numeric($price)) $errors[] = 'El precio es obligatorio y debe ser numérico.';
    if ($group_id != $group_id_post) $errors[] = 'Error de seguridad: el ID del grupo no coincide.';

    if (empty($errors)) {
        try {

            $connection = connectToDatabase();
            $query = "INSERT INTO albums (title, group_id, year, format, buydate, price, photo) VALUES (:title, :group_id, :year, :format, :buydate, :price, :photo)";
            $preparada = $connection->prepare($query);
            $preparada->bindParam(':title', $title);
            $preparada->bindParam(':group_id', $group_id_post);  
            $preparada->bindParam(':year', $year);
            $preparada->bindParam(':format', $format);
            $preparada->bindParam(':buydate', $buydate);
            $preparada->bindParam(':price', $price);
            $preparada->bindParam(':photo', $photo);
            $preparada->execute();

            // Cerrar la consulta y la conexión
            unset($preparada);
            unset($connection);

            header("Location: groups.php?id=$group_id");
            exit;
        } catch (PDOException $e) {
            echo 'Error al insertar el álbum: ' . $e->getMessage();
        }
    }
}

if ($action == 'delete' && $album_id) {
    try {

        $connection = connectToDatabase();
        $query = "DELETE FROM albums WHERE id = :album_id";
        $preparada = $connection->prepare($query);
        $preparada->bindParam(':album_id', $album_id);
        $preparada->execute();

        $query = "DELETE FROM songs WHERE album_id = :album_id";
        $preparada = $connection->prepare($query);
        $preparada->bindParam(':album_id', $album_id);
        $preparada->execute();

        // Cerrar la consulta y la conexión
        unset($preparada);
        unset($connection);

        header("Location: groups.php?id=$group_id");
        exit;
    } catch (PDOException $e) {
        echo 'Error al eliminar el álbum: ' . $e->getMessage();
    }
}

try {

    $connection = connectToDatabase();
    $query = "SELECT id, title FROM albums WHERE group_id = :group_id";
    $preparada = $connection->prepare($query);
    $preparada->bindParam(':group_id', $group_id);
    $preparada->execute();
    $albums = $preparada->fetchAll(PDO::FETCH_OBJ);

    // Cerrar la consulta y la conexión
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
    
        <h2>Álbumes del grupo:</h2>
        <?php
        foreach ($albums as $album) {
            echo '<div>';
            echo '<p>' . $album->title;
           echo '<a href="groups.php?id=' . $group_id . '&album=' . $album->id . '&action=confirm">';
            echo '<img src="images/iconos/papelera.png" alt="Eliminar">';
            echo '</a></p>';
            echo '</div>';
        }

        if ($action == 'confirm' && $album_id) {
            echo '<p>¿Estás seguro de que deseas eliminar este álbum?</p>';
            echo '<a href="groups.php?id=' . $group_id . '">Cancelar</a>';
            echo '<a href="groups.php?id=' . $group_id . '&album=' . $album_id . '&action=delete">Confirmar</a>';
        }
        ?>

        <h2>Añadir nuevo álbum:</h2>
        <?php
        if (!empty($errors)) {
            echo '<div class="errors">';
            echo '<ul>';
            foreach ($errors as $error) {
                echo '<li>' . $error . '</li>';
            }
            echo '</ul>';
            echo '</div>';
        }
        ?>

        <form action="#" method="POST">
            <input type="hidden" name="group_id" value="<?= $group_id ?>">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
            <label for="year">Año:</label>
            <input type="number" id="year" name="year" required>
            <label for="format">Formato:</label>
            <select id="format" name="format" required>
                <option value="vinilo">Vinilo</option>
                <option value="cd">CD</option>
                <option value="dvd">DVD</option>
                <option value="mp3">MP3</option>
            </select>
            <label for="buydate">Fecha de compra:</label>
            <input type="date" id="buydate" name="buydate" required>
            <label for="price">Precio:</label>
            <input type="number" step="0.01" id="price" name="price" required>
            <label for="photo">Foto:</label>
            <input type="text" id="photo" name="photo">
            <button type="submit">Añadir Álbum</button>
        </form>
    

    <?php require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php'); ?>
</body>
</html>
