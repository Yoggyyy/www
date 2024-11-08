<?php
/**
 * Class Armor
 *
 * Representa una armadura con un nombre y un valor de defensa.
 */
class Armor {
    /**
     * @var string Nombre de la armadura.
     * @var int Valor de defensa de la armadura.
     */
    private $name;
    private $defense;

    /**
     * Constructor de la clase Armor.
     *
     * @param string $name Nombre de la armadura.
     * @param int $defense Valor de defensa de la armadura.
     */
    public function __construct($name, $defense)
    {
        $this->name = $name;
        $this->defense = $defense;
    }

    /**
     * Método mágico para obtener el valor de una propiedad.
     *
     * @param string $property Nombre de la propiedad.
     * @return mixed Valor de la propiedad solicitada.
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Método mágico para establecer el valor de una propiedad.
     *
     * @param string $property Nombre de la propiedad.
     * @param mixed $value Valor a establecer en la propiedad.
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
     * Método mágico para convertir el objeto a una cadena.
     *
     * @return string Representación en cadena del objeto Armor.
     */
    public function __toString()
    {
        return "Armor: $this->name, Defense: $this->defense";
    }
}
?>
