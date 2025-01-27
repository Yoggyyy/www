@extends('layout')

@section('title', 'PeliculasJordiSantos')

@section('content')
    <h1>
        Listado de películas
    </h1>

    @foreach ($movies as $movie)

        <a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a>
        <br>



    @endforeach

    {{ $movies->links() }}
@endsection
