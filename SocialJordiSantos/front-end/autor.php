<?php
/**
 * Página "Acerca del Autor".
 *
 * Esta página muestra información sobre el autor del proyecto,
 * incluyendo su nombre, una foto tipo carnet y una breve descripción.
 * 
 * PHP version 8.1
 *
 * @package  SocialLink
 * @author   Jordi Santos
 * @version  1.0
 */

// Configuración e inicio de la sesión
ini_set('session.cookie_lifetime', 300);
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autor</title>
    <link rel="stylesheet" href="/assets/css/style.css"> <!-- Cambia a tu archivo CSS principal -->
</head>
<body>
    <!-- Cabecera -->
    <?php
    /**
     * Incluye la cabecera reutilizable.
     * Proporciona navegación y enlaces comunes para todas las páginas.
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php'); 
    ?>

    <!-- Contenido principal -->
    <main>
        <section class="autor-section">
            <h1>Acerca del Autor</h1>
            <div class="autor-content">
                <div class="autor-photo">
                    <img src="/assets/images/fotoJordi.png" alt="Foto tipo carnet de Jordi Santos Torres">
                </div>
                <div class="autor-info">
                    <p><strong>Nombre:</strong> Jordi Santos Torres</p>
                    <p>
                        <strong>Descripción:</strong> 
                        Soy un desarrollador apasionado por aprender nuevas tecnologías y construir soluciones creativas.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <!-- Pie de página -->
    <?php
    /**
     * Incluye el pie de página reutilizable.
     * Proporciona información legal y enlaces secundarios.
     */
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php'); 
    ?>
</body>
</html>


