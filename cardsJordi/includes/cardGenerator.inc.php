<?php
/**
 * Archivo que contiene el generador del mazo 
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */

$suits = ['corazones', 'rombos', 'treboles', 'picas'];
$values = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
$deck = [];

// Generar las cartas normales
foreach ($suits as $suit) {
    for ($i = 0; $i < count($values); $i++) {
        $value = $values[$i];
        $deck[] = [
            'suit' => $suit,
            'value' => $value,
            'image' => substr($suit, 0, 3) . "_$value.png"
        ];
    }
}

shuffle($deck); 

?>


