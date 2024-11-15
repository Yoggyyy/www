<?php
/**
 * Class Potion
 *
 * Representa una poción que otorga salud.
 */
class Potion {
    /**
     * @var int Valor de salud que otorga la poción.
     */
    private $health;

    /**
     * Constructor de la clase Potion.
     *
     * @param int $health Valor de salud de la poción.
     */
    public function __construct($health)
    {
        $this->health = $health;
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
}
?>

