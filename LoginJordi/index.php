<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/LoginJordi/usersList.inc.php");



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accede a la web</title>
</head>
<body>
    <form action="#" method="post">
        Usuario: <input type="text" name="user" value="<?=$_POST['user']??''?>">
        <br>
        Contraseña: <input type="text" name="password" value="<?=$_POST['password']??''?>">
        <br>
        <input type="submit" value="Acceder">
    </form>
</body>
</html>