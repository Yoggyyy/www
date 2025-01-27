@extends('layout')

@section('content')
    <h1>{{ $director->name }}</h1>

    <section> {{$director->birthday}}</section>

    <section> {{$director->nationality}}</section>

@endsection
