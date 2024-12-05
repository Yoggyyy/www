<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/databases.php');

$logged = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user']) && isset($_POST['password'])) {
        if ($_POST['user'] === $user['username'] && $_POST['password']  === $user['password']) {
            print('funciona');
        } else {
            print('no funciona');
        }
    }

    $logged = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<?php if (!$logged) { ?>

    <body>
        <form action="" method="post">
            <label for="user">user</label>
            <input type="text" name="user">
            <br>
            <label for="password">password</label>
            <input type="password" name="password">

            <button type="submit">Enviar</button>
        </form>
    </body>

<? } else {?>
<?php } ?>

</html>