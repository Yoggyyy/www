<?php

/**
 * Archivo que contiene la modalidad blackjack y su simulación
 *
 * @author Jordi Santos Torres
 * @version 1.0.0
 */
?>

<!DOCTYPE html>
<html lang="en">
<?php
$title = 'BlackJack';
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/head.inc.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/cardGenerator.inc.php');

$players = [];
$players[0] = [
    'name' => 'Banca',
    'hand' => [],
    'roundResult' => [],
    'totalScore' => 0,
    'results' => ''
];

// Generar nombres para los jugadores
$firstNames = ['Carlos', 'Luis', 'Ana', 'María', 'Juan', 'Pedro', 'Laura', 'Sofía', 'Miguel', 'Camila'];
$lastNames = ['Pérez', 'García', 'Rodríguez', 'López', 'Martínez', 'Gómez', 'Hernández', 'Fernández', 'Ruiz', 'Sánchez'];

for ($i = 1; $i <= 5; $i++) {
    $players[$i] = [
        'name' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
        'hand' => [],
        'roundResult' => [],
        'totalScore' => 0,
        'results' => ''
    ];
}

if (!empty($deck)) { // Asegúrate de que el mazo no esté vacío
    for ($i = 0; $i < 2; $i++) { // Repartir 2 cartas
        foreach ($players as $key => $player) {
            $players[$key]['hand'][] = array_pop($deck);
        }
    }
} else {
    echo 'El mazo de cartas está vacío. No se pueden repartir cartas.'; // Mensaje de depuración
}

// Calcular puntuación y repartir cartas adicionales si es necesario
foreach ($players as $key => $player) {
    $score = 0;
    $aceCount = 0;

    foreach ($player['hand'] as $card) {
        $value = $card['value'];
        if ($value == 'A') {
            $aceCount++;
            $score += 11; // As cuenta como 11 inicialmente
        } elseif (in_array($value, ['J', 'Q', 'K'])) {
            $score += 10; // J, Q, K cuentan como 10
        } else {
            $score += intval($value); // Cualquier otro valor se convierte a entero
        }
    }

    // Ajustar el puntaje si se excede 21 y hay ases
    while ($score > 21 && $aceCount > 0) {
        $score -= 10;
        $aceCount--;
    }

    // Seguir repartiendo cartas hasta que el puntaje sea 14 o más
    while ($score < 14 && !empty($deck)) {
        $newCard = array_pop($deck);
        $players[$key]['hand'][] = $newCard; 
        $value = $newCard['value'];
        if ($value == 'A') {
            $aceCount++;
            $score += 11; // As cuenta como 11
        } elseif (in_array($value, ['J', 'Q', 'K'])) {
            $score += 10; // J, Q, K cuentan como 10
        } else {
            $score += intval($value); 
        }

        // Ajustar el puntaje si se excede 21 y hay ases
        while ($score > 21 && $aceCount > 0) {
            $score -= 10;
            $aceCount--;
        }
    }

    $players[$key]['totalScore'] = $score; // Usar el índice del jugador
}

?>

<body>

    <h1>BlackJack</h1>
    <div class='mesaDeJuego2'>
        <?php
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/header.inc.php');

        // Mostrar información de los jugadores
        echo '<div class="container">';
        foreach ($players as $i => $player) {
            echo '<div class="players">';
            echo '<section>' . $player['name'] . ':</section>';
            foreach ($player['hand'] as $key => $card) {
                // Comprobar que el índice $key sea válido para roundResult
                $class = isset($player['roundResult'][$key]) ? $player['roundResult'][$key] : '';
                echo '<img src="/images/deck/' . $card['image'] . '" alt="' . $card['value'] . ' de ' . $card['suit'] . '" class="' . $class . '">';
            }
            echo '<section>Puntuación: ' . $player['totalScore'] . ' puntos.</section>';
            echo '</div>';
        }
        echo '</div>';

        // Mostrar resultado de la partida
        echo '<section>Resultado de la partida:</section>';
        echo '<section>' . $players[0]['name'] . ': ' . $players[0]['totalScore'] . ' puntos. </section>';

        // Determinar y mostrar el ganador
        foreach ($players as $key => $player) {
            if ($key > 0) {
                if ($player['totalScore'] > 21) {
                    continue;
                }

                if ($player['totalScore'] > $players[0]['totalScore']) {
                    echo '<section>Gana ' . $player['name'] . ' con una puntuación de: ' . $player['totalScore'] . '!</section>';
                } elseif ($player['totalScore'] === $players[0]['totalScore']) {
                    echo '<section>' . $player['name'] . ' empató con la banca.</section>';
                } else {
                    echo '<section>' . $player['name'] . ' perdió contra la banca.</section>';
                }
            }
        }
        ?>
    </div>

    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/footer.inc.php');
    ?>
</body>

</html>