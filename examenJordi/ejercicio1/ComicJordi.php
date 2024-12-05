<?php

/**
 * @author Jordi
 * @version 0.0.1
 * Clase Comic que almacena las caracteristicas de los mismos y que se anyadan (tengo el teclado en ingles xd)
 * o eliminen personajes ademas de compobar si existen 
 */

class Comic {
 private $title;
 private $author;
 private $ended;
 private static $characters = [];
 private $personajes;


// Ended es si esta o no terminado en base a si es true o false en el to string debo enselar una cosa u otra
    public function __construct(string $title, string $author ='' , bool $ended= false,){
        $this->title = $title;
        $this->author = $author;
        $this->ended = $ended;
        self::$characters;

    }
    // Metodo set que permite modificar el valor de una variable si esta existe
    public function __set($propierty, $value)
    {
        if (isset($this->$propierty)) $this->$propierty = $value;
    }

    //Metodo get que muestra el contenido de la variable si esta existe
    public function __get($propierty)
    {
        if (isset($this->$propierty)) return $this->$propierty;
    }

    // Esta incompleto falta recorrrer y mostrar los personajes, Hay que pasar los datos de personajes a distintas variables y luego imprimirlas 
    public function __toString()
    {
        /** m falla algo vuelve luego 
        *foreach ($characters as $character) {
        *    $personajes .= $character;
        *}
         */
        if (!($this->ended)) {
            return 'El Comic '. $this->titulo . ' del autor ' . $this->author . ' no esta terminado y el elenco de sus personajes es ' ; //.$personajes;
        }else {
            return 'El Comic '. $this->titulo . ' del autor ' . $this->author . ' esta terminado y el elenco de sus personajes es '; //.$personajes;
        }
    }

    // Metodo que anyade personajes al array si no existen, true si se anyade false si no.
    public function addCharacter($value):bool {
        //miro que haya personajes
        if (isset($characters)) {
            // si los hay los recorro 
            foreach ($characters as $character) {
                //si no hay un personaje que coincida con el introducido se anyade
                if (!(in_array($value, $characters))) {
                    array_push($chartacters, $value);
                    return true;
                } else {
                    return false;
                }  
            }    
        }
        return false;
    }
    //Metodo que elimina personajes si estan registrados 
    public function removeCharacter($value):bool{
        //miro que haya personajes
        if (isset($characters)) {
            // si los hay los recorro 
            foreach ($characters as $character) {
                //si no hay un personaje que coincida con el introducido es que no existe
                if (!(in_array($value, $characters))) {
                    return false;
                } else {
                    //elimino el personaje 
                    array_pop($characters);
                    return true;
                }  
            }    
        }
        return false;
    }
    //Metodo que compruebe si existe o no un personaje.
    public function hasCharacter($value): bool{
        //miro que haya personajes
        if (isset($characters)) {
            // si los hay los recorro 
            foreach ($characters as $character) {
                //no existe en el comic
                if (!(in_array($value, $characters))) {
                    return false;
                } else {
                    //existe en el comic 
                    return true;
                }  
            }    
        }
        return false;
    }
}

?>