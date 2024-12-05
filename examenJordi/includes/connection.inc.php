<?php
/**
 * @author Jordi
 * @version 0.0.1
 * Script donde defino una funcion para conectarme a la BD
 */
function getDBConnection(): mixed {
    $dsn = 'mysql:dbname=examanime;host=localhost;host=127.0.0.1';
    $user = 'examen';
    $pass = 'nemaxe';
    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (Exception $ex) {
        return null;
    }
}