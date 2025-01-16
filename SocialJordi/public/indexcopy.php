<?php
// iniciamos y configuramos la sesion
ini_set('session.name', 'SesionJordi');
ini_set('session.cookie_lifetime', 300);
//se inicia o se recupera la anterior
session_start();

	require_once($_SERVER['DOCUMENT_ROOT'] .'/app/includes/env.inc.php');
	require_once($_SERVER['DOCUMENT_ROOT'] .'/app/includes/connection.inc.php');
	
	/* try {
		if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
            //Momento en el que recogemos de la BD lo necesario para mostrar publicaciones etc.
			$query = ';';
			$products = $connection->query($query)->fetchAll(PDO::FETCH_OBJ);
		} else {
			throw new Exception('Error en la conexión a la BBDD');
		}
		unset($query);
		unset($connection);
	} catch (Exception $exception) {
		$dbError = true;
		unset($query);
		unset($connection);
	} */
 
?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>SocialLink</title>
		<link rel="stylesheet" href="/css/global.css">
		<link rel="stylesheet" href="/css/login.css">
	</head>

	<body>
		<?php
			require_once($_SERVER['DOCUMENT_ROOT'] .'/app/includes/header.inc.php');
			if (!isset($_SESSION['user'])) {
		?>

<!-- Si el usuario no está logueado (no existe su variable de sesión): -->
		<h2>Regístrate para poder acceder a SocialLink</h2>

		<form action="signup" method="post">
			<label for="user">Usuario</label>
			<input type="text" name="user" id="user">
			<br>
			<label for="email">Email</label>
			<input type="email" name="email" id="email">
			<br>
			<label for="password">Contraseña</label>
			<input type="password" name="password" id="password">
			<br>
			<label></label>
			<input type="submit" value="Registrarse">
		</form>

		<span>¿Ya tienes cuenta? <a href="/login.php">Loguéate aquí</a>.</span>
		
		<?php
			}else {
		?>

<!-- Fin usuario no logueado -->

<!--   Si el usuario está logueado (existe su variable de sesión): -->
		<div id="">
		     Lorem ipsum dolor sit amet consectetur adipisicing elit. Corporis veritatis, officia minima nihil minus, dolorum culpa eaque voluptate totam delectus odio ad consequuntur obcaecati consequatur recusandae. Ad, corporis placeat. Odit?
			<a href="/" class="boton">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium officiis aliquid reprehenderit consequatur veniam, ipsum animi temporibus rerum voluptate sapiente voluptas asperiores nesciunt consectetur ullam nihil necessitatibus placeat dolorem dolore.</a>
		</div>

		<section class="">
			<?php
				}
			?>
		</section>
<!-- Fin usuario logueado -->

	</body>
</html>