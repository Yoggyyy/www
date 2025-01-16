<?php
// iniciamos y configuramos la sesion
ini_set('session.name', 'SocialLinkSesion');
ini_set('session.cookie_lifetime', 300);
//se inicia o se recupera la anterior
session_start();

// Se tiene que cerrar la sesión
session_unset();

// Una vez cerrada la sesión se redirige a index
header('Location: /index');
exit;