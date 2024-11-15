<?php
/**
 * 
 * @author Jordi
 * @version 0.0.1
 */


 require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/connection.inc.php');

// Configuración de conexión a la base de datos
$host = 'localhost';
$user = 'vetustamorla';
$password = '15151';
$database = 'discografia';

$connection = connectToDatabase($host, $database, $user, $password);

// Verificar si se envió un término de búsqueda
$busqueda = isset($_POST['search']) ? $_POST['search'] : '';

if ($busqueda == '') {
    // Mostrar todos los grupos en orden alfabético ascendente
    $query = 'SELECT codigo, nombre FROM grupos ORDER BY nombre ASC';
    $stmt = $connection->prepare($query);
} else {
    // Mostrar grupos que contengan el término de búsqueda en el nombre
    $query = 'SELECT codigo, nombre FROM grupos WHERE nombre LIKE :busqueda ORDER BY nombre ASC';
    $stmt = $connection->prepare($query);
    $busqueda_param = '%' . $busqueda . '%';
    $stmt->bindParam(':busqueda', $busqueda_param, PDO::PARAM_STR);
}

try {
    $stmt->execute();
    $grupos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error en la consulta: ' . $e->getMessage();
}
?>




<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="/styles/style.css">
	<title>Discografía</title>
</head>

<body>
	<header>
        Discografía
        Canciones
    </header>

	<form action="#" method="POST">
		<label for="">Búsqueda</label>
		<input type="text" name="" id="">
		<input type="submit" value="Buscar">
	</form>
	
	<h2>Grupos:</h2>
	
	<?php
    if (count($grupos) > 0) {
        foreach ($grupos as $grupo) {
            echo '<div>';
            echo '<p>' . htmlspecialchars($grupo['name']) . '</p>';
            echo '<img src="/images/' . htmlspecialchars($grupo['codigo']) . '.jpg" alt="Foto de ' . htmlspecialchars($grupo['name']) . '">';
            echo '</div>';
        }
    } else {
        echo '<p>No se encontraron grupos con el término de búsqueda proporcionado.</p>';
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
    
</body>
    
</html>