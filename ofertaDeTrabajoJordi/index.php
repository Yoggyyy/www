<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar datos
    foreach ($_POST as $key => $value) {
        $_POST[$key] = trim($value);
    }

    $exito = false;

    // Expresiones regulares
    $codigo_pattern = '/^[A-Za-z0-9_-]{3,20}$/';  // Validación flexible para el usuario
    $nombre_pattern = '/^[A-Za-z]{3,20}$/';  // Solo letras y de 3 a 20 caracteres
    $apellido1_pattern = '/^[A-Za-z\s]{3,30}$/'; // Apellidos de 3 a 30 caracteres
    $apellido2_pattern = '/^[A-Za-z\s]{3,30}$/'; // Apellidos de 3 a 30 caracteres
    $dni_pattern = '/^[0-9]{8}[A-Za-z]$/';  // 8 números y una letra al final
    $direccion_pattern = '/^[A-Za-z0-9\s]{10,50}$/';  // De 10 a 50 caracteres alfanuméricos
    $email_pattern = '/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/'; // Email válido
    $telefono_pattern = '/^\d{9}$/';  // 9 dígitos para teléfono
    $fecha_pattern = '/^\d{4}-\d{2}-\d{2}$/';  // Fecha en formato AAAA-MM-DD

    // Validar campos
    if (!preg_match($codigo_pattern, $_POST['user'])) {
        $errors['user'] = 'El usuario debe tener entre 3 y 20 caracteres alfanuméricos.';
    }

    if (!preg_match($nombre_pattern, $_POST['name'])) {
        $errors['name'] = 'El nombre solo debe contener letras y tener entre 3 y 20 caracteres.';
    }

    if (!preg_match($apellido1_pattern, $_POST['subname1'])) {
        $errors['subname1'] = 'Los apellidos solo deben contener letras y tener entre 3 y 30 caracteres.';
    }

    if (!preg_match($apellido2_pattern, $_POST['subname2'])) {
        $errors['subname2'] = 'Los apellidos solo deben contener letras y tener entre 3 y 30 caracteres.';
    }

    if (!preg_match($dni_pattern, $_POST['dni'])) {
        $errors['dni'] = 'El DNI debe tener 8 números seguidos de una letra.';
    }

    if (!preg_match($direccion_pattern, $_POST['street'])) {
        $errors['street'] = 'La dirección debe tener entre 10 y 50 caracteres alfanuméricos.';
    }

    if (!preg_match($email_pattern, $_POST['mail'])) {
        $errors['mail'] = 'El email no tiene un formato válido.';
    }

    if (!preg_match($telefono_pattern, $_POST['numberphone'])) {
        $errors['numberphone'] = 'El teléfono debe tener 9 dígitos.';
    }

    if (!preg_match($fecha_pattern, $_POST['date'])) {
        $errors['date'] = 'La fecha debe tener el formato AAAA-MM-DD.';
    }
    if (!empty($_FILES)) {

        //Comprueb si se produjo algun error al subir el archivo photo 
        // UPLOAD_ERR_OK= 0 
        // Si $_FILES['photo']['error']
        if ($_FILES['photo']['error'] != UPLOAD_ERR_OK) {
            switch ($_FILES['photo']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors['photo'] = 'El fichero es demasiado grande.';
                    break;
                case UPLOAD_ERR_PARTIAL: 
                    $errors['photo'] = 'El fichero no se ha podido subir entero.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errors['photo'] = 'No se ha podido subir el fichero.';
                    break;
                default:
                    $errors['photo'] = 'Error indeterminado con la imagen.';
                    break;
            }
        }
    
        // si no hubo error se comprueba que el archivo sea del tipo requerido
        if ($_FILES['photo']['type'] != 'image/jpeg') {
            $errors['photo'] = 'No se trata de un fichero .jpg/.jpeg';
        }
    
        // Si no hay errores en lo anterior se comprueba si el archivo es uno
        // recién subido al servidor (medida de seguridad)
    
        if (is_uploaded_file($_FILES['photo']['tmp_name']) === true) {
            // En ocasiones ya existe el archivo para no sobrescribirlo hacemos
            // la siguiente comprobacion
            $nuevaRuta = $_SERVER['DOCUMENT_ROOT'] . 'imagenes/candidates/' . $_FILES['photo']['name'];
            if (is_file($nuevaRuta) === true) {
                $errors['photo'] = 'Ya existe un archivo con el mismo nombre';
            }
    
            // Movemos el fichero desde el directorio temporal al final
            if(!move_uploaded_file($_FILES['photo']['tmp_name'], $nuevaRuta)) {
                $errors['photo'] = 'No se puede mover el fichero a su destino';
            }
    
        } 

        //Comprueb si se produjo algun error al subir el archivo cv 
        // UPLOAD_ERR_OK= 0 
        // Si $_FILES['cv']['error']
        if ($_FILES['cv']['error'] != UPLOAD_ERR_OK) {
            switch ($_FILES['cv']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    $errors['cv'] = 'El fichero es demasiado grande.';
                    break;
                case UPLOAD_ERR_PARTIAL: 
                    $errors['cv'] = 'El fichero no se ha podido subir entero.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $errors['cv'] = 'No se ha podido subir el fichero.';
                    break;
                default:
                    $errors['cv'] = 'Error indeterminado con el cv.';
                    break;
            }
        }
    
        // si no hubo error se comprueba que el archivo sea del tipo requerido
        if ($_FILES['cv']['type'] != 'application/pdf') {
            $errors['cv'] = 'No se trata de un fichero .pdf';
        }
    
        // Si no hay errores en lo anterior se comprueba si el archivo es uno
        // recién subido al servidor (medida de seguridad)
    
        if (is_uploaded_file($_FILES['cv']['tmp_name']) === true) {
            // En ocasiones ya existe el archivo para no sobrescribirlo hacemos
            // la siguiente comprobacion
            $nuevaRuta = $_SERVER['DOCUMENT_ROOT'] . 'cvs/' . $_POST['dni'] . '.pdf';
            if (is_file($nuevaRuta) === true) {
                $errors['cv'] = 'Ya existe un archivo con el mismo nombre';
            }
    
            // Movemos el fichero desde el directorio temporal al final
            if(!move_uploaded_file($_FILES['cv']['tmp_name'], $nuevaRuta)) {
                $errors['cv'] = 'No se puede mover el fichero a su destino';
            }
    
        }
        
    }
    // Si no hay errores en el formulario
    if (empty($errors)) {
        // Guardar el CV en la carpeta 'cvs' con el nombre formato: dni-nombre-apellido1.pdf
        $cv_name = $_SERVER['DOCUMENT_ROOT'] . 'cvs/' . $_POST['dni'] . '-' . $_POST['nombre'] . '-' . explode(' ', $_POST['apellidos'])[0] . '.pdf';
        move_uploaded_file($_FILES['cv']['tmp_name'], $cv_name);

        // Guardar la foto en la carpeta 'images/candidates' con el nombre dni.jpg
        $foto_name = $_SERVER['DOCUMENT_ROOT'] . 'images/candidates/' . $_POST['dni'] . '.jpg';
        move_uploaded_file($_FILES['foto']['tmp_name'], $foto_name);

        $exito = true; 
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Recursivo CV</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>

    <h1>Formulario para mandar tu CV</h1>

    <div>
        <?php
        /*
        if (!empty($errors)) {
            echo '<div class="error">';
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo '</div>';
        }
        */

        if ($exito) {
            // Si el formulario ha sido enviado correctamente, mostramos un mensaje de éxito
            echo '<p>La solicitud se ha registrado correctamente. Hemos recibido su información.</p>';
            echo '<a href="index.php">Volver al formulario</a>';
        } else {
            // Si no ha sido exitoso, mostramos el formulario con los campos ya introducidos y los errores
            /*
                <?php echo'...'; ?> es lo mismo que <?= ... ?>, mirar de hacer snipset d esto
            */
            // ?? devuelve el primer campo que no sea null o vacio 
        ?>
        <form action="#" method="post" enctype="multipart/form-data">
            <label for="usuario">Nombre de usuario:</label>
            <input type="text" id="user" name="user" value="<?= htmlspecialchars($_POST['user'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['user'] ?? '' ?></div><br>

            <label for="nombre">Nombre:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['name'] ?? '' ?></div><br>

            <label for="apellido1">Apellido 1:</label>
            <input type="text" id="subname1" name="subname1" value="<?= htmlspecialchars($_POST['subname'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['subname1'] ?? '' ?></div><br>

            <label for="apellido2">Apellido 2:</label>
            <input type="text" id="subname2" name="subname2" value="<?= htmlspecialchars($_POST['subname'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['subname2'] ?? '' ?></div><br>

            <label for="dni">DNI:</label>
            <input type="text" id="dni" name="dni" value="<?= htmlspecialchars($_POST['dni'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['dni'] ?? '' ?></div>

            <label for="direccion">Dirección:</label>
            <input type="text" id="street" name="street" value="<?= htmlspecialchars($_POST['street'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['street'] ?? '' ?></div>

            <label for="email">Email:</label>
            <input type="email" id="mail" name="mail" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['mail'] ?? '' ?></div><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" id="numberphone" name="numberphone" value="<?= htmlspecialchars($_POST['numberphone'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['numberphone'] ?? '' ?></div><br>

            <label for="fecha">Fecha de nacimiento:</label>
            <input type="date" id="date" name="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>"><br><br>
            <div class= "error"><?= $errors['date'] ?? '' ?></div><br>

            <label for="archivo">Foto de CV:</label>
            <input type="file" name="photo" id="photo"><br><br>
            <div class= "error"><?= $errors['photo'] ?? '' ?></div><br>

            <label for="archivo">CV en pdf:</label>
            <input type="file" name="cv" id="cv"><br><br>
            <div class= "error"><?= $errors['cv'] ?? '' ?></div><br>

            <input type="submit" value="Enviar">
        </form>
    </div>
    <?php
                }
    ?>  
    <footer class="footer">
        <div class="Name">
            <span>Jordi Santos Torres</span>
            <img src="/images/fotoJordi.png" alt="Foto mia de ejemplo">
        </div>
        <div class="wrap-footer">
            <div class="rrss">
                <h5>Redes Sociales</h5>
                <ul>
                    <li><a href="https://www.facebook.com">
                            <img src="/images/face.png" alt="Facebook">
                        </a></li>
                    <li><a href="https://www.instagram.com">
                            <img src="/images/insta.png" alt="Instagram">
                        </a></li>
                    <li><a href="https://twitter.com">
                            <img src="/images/x.png" alt="X">
                        </a></li>
                </ul>
            </div>
        </div>
        <div class="footer-creds">
            <div class="copy-creds">
                <p>©2022 · Todos los derechos reservados.</p>
            </div>
            <div class="legal-creds">
                <ul>
                    <li><a href="">Política de Privacidad</a></li>
                    <li><a href="">Política de Cookies</a></li>
                    <li><a href="">Aviso Legal</a></li>
                </ul>
            </div>
        </div>
    </footer>
</body>

</html>