<?php
/**
 * Clase User que representa a un usuario en el sistema.
 * @author Jordi
 * @version 0.0.1
 */
class User {
    private $username;
    private $password;
    private $mail;
    private $logged = false;

    /**
     * Constructor de la clase User.
     *
     * @param string $username Nombre de usuario
     * @param string $password Contraseña del usuario
     * @param string $mail Correo electrónico del usuario
     */
    public function __construct($username, $password, $mail) {
        $this->username = $username;
        $this->password = $password;
        $this->mail = $mail;
    }

    /**
     * Método mágico para establecer el valor de una propiedad.
     *
     * @param string $propierty Nombre de la propiedad
     * @param mixed $value Valor de la propiedad
     * @return void
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }

    /**
     * Método mágico para obtener el valor de una propiedad.
     *
     * @param string $property Nombre de la propiedad
     * @return mixed Valor de la propiedad o null si no existe o si no es accesible
     */
    public function __get($property) {
        return $this -> $property;
    }


    /**
     * Método para iniciar sesión.
     *
     * @param string $password Contraseña ingresada por el usuario
     * @return bool Devuelve true si la contraseña es correcta y el usuario no está logueado, false en caso contrario
     */
    public function login(string $password): bool {
        if ($this->logged) {
            return false;
        } elseif ($this->password === $password) {
            $this->logged = true;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Método para cerrar sesión.
     *
     * @return void
     */
    public function logout() {
        $this->logged = false;
    }

    /**
     * Método mágico para convertir el objeto en una cadena de texto.
     *
     * @return string Cadena con el nombre de usuario y el correo electrónico
     */
    public function __toString(): string {
        return "{$this->username} ({$this->mail})";
    }
}
?>


