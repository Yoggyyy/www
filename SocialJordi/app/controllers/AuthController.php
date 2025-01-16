<?php

/**
 * Controlador para la autenticación de usuarios.
 */
class AuthController
{
    /**
     * Muestra el formulario de inicio de sesión y procesa los datos enviados.
     */
    public function login()
    {
        // iniciamos y configuramos la sesion
        /* ini_set('session.name', 'SocialLinkSesion'); */
        ini_set('session.cookie_lifetime', 300);
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['user'];
            $password = $_POST['password'];

            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/UserModel.php');
            $user = UserModel::findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: /index.php?page=index');
                exit;
            } else {
                $error = 'Credenciales incorrectas.';
                require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/auth/login.php');
            }
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/auth/login.php');
        }
    }

    /**
     * Muestra el formulario de registro y procesa los datos enviados.
     */
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['user'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/models/UserModel.php');
            try {
                UserModel::create($username, $email, $password);
                header('Location: /index.php?page=login');
                exit;
            } catch (Exception $e) {
                $error = 'No se pudo registrar el usuario.';
                require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/auth/signup.php');
            }
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/app/views/auth/signup.php');
        }
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
        // iniciamos y configuramos la sesion
        /* ini_set('session.name', 'SocialLinkSesion'); */
        ini_set('session.cookie_lifetime', 300);
        session_start();
        session_destroy();
        header('Location: /index.php?page=login');
        exit;
    }
}
