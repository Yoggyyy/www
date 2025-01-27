@extends('layout')

@section('title', 'DirectoresJordiSantos')

@section('content')

    <h1>{{ $director->name }}</h1>

    <section> Cumpleaños: {{ $director->birthday }}</section>

    <section> Nacionalidad :{{ $director->nationality }}</section>

@endsection
