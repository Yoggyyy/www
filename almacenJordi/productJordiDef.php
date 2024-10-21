<?php
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar datos
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
    }

    // Expresiones regulares
    $codigo_pattern = '/^[A-Za-z]-\d{5}$/';  
    $nombre_pattern = '/^[A-Za-z]{3,20}$/';
    $precio_pattern = '/^\d+(\.\d{1,2})?$/';
    $descripcion_pattern = '/^[A-Za-z0-9\s]{50,}$/';
    $fabricante_pattern = '/^[A-Za-z0-9\s]{10,20}$/';
    $fecha_pattern = '/^\d{4}-\d{2}-\d{2}$/';

    // Validar campos
    if (!preg_match($codigo_pattern, $_POST['code'])) {
        $errors['code'] = 'El código debe tener una letra seguida de un guion y 5 dígitos.';
    }

    if (!preg_match($nombre_pattern, $_POST['name'])) {
        $errors['name'] = 'El nombre solo debe contener letras y tener entre 3 y 20 caracteres.';
    }

    if (!preg_match($precio_pattern, $_POST['price'])) {
        $errors['price'] = 'El precio debe ser un valor decimal válido.';
    }

    if (!preg_match($descripcion_pattern, $_POST['descripcion'])) {
        $errors['descripcion'] = 'La descripción debe ser alfanumérica y tener al menos 50 caracteres.';
    }

    if (!preg_match($fabricante_pattern, $_POST['fabricante'])) {
        $errors['fabricante'] = 'El fabricante debe tener entre 10 y 20 caracteres alfanuméricos.';
    }

    if (!preg_match($fecha_pattern, $_POST['date'])) {
        $errors['date'] = 'La fecha debe tener el formato AAAA-MM-DD.';
    }

    // Si no hay errores, ocultar el formulario y mostrar mensaje
    if (empty($errors)) {
        echo "<h1>Producto almacenado correctamente</h1>";
        echo "<a href='/productJordiDef.php'>Volver al formulario</a>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Recursivo Tienda</title>
</head>

<body>

    <h1>Formulario de Producto</h1>

    <div>
        <?php
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo '</div>';
        }
        ?>
        <form action="#" method="post">
            <label for="codigo">Código del producto:</label>
            <input type="text" id="codigo" name="code" value="<?= htmlspecialchars($_POST['code'] ?? '') ?>"><br><br>

            <label for="nombre">Nombre del producto:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"><br><br>

            <label for="precio">Precio del producto:</label>
            <input type="text" id="price" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>"><br><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea><br><br>

            <label for="fabricante">Fabricante:</label>
            <input type="text" id="fabricante" name="fabricante" value="<?= htmlspecialchars($_POST['fabricante'] ?? '') ?>"><br><br>

            <label for="fecha">Fecha de adquisición:</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>"><br><br>

            <input type="submit" value="Enviar">
        </form>
    </div>
</body>

</html>