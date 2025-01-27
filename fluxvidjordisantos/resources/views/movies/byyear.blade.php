@extends('layout')

@section('title', 'PeliculasPorAño')

@section('content')
    <h1>
        Listado de películas
    </h1>
 
    @foreach ($movies as $movie)
        <div>
            <a href="{{ route('movies.byyear', $movie->year ) }}">{{ $movie->title }}</a>
        </div>
    @endforeach

    {{ $movies->links() }}
@endsection
