<?php
/**
 * Cierra la sesión del usuario logueado.
 *
 * - Destruye la sesión del usuario.
 * - Redirige al usuario a la página principal (`index.php`).
 *
 * PHP version 8.1
 *
 * @package  SocialLink
 * @author   Jordi Santos
 * @version  1.0
 */

// Configuración e inicio de sesión
ini_set('session.cookie_lifetime', 300);
session_start();

/**
 * Destruir la sesión.
 *
 * - Elimina todas las variables de sesión.
 * - Destruye la sesión actual.
 * - Redirige al índice.
 */
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión actual
header('Location: /index.php'); // Redirige a la página principal
exit;
