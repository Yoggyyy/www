<?php
/**
 * Clase que representa a un héroe con propiedades básicas como nombre, especie, clase, salud, ataque y defensa.
 * También puede equipar armas, armaduras y usar pociones.
 * @author Jordi
 * @version 0.0.1
 */
class Hero {
 /**
  * @var string $name Nombre del héroe.
  * @var string $species Especie del héroe.
  * @var string $class Clase del héroe.
  * @var int $health Salud del héroe.
  * @var int $baseAttack Ataque base del héroe.
  * @var int $baseDefense Defensa base del héroe.
  * @var ?Weapon $weapon Arma equipada por el héroe (puede ser null).
  * @var ?Armor $armor Armadura equipada por el héroe (puede ser null).
  * @var array $potions Array de pociones que posee el héroe.
  */
    private $name;
    private $species;
    private $class;
    private $health;
    private $baseAttack;
    private $baseDefense;
    private ?Weapon $weapon = null;
    private ?Armor $armor = null;
    private $potions = [];

    /**
     * Constructor de la clase Hero.
     *
     * @param string $name Nombre del héroe.
     * @param string $species Especie del héroe.
     * @param string $class Clase del héroe.
     * @param int $health Salud inicial del héroe.
     * @param int $baseAttack Ataque base del héroe.
     * @param int $baseDefense Defensa base del héroe.
     */

    public function __construct($name, $species, $class, $health = 50, $baseAttack = 10, $baseDefense = 10) 
    {
        $this->name = $name;
        $this->species = $this->checkSpecies($species) ? $species : "humano";
        $this->class = $this->checkClass($class) ? $class : "ninguna";
        $this->health = $health;
        $this->baseAttack = $baseAttack;
        $this->baseDefense = $baseDefense;
    }

    /**
     * Método mágico __get para obtener propiedades de la clase.
     *
     * @param string $property Nombre de la propiedad a obtener.
     * @return mixed Valor de la propiedad solicitada.
     */

    public function __get($property) 
    {
        return $this->$property;
    }

    /**
     * Método mágico __set para establecer propiedades de la clase.
     *
     * @param string $property Nombre de la propiedad a establecer.
     * @param mixed $value Valor a asignar a la propiedad.
     */

    public function __set($property, $value) 
    {
        if ($property === "species") {
            $this->species = $this->checkSpecies($value) ? $value : "humano";
        } elseif ($property === "class") {
            $this->class = $this->checkClass($value) ? $value : "ninguna";
        } else {
            $this->$property = $value;
        }
    }

    /**
     * Verifica si la especie proporcionada es válida.
     *
     * @param string $species Especie a verificar.
     * @return bool Verdadero si la especie es válida, falso en caso contrario.
     */

    private function checkSpecies(string $species): bool 
    {
        $validSpecies = ["Altmer", "Argoniano", "Bosmer", "Bretón", "Dunmer", "Guardia rojo", "Imperial", "Khajiita", "Nórdico", "Orsimer"];
        // in_array busca la aguja en el pajar y devuelve true o false.
        return in_array($species, $validSpecies);
    }

    /**
     * Verifica si la clase proporcionada es válida.
     *
     * @param string $class Clase a verificar.
     * @return bool Verdadero si la clase es válida, falso en caso contrario.
     */

    private function checkClass(string $class): bool 
    {
        $validClasses = ["Agente", "Arquero", "Asesino", "Bárbaro", "Brujo", "Caballero", "Guerrero", "Ladrón", "Mago", "Monje"];
        return in_array($class, $validClasses);
    }

    /**
     * Calcula el daño de ataque del héroe considerando el arma equipada.
     *
     * @return int Daño de ataque total.
     */

    public function attack(): int 
    {
        return $this->baseAttack + ($this->weapon ? $this->weapon->attack : 0);
    }

    /**
     * Calcula la defensa del héroe después de recibir un ataque.
     *
     * @param int $damage Daño recibido.
     * @return int Defensa restante después de aplicar el daño.
     */

     public function defense(int $damage): int 
     {
         $totalDefense = $this->baseDefense + ($this->armor ? $this->armor->defense : 0);
         $realDamage = max($damage - $totalDefense, 0);
         $this->health -= $realDamage;
         return $realDamage;
     }
     

    /**
     * Usa la poción con mayor salud disponible en el inventario del héroe.
     *
     * @return string Mensaje indicando si se usó una poción o no.
     */
    public function usePotion()
    {
        if (!empty($this->potions)) {
            // ordeno el array pociones y utlizo una funcion anonima que compara $b->health con $a->health
            // si =, da 0, si es <, da 1 (y ordena de mayor a menor), si es >, da-1
            usort($this->potions, fn($a, $b) => $b->health <=> $a->health);
            // array_shift quita el primer valor del array y lo devuelve.
            $highestPotion = array_shift($this->potions);
            $this->health += $highestPotion->health;
            return "Poción usada: +{$highestPotion->health} salud";
        }

        return 'No tienes pociones';
    }

    /**
     * Representa el héroe como una cadena de texto.
     *
     * @return string Cadena con la información del héroe.
     */

    public function __toString() 
    {
        return "Hero: $this->name, Species: $this->species, Class: $this->class, Health: $this->health";
    }

    /**
     * Añade un arma al héroe si no tiene una equipada.
     *
     * @param Weapon $weapon Objeto Weapon a añadir.
     */
    public function addWeapon(Weapon $weapon): string
    {
        if ($this->weapon === null) {
            $this->weapon = $weapon;
            return  'Arma añadida: ' . $weapon;
        } else {
            return 'Ya tienes un arma equipada. Debes quitarla antes de añadir una nueva.';
        }
    }

    /**
     * Añade una armadura al héroe si no tiene una equipada.
     *
     * @param Armor $armor Objeto Armor a añadir.
     */

    public function addArmor(Armor $armor): string
    {
        if ($this->armor === null) {
            $this->armor = $armor;
            return 'Armadura añadida: ' . $armor;
            // retrun true
        } else {
            // return false
            return 'Ya tienes una armadura equipada. Debes quitarla antes de añadir una nueva.';
        }
    }

    /**
     * Añade una poción al inventario del héroe si tiene menos de 5.
     *
     * @param Potion $potion Objeto Potion a añadir.
     */
    public function addPotion(Potion $potion): string 
    {
        if (count($this->potions) < 2) {
            $this->potions[] = $potion;
            return 'Poción añadida: ' . $potion;
        } else {
            return 'Ya tienes el máximo de 2 pociones.';
        }
    }
}
?>
