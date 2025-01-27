@extends('layout')

@section('title', 'PeliculasJordiSantos')

@section('content')
    <h1>
        Ficha de la película {{ $movie->title }}
    </h1>

    <section> {{$movie->year}}</section>


    <section> {{$movie->rating}}</section>


    <section> {{$movie->plot}}</section>

    <form action="{{route('movies.destroy', ['movie'=> $movie->id])}}" method="post">
        @csrf
        @method('delete')
        <input type="submit" value="Eliminar">
    </form>
@endsection
