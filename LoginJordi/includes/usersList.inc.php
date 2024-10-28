<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/User.inc.php");

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

// mixed -> Te devuelve una variedad de tipos mayor
// ?User -> Te devuelve null o tipo asignado
function userExists(string $username, array $users): ?User
{
    foreach ($users as $user) {
        if ($user->username == $username) {
            return $user;
        }
    }

    return null;
}
