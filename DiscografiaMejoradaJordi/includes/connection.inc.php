<?php
/**
 * Establece una conexión a la base de datos utilizando PDO.
 * @author Jordi
 * @version 0.0.1
 *
 * @param string $host Dirección del host de la base de datos.
 * @param string $database Nombre de la base de datos.
 * @param string $user Usuario de la base de datos.
 * @param string $password Contraseña del usuario.
 * @return PDO Conexión a la base de datos.
 * @throws Exception Si no se puede establecer la conexión.
 */

function connectToDatabase($host, $database, $user, $password) {
    try {
        $connection = new PDO('mysql:host=' . $host . ';dbname=' . $database . ';charset=utf8', $user, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (PDOException $e) {
        //throw new Exception('Error al conectar con la base de datos: ' . $e->getMessage());
        return null;
    }
}

?>