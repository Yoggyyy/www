<?php
/**
 * Archivo skills que contiene mis aptitudes.
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */
?>

<!DOCTYPE html>
<html lang="en">
<?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head.inc.php');
?>
<body>
    <?php
    // el DIR solo se usa con el require_once
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
    ?>
    <section class="skills">
        <h2>Skills</h2>
        <ul>
            <li>Java</li>
            <li>JavaScript</li>
            <li>HTML</li>
            <li>CSS</li>
            <li>SQL</li>
            <li>MariaDB</li>
            <li>MongoDB</li>
            <li>Git and GitHub</li>
            <li>XML</li>
            <li>XPath</li>
            <li>XSLT</li>
            <li>JSON</li>
        </ul>
        <ul>
            <li>Buena Comunicación</li>
            <li>Adaptabilidad</li>
            <li>Arendizaje continuo</li>
            <li>Organización del tiempo</li>
            <li>Trabajo en equipo</li>
        </ul>
    </section>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>