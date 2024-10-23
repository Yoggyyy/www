<?php
function addWatermark($foto_name, $dni) {
    // Cargar la marca de agua desde el archivo PNG y redimensionarla
    $watermark = imagecreatefrompng('images/marca.png');
    $watermark = imagescale($watermark, 50);

    // Configurar el blending para la transparencia
    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);

    // Obtener dimensiones de la marca de agua
    $watermarkWidth = imagesx($watermark);
    $watermarkHeight = imagesy($watermark);

    // Aplicar un filtro a la marca de agua para cambiar su opacidad
    imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 60);

    // Detectar el tipo de imagen (PNG o JPEG)
    $imageType = mime_content_type($foto_name);
    if ($imageType == 'image/png') {
        $image = imagecreatefrompng($foto_name);
    } elseif ($imageType == 'image/jpeg') {
        $image = imagecreatefromjpeg($foto_name);
    } else {
        die("Formato de imagen no soportado");
    }

    // Obtener dimensiones de la imagen del candidato
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    // Calcular la posición de la marca de agua (colocarla en la esquina inferior derecha)
    $xPosition = $imageWidth - $watermarkWidth - 10; // 10 píxeles desde el borde derecho
    $yPosition = $imageHeight - $watermarkHeight - 10; // 10 píxeles desde el borde inferior

    // Añadir la marca de agua sobre la imagen del candidato
    imagecopy($image, $watermark, $xPosition, $yPosition, 0, 0, $watermarkWidth, $watermarkHeight);

    // Redimensionar la imagen del candidato al 50%
    $newWidth = $imageWidth / 2;
    $newHeight = $imageHeight / 2;
    $image = imagescale($image, $newWidth, $newHeight);

    // Definir el nombre del archivo final con la marca de agua
    $outputFile = 'images/candidates/candidatesBrand/' . $dni . '-thumbnail.png';

    // Guardar la imagen con la marca de agua en formato PNG
    imagepng($image, $outputFile);

    // Liberar recursos
    imagedestroy($image);
    imagedestroy($watermark);
}
?>
