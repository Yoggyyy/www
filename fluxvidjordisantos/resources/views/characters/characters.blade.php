<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Characters</title>
</head>
<body>
    <div class="container">
        @forelse ($characters as $character)
        <div class="character-card">
            <img class="character-image" src="{{$character['img']}}" alt="{{$character['name']}}">
            <div class="character-info">
                <h2>Personaje: {{$character['name']}}</h2>
                <span>Alias: {{$character['alias']}}</span><br>
                <span>Pelicula: {{$character['movie']}}</span><br>
                <span>Edad: {{$character['age']}}</span><br>
                <span>Especie: {{$character['species']}}</span><br>
                <span>Género: {{$character['gender']}}</span>
            </div>
        </div>
        @empty
        <div class="no-characters">No hay personajes</div>
        @endforelse
    </div>
</body>
</html>

