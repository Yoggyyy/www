@extends('layout')

@section('title', 'DirectoresJordiSantos')

@section('content')

    <h1>{{ $director->name }}</h1>

    <section> Cumpleaños: {{ $director->birthday }}</section>

    <section> Nacionalidad :{{ $director->nationality }}</section>

    <h2>Películas dirigidas</h2>
    @foreach ($director->movies as $movie)
        <li>
            <a href="{{ route('movies.show', $movie) }}">{{ $movie->title }}</a> ({{ $movie->year }})
        </li>
    @endforeach
@endsection
