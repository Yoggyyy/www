@extends('layout')

@section('title', 'DirectoresJordiSantos')

@section('content')
    <h1>Directors</h1>
        @foreach ($directors as $director)
            <li>
                <a href="{{ route('directors.show', $director) }}">{{ $director->name }}</a>
                <br>
            </li>
        @endforeach

        {{ $directors->links() }}
@endsection
