@extends('layout')

@section('title', 'PeliculasJordiSantos')

@section('content')
    <h1>Lista de Películas</h1>
    @foreach ($movies as $movie)
        <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a>
        (<a href="{{ route('directors.show', $movie->director) }}">{{ $movie->director->name }}</a>)
        <br>
    @endforeach
    {{ $movies->links() }}
@endsection
