<?php

/**
 * @author Jordi
 * @version 0.0.1
 */

	// Comprobación de parámetros en la URL
	if (isset($_GET['accion'])) {
		$accion = $_GET['accion'];

		// Acción: aceptar cookies
		if ($accion === 'aceptar') {
			// Expira en 60 segundos
			setcookie('cookies_aceptadas', '1', time() + 60); 
			// Redirección al propio script
			header('Location: act1triki.php'); 
			exit();
		}

		// Acción: establecer estilo
		if ($accion === 'estilo' && isset($_GET['valor'])) {
			$estilo = $_GET['valor'];
			// Expira en 30 días
			setcookie('estilo', $estilo, time() + (30 * 24 * 60 * 60)); 
			header('Location: act1triki.php'); 
			exit();
		}

		// Acción: borrar cookies
		if ($accion === 'borrar') {
			// Eliminar cookie de aceptación
			setcookie('cookies_aceptadas', '', time() - 3600); 
			// Eliminar cookie de estilo
			setcookie('estilo', '', time() - 3600); 
			header('Location: act1triki.php'); 
			exit();
		}
	}

	// Comprobar si existe la cookie de estilo
	$estilo = isset($_COOKIE['estilo']) ? $_COOKIE['estilo'] : 'dark';
	$archivoEstilo = $estilo === 'light' ? '/css/light.css' : '/css/dark.css';
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triki: el monstruo de las Cookies</title>
    <link rel="stylesheet" href="<?= $archivoEstilo ?>">
</head>
<body>
	<?php 
		if (!isset($_COOKIE['cookies_aceptadas'])) { 
		echo '<div id="cookies">'; 
		echo 'Este sitio web utiliza cookies propias y puede que de terceros.<br>'; 
		echo 'Al utilizar nuestros servicios, aceptas el uso que hacemos de las cookies.<br>'; 
		echo '<div><a href="?accion=aceptar">ACEPTAR</a></div>'; 
		echo '</div>'; 
		}
	?>
    <h1>Bienvenido a la web de Triki, el monstruo de las cookies</h1>
    <h2>Bienvenido a la web donde no se gestionan las cookies, se devoran.</h2>
    <img src="/img/triki.jpg" alt="Imagen de Triki mirando una galleta">
    
    <div id="botones">
        <a href="?accion=estilo&valor=light" class="styleButton">Claro</a>
        <a href="?accion=estilo&valor=dark" class="styleButton">Oscuro</a>
    </div>
    <br>

    <div><a href="?accion=borrar">Borrar cookies</a></div>
</body>
</html>
