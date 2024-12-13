<?php
// iniciamos y configuramos la sesion
ini_set('session.name', 'SesionJordi');
ini_set('session.cookie_lifetime', 300);
//se inicia o se recupera la anterior
session_start();

// Si se recibe la variable basket por get y su valor es delete se debe borrar todo el carrito
if (isset($_GET['basket']) && $_GET['basket']==='delete') {
	unset($_SESSION['basket']);
	// Tras borrar el carrito se redirige al propio script para no mostrar la URL: basket/delete
	header('location: /basket');
	exit;
}


// Si el usuario no está logueado se le redirigirá a index porque no puede ver esta parte de la aplicación


// Si hay elementos en el carrito se obtiene su información de la BBDD
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/env.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/connection.inc.php');
try {
	if ($connection = getDBConnection(DB_NAME, DB_USERNAME, DB_PASSWORD)) {
		if (!empty($_SESSION['basket'])) {
		 	/* Recorrer el carrito (en la sesión) */
			foreach($_SESSION['basket'] as $productId => $quantity) {
			// Con cada producto de la sesión se obtiene su información de la BBDD
			$product = $connection->query('SELECT name, price 
										   FROM products 
										   WHERE id='. $productId .';', PDO::FETCH_OBJ);
			$products[] = ['info' => $product->fetch(), 'quantity' => $quantity];
			}
		}
		

	} else {
		throw new Exception('Error en la conexión a la BBDD');
	}
} catch (Exception $exception) {	
	$dbError = true;
}
unset($product);
unset($connection);
// Fin obtener datos de los productos del carrito
?>
<!doctype html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>MerchaShop - carrito</title>
		<link rel="stylesheet" href="/css/style.css">
	</head>

	<body>	
		<?php
			require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/header.inc.php');
		?>

		<h2>Carrito</h2>
		<a href="/basket/delete" class="boton">Vaciar carrito</a>
		<br>
		<br>
		<section>
			<!-- Si el carrito está vacío: -->
			<?php
			if (empty($_SESSION['basket'])) {
				echo '<div>El carrito está vacío.</div>';
			}else{
			?>	
			
			<!-- Si el carrito tiene productos: -->
			<?php
			$basketTotal = 0;

			echo '<table>';
			echo '<tr><td>Producto</td><td>Unidades</td><td>Precio</td><td>Subtotal</td></tr>';
			foreach($products as $product) {
				echo '<tr>';
					echo '<td>'. $product['info']->name .'</td>';
					echo '<td>'. $product['quantity'] .'</td>';
					echo '<td>'. $product['info']->price .' €/unidad</td>';
					echo '<td>'. $product['quantity']*$product['info']->price .' €</td>';
					$basketTotal += $product['quantity']*$product['info']->price;
				echo '</tr>';
			}		
			echo '<tr><td></td><td></td><td>Total</td><td>'. $basketTotal .' €</td></tr>';
			echo '</table>';
	    		}
			?>
			<br><br>
			<a href="/" class="boton">Volver</a>				
		</section>
	</body>
</html>