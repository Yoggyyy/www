<?php
/**
 * Este archivo inicializa una lista de usuarios y define la función userExists
 * para verificar si un nombre de usuario existe en dicha lista.
 * @author Jordi
 * @version 0.0.1
 */

require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/User.inc.php");

/**
 * @var User[] $users Lista de usuarios registrados en el sistema, cada uno con
 * nombre de usuario, contraseña y correo electrónico.
 */
$users = [
    new User("HomerSimpson", "donuts", "homer@springfield.com"),
    new User("PeterGriffin", "freakinSweet", "peter@quahog.com"),
    new User("RickSanchez", "wubbalubbadubdub", "rick@multiverse.com"),
    new User("StanSmith", "CIAAgent", "stan@langley.com"),
    new User("BenderRodriguez", "bending", "bender@futurama.com"),
    new User("DariaMorgendorffer", "sarcastic", "daria@lawndale.com"),
    new User("Fry", "futurama123", "fry@futurama.com"),
    new User("LisaSimpson", "smartgirl", "lisa@springfield.com"),
    new User("MegGriffin", "loser", "meg@quahog.com"),
    new User("Cartman", "respectmyauthority", "cartman@southpark.com"),
];

/**
 * Verifica si un usuario existe en la lista de usuarios.
 *
 * @param string $username Nombre de usuario que se busca en la lista.
 * @param User[] $users Array de objetos User donde se buscará el nombre de usuario.
 *
 * @return ?User Retorna el objeto User si se encuentra un usuario con el nombre
 * dado, o null si el usuario no está en la lista.
 */
function userExists(string $username, array $users): ?User
{
    foreach ($users as $user) {
        if ($user->username == $username) {
            return $user;
        }
    }

    return null;
}

