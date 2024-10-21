<?php
/**
 * Archivo expLaboral que contiene mis anteriores trabajos laborales.
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */
?>

<!DOCTYPE html>
<html lang="en">
<?php
    // el DIR solo se usa con el require_once
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head.inc.php');
    ?>
<body>
<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
?>
    <section class="experiencia">
        <h2>Experiencia laboral</h2>
        <ul>
            <p><b>Técnico Informático</b></p>
            <p>App Informática, Formentera. | Junio 2020 - Septiembre 2021</p>
            <li>Montaje y configuración de ordenadores para garantizar su
                correcto funcionamiento</li>
            <li>Soporte técnico a usuarios a través del servicio de helpdesk,
                resolviendo problemas y respondiendo consultas relacionadas con
                hardware y software.</li>
            <li>Ayudante en instalaciones y configuración de redes para asegurar
                una conectividad estable y segura para los usuarios.</li>
            <li>Reparaciones y mantenimiento de diversos dispositivos
                electrónicos para garantizar su óptimo rendimiento.</li>
        </ul>
    </section>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>