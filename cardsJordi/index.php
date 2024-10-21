<?php
/**
 * Archivo que contiene el index para poder dirigirse a la modalidad de juego escogida
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */
?>

<!DOCTYPE html>
<html lang="en">
<?php

$title = 'BlackAce';
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head.inc.php');
?>

<body>

    <h1>Inicio</h1>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
    ?>
    <div class="logo">
        <h3><b>BlackAce</b></h3>
        <img class="logo" src="/images/logoapp.png" alt="baraja">
    </div>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>