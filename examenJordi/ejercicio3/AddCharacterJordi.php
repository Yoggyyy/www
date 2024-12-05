<?php
/**
 * @author Jordi
 * @version 0.0.1
 * Script donde se insertan personajes mediante un form
 * Se validan mediante ifs si estan vacios con empty
 * 
 */

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
</head>
<body>
    <h1>Añadir personaje</h1>
<?php
/**
 *mediante un if que cpomprueba una variable exito no definida xq no me da tiempo
 *muestra de nuevo el formulario en el caso de que te hayas euivocado 
 * if () {
 *   # code...
 *}
 */

?>
    <form action="#" method="POST">
            <input type="hidden" name="anime_id" value="<?= $anime_id ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required>
            <br>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="gnre" required>
            <br>
            <label for="episodes">Episodes:</label>
            <input type="number" id="episodes" name="episodes" required>
            <br>
            <label for="studio">Studio:</label>
            <input type="text" id="studio" name="studio" required>
            <br>
            <label for="year">Release year:</label>
            <input type="number" id="year" name="year" required>
            <br>
            <label for="rating">Rating:</label>
            <input type="number" id="rating" name="rating">
            <br>
            <button type="submit">Añadir personaje</button>
        </form>
</body>
</html>
