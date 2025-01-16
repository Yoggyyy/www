<?php

// iniciamos y configuramos la sesion
ini_set('session.name', 'SesionJordi');
ini_set('session.cookie_lifetime', 300);
//se inicia o se recupera la anterior
session_start();

if(!empty($_POST)) {
    // Se eliminan los espacios delante y detrás de los campos recibidos
    foreach($_POST as $key => $value)
        $_POST[$key] = trim($value);

    // Si el campo está vacío se añade un elemento al array $errors[]
    if (empty($_POST['user']))
        $errors['user'] = 'El usuario no puede estar en blanco.';   
    if (empty($_POST['email']))
        $errors['email'] = 'El email no puede estar en blanco.';
    if (empty($_POST['password']))
        $errors['password'] = 'La contraseña no puede estar en blanco.';

    // Si no existe el array $errors[] es que todos los campos recibidos están bien
    if (!isset($errors)) {
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/env.inc.php');
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/connection.inc.php');
        try {
            if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
                $query = $connection->prepare('SELECT user, email  
                                            FROM users
                                            WHERE (user=:user OR email=:email);');
                $query->bindParam(':user', $_POST['user']);
                $query->bindParam(':email', $_POST['email']);
                $query->execute();

                /* echo '<pre>';
                print_r($query->debugDumpParams());
                echo '<pre>'; */
                // Se comprueba que no exista ya en la BBDD un usuario con el username o el mail recibido
                if ($query->rowCount() == 1) {
                    $errors['signup'] = 'Error usuario o email ya existentes';
                
                // Si no existen hay que guardar los datos del nuevo usuario encriptando la contraseña
                //  y posteriormente se redirige a la página para que el usuario haga login
                }else {
                    // incompleto, debo hacer un insert 
                    $encryptedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $query = $connection->prepare('INSERT INTO users (user, email, password, rol ) VALUES (:user,:email, "'. $encryptedPassword .'", "customer");'); 
                    
                    $query->bindParam(':user',$_POST['user'] );
                    $query->bindParam(':email', $_POST['email']);
                    $query->execute();
                    header ('location: /login/signup/1');
                    exit;
                }
                // Si sí que existen se guarda un error para luego mostrarlo en el body

            } else {
                throw new Exception('Error en la conexión a la BBDD');
            }
        } catch (Exception $exception) {
            $dbError = true;
            echo $exception;
        } 
        unset($query);
        unset($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SocialLink - Error en el registro</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/header.inc.php');
    ?>
    <div>
        <h2>Existen errores en el formulario:</h2>
        <?php    
            if(isset($errors))   {

            foreach ($errors as $value) {
                echo $value .'<br>';
            }
        }
        ?>
    </div>
<br>
    <a href="/index">Vuelve a intentar el registro</a>
    
</body>
</html>