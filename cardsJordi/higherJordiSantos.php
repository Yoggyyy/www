<?php

/**
 * Archivo que contiene la modalidad más alta y su simulación
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */


require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/cardGenerator.inc.php');

// Listas de nombres y apellidos
$firstNames = ['Carlos', 'Luis', 'Ana', 'María', 'Juan', 'Pedro', 'Laura', 'Sofía', 'Miguel', 'Camila'];
$lastNames = ['Pérez', 'García', 'Rodríguez', 'López', 'Martínez', 'Gómez', 'Hernández', 'Fernández', 'Ruiz', 'Sánchez'];

for ($i = 0; $i <=1; $i++) {
    $players[$i] = [
        'name' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
        'hand' => [],
        'roundResult' => [],
        'totalScore' => 0,
        'results' => ''
    ];
}

// Repartir cartas a los jugadores
if (!empty($deck)) { // Asegúrate de que el mazo no esté vacío
    for ($i = 0; $i < 10; $i++) { // Repartir 2 cartas
        foreach ($players as $key => $player) {
            $players[$key]['hand'][] = array_pop($deck);
        }
    }
} else {
    echo 'El mazo de cartas está vacío. No se pueden repartir cartas.'; // Mensaje de depuración
}


function getNumericValue($cardValue)
{
    switch ($cardValue) {
        case 'J':
            return 11;
        case 'Q':
            return 12;
        case 'K':
            return 13;
        default:
            return $cardValue;
    }
}

for ($i = 0; $i < count($players[0]['hand']); $i++) {
    // Obtener el valor de las cartas
    $value1 = getNumericValue($players[0]['hand'][$i]['value']);
    $value2 = getNumericValue($players[1]['hand'][$i]['value']);

    // Comparar los valores
    if ($value1 == $value2) {
        $players[0]['totalScore']++;
        $players[1]['totalScore']++;
        $players[0]['roundResult'][] = 'draw';
        $players[1]['roundResult'][] = 'draw';
    } elseif ($value1 > $value2) {
        $players[0]['totalScore'] += 2;
        $players[1]['roundResult'][] = 'lose';
        $players[0]['roundResult'][] = 'win';
    } else {
        $players[1]['totalScore'] += 2;
        $players[1]['roundResult'][] = 'win';
        $players[0]['roundResult'][] = 'lose';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<?php

$title = 'Higher';
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head.inc.php');

?>

<body>

    <h1>Carta mas alta</h1>
    <div class='mesaDeJuego1'>
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');
        // Utilizo la logica programada al principio para mostrar los resultados pedidos 
        // Mostrar información de los jugadores
        echo '<section>' . 'Jugador 1: ' . $players[0]['name'] . '</section>';
        foreach ($players[0]['hand'] as $key => $card) {
            echo '<img src="/images/deck/' . $card['image'] . '" alt="' . $card['value'] . ' de ' . $card['suit'] . '" class="' . $players[0]['roundResult'][$key] . '">';
        }

        echo '<section>' . 'Jugador 2: ' . $players[1]['name'] . '</section>';
        foreach ($players[1]['hand'] as $key => $card) {

            echo '<img src="/images/deck/' . $card['image'] . '" alt="' . $card['value'] . ' de ' . $card['suit'] . '" class="' . $players[1]['roundResult'][$key] . '">';
        }

        // Mostrar resultado de la partida
        echo '<section>Resultado de la partida:</section>';
        echo '<section>' . $players[0]['name'] . ': ' . $players[0]['totalScore'] . ' puntos. ' . '</section>';
        echo '<section>' . $players[1]['name'] . ': ' . $players[1]['totalScore'] . ' puntos. ' . '</section>';

        // Determinar y mostrar el ganador
        if ($players[0]['totalScore'] > $players[1]['totalScore']) {
            echo '<section>¡El ganador es ' . $players[0]['name'] . ' con una puntuación de: ' . $players[0]['totalScore'] . '!</section>';
        } elseif ($players[1]['totalScore'] > $players[0]['totalScore']) {
            echo '<section>¡El ganador es ' . $players[1]['name'] . ' con una puntuación de: ' . $players[1]['totalScore'] . '!</section>';
        } else {
            echo '<section>¡Es un empate!</section>';
        }
        ?>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>