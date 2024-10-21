<?php
/**
 * Archivo que contiene las funciones a ejecutar para realizar las ops correspondientes .
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */
function addition(float $number1, float $number2): float {
    return $number1 + $number2;
}

function substraction(float $number1, float $number2): float {
    return $number1 - $number2;
}

function mult(float $number1, float $number2): float {
    return $number1 * $number2;
}

function div(float $number1, float $number2): float {
    return $number1 / $number2;
}

function compare(int $number1, int $number2) {
    if ($number1 === $number2) {
        return true;
    } else {
        return false;
    }
}

function module(int $number1, int $number2): int  {
    return $number1 % $number2;
}

function par(int $number): bool {
    return $number % 2 == 0;
}