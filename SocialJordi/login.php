<?php
// iniciamos y configuramos la sesion
ini_set('session.name', 'SesionJordi');
ini_set('session.cookie_lifetime', 300);
//se inicia o se recupera la anterior
session_start();

// Si el usuario ya está logueado se le redirigirá a index
if (isset($_SESSION['user'])) {
    header('Location: /index');
    exit;
}

// Query para algun momento SELECT COUNT(*) AS QUANTITY FROM users WHERE (user=:user OR email=:mail);
// con esta query no podemos saber si falla el user o pass


// Si llegan datos del formulario hay que intentar hacer el login
if (!empty($_POST)) {
    // Se eliminan los espacios delante y detrás de los campos recibidos
    foreach ($_POST as $key => $value)
        $_POST[$key] = trim($value);

    // Si el campo está vacío se añade un elemento al array $errors[]
    if (empty($_POST['user']))
        $errors['user'] = 'El usuario no puede estar en blanco.';
    if (empty($_POST['password']))
        $errors['password'] = 'La contraseña no puede estar en blanco.';

    if (!isset($errors)) {
        try {
            // Si no hay errores se procede a comprobar las credenciales
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/env.inc.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');
            if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
                // Se accede obtienen los datos del usuario desde la base de datos
                $query = $connection->prepare('SELECT user,  password 
                                               FROM users 
                                               WHERE (user=:user OR email=:mail);');
                $query->bindParam(':user', $_POST['user']);
                $query->bindParam(':mail', $_POST['user']);
                $query->execute();
                // ya que solo nos devuelve 1 objeto
                $user = $query->fetchObject();
                // Comprobaciones para el login y el user si es 0 user no existe si es 1 comprbamos password
                if ($query->rowCount() != 1) {
                    $errors['login'] = 'Error en el acceso';
                } else {
                    // Existe solo un usuario que coincide para realizar el login
                    // Se comprueba si la contraseña es correcta
                    //  Si es correcta se almacenan los datos del usuario en la sesión y se redirige a index
                    if (password_verify($_POST['password'], $user->password)) {
                        session_regenerate_id();
                        $_SESSION['user'] = $user->user;
                        $_SESSION['rol'] = $user->rol;
                        unset($query);
                        unset($connection);
                        header('Location: /index');
                        exit;

                        // Si es incorrecto se almacena el error para mostrarlo en el body
                    } else {
                        $errors['password'] = 'Error en la contraseña';
                    }
                }
            } else {
                throw new Exception('Error en la conexión a la BBDD');
            }
        } catch (Exception $e) {
            $errors['login'] = 'Error en el acceso';
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
    <title>SocialLink - Login</title>
    <link rel="stylesheet" href="/styles/global.css">
    <link rel="stylesheet" href="/styles/login.css">

</head>

<body>
    <div class="image">
        <div class="logo"></div>
        <div class="content">
            <span class="text">Hello Nakama!!</span>
            <span class="text">Your place to share, connect and discover. Log in and continue to be part of our community.</span>
            <a href="/register" class="button">Sign Up</a>
        </div>
    </div>
    <div class="form">
        <div class="title">
            <h1>Sign In</h1>

            <div class="social-media">
                <svg width="256" height="262" viewBox="0 0 256 262" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid">
                    <path d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027" fill="#4285F4" />
                    <path d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1" fill="#34A853" />
                    <path d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782" fill="#FBBC05" />
                    <path d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251" fill="#EB4335" />
                </svg>
                <svg
                    viewBox="0 0 256 250"
                    width="256"
                    height="250"
                    fill="#24292f"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="xMidYMid">
                    <path
                        d="M128.001 0C57.317 0 0 57.307 0 128.001c0 56.554 36.676 104.535 87.535 121.46 6.397 1.185 8.746-2.777 8.746-6.158 0-3.052-.12-13.135-.174-23.83-35.61 7.742-43.124-15.103-43.124-15.103-5.823-14.795-14.213-18.73-14.213-18.73-11.613-7.944.876-7.78.876-7.78 12.853.902 19.621 13.19 19.621 13.19 11.417 19.568 29.945 13.911 37.249 10.64 1.149-8.272 4.466-13.92 8.127-17.116-28.431-3.236-58.318-14.212-58.318-63.258 0-13.975 5-25.394 13.188-34.358-1.329-3.224-5.71-16.242 1.24-33.874 0 0 10.749-3.44 35.21 13.121 10.21-2.836 21.16-4.258 32.038-4.307 10.878.049 21.837 1.47 32.066 4.307 24.431-16.56 35.165-13.12 35.165-13.12 6.967 17.63 2.584 30.65 1.255 33.873 8.207 8.964 13.173 20.383 13.173 34.358 0 49.163-29.944 59.988-58.447 63.157 4.591 3.972 8.682 11.762 8.682 23.704 0 17.126-.148 30.91-.148 35.126 0 3.407 2.304 7.398 8.792 6.14C219.37 232.5 256 184.537 256 128.002 256 57.307 198.691 0 128.001 0Zm-80.06 182.34c-.282.636-1.283.827-2.194.39-.929-.417-1.45-1.284-1.15-1.922.276-.655 1.279-.838 2.205-.399.93.418 1.46 1.293 1.139 1.931Zm6.296 5.618c-.61.566-1.804.303-2.614-.591-.837-.892-.994-2.086-.375-2.66.63-.566 1.787-.301 2.626.591.838.903 1 2.088.363 2.66Zm4.32 7.188c-.785.545-2.067.034-2.86-1.104-.784-1.138-.784-2.503.017-3.05.795-.547 2.058-.055 2.861 1.075.782 1.157.782 2.522-.019 3.08Zm7.304 8.325c-.701.774-2.196.566-3.29-.49-1.119-1.032-1.43-2.496-.726-3.27.71-.776 2.213-.558 3.315.49 1.11 1.03 1.45 2.505.701 3.27Zm9.442 2.81c-.31 1.003-1.75 1.459-3.199 1.033-1.448-.439-2.395-1.613-2.103-2.626.301-1.01 1.747-1.484 3.207-1.028 1.446.436 2.396 1.602 2.095 2.622Zm10.744 1.193c.036 1.055-1.193 1.93-2.715 1.95-1.53.034-2.769-.82-2.786-1.86 0-1.065 1.202-1.932 2.733-1.958 1.522-.03 2.768.818 2.768 1.868Zm10.555-.405c.182 1.03-.875 2.088-2.387 2.37-1.485.271-2.861-.365-3.05-1.386-.184-1.056.893-2.114 2.376-2.387 1.514-.263 2.868.356 3.061 1.403Z" />
                </svg>
            </div>
        </div>
        <form action="#" method="post">
            <div class="inputs">
                <input class="input" type="text" placeholder="Email">
                <input class="input" type="text" placeholder="Password">
            </div>
            
            <div class="ctn-button">
                <a href="/index" class="button">Sign In</a>
            </div>
        </form>
    </div>
</body>

</html>