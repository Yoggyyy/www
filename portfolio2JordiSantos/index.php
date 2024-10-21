<?php
/**
 * Archivo index que contiene la presentacion.
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */
?>

<!DOCTYPE html>
<html lang="en">

<?php
  require_once(__DIR__ . '/includes/head.inc.php')
?>

<body>
  <?php
  // el DIR solo se usa con el require_once
  require_once(__DIR__ . '/includes/header.inc.php')
  ?>
  <section class="presentation">
    <img src="/imagenes/fotoJordi.png" alt="Foto mia de ejemplo">
    <div class="text">
      <p>Me apasiona el mundo de la tecnología. Gracias a mis experiencias
        laborales pasadas, he desarrollado habilidades de organización,
        pensamiento crítico y adaptabilidad que aplico con dedicación en nuevos
        desafíos. Mantenerme al tanto de las últimas tendencias en tecnología me
        motiva a abordar cada proyecto con una mentalidad analítica y creativa.</p>
    </div>
  </section>
  <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
  ?>
</body>

</html>