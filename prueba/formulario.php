<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Recursivo</title>
</head>
<body>
    <h1>Registrate</h1>
    <?php
    header('Location: /index.php');
    exit;
    if(!empty($_POST)){
        foreach ($_POST as $key => $value) {
            $_POST[$key] = trim($value);
        }
        print_r($_POST);
    }
    ?>

    <form action="#" method="post" >
        usuario <input type="text" name="user" value="<?=(isset($_POST['user']))?$_POST['user']:''?>"><br>
        mail <input type="text" name="mail" value="<?=(isset($_POST['mail']))?$_POST['mail']:''?>"><br>
             <input type="submit" value ="registrarse"><br>
    </form>
</body>
</html>