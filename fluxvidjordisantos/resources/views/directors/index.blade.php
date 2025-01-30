@extends('layout')

@section('title', 'DirectoresJordiSantos')

@section('content')
    <h1>Directors</h1>
        @foreach ($directors as $director)
                <a href="{{ route('directors.show', $director) }}">{{ $director->name }}</a>
                <br>
        @endforeach

        {{ $directors->links() }}
@endsection
