<?php
/**
 * Class Weapon
 *
 * Representa un arma con un nombre y un valor de ataque.
 */
class Weapon {
    /**
     * @var string Nombre del arma.
     * @var int Valor de ataque del arma.
     */
    private string $name;
    private int $attack;

    /**
     * Constructor de la clase Weapon.
     *
     * @param string $name Nombre del arma.
     * @param int $attack Valor de ataque del arma.
     */
    public function __construct(string $name, int $attack)
    {
        $this->name = $name;
        $this->attack = $attack;
    }

    /**
     * Método mágico para obtener el valor de una propiedad.
     *
     * @param string $property Nombre de la propiedad.
     * @return mixed Valor de la propiedad solicitada.
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * Método mágico para establecer el valor de una propiedad.
     *
     * @param string $property Nombre de la propiedad.
     * @param mixed $value Valor a establecer en la propiedad.
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }

    /**
     * Método mágico para convertir el objeto a una cadena.
     *
     * @return string Representación en cadena del objeto Weapon.
     */
    public function __toString() {
        return "Weapon: $this->name, Attack: $this->attack";
    }
}
?>
