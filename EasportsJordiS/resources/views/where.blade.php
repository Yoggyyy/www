@extends('partials.layout')

@section('title', 'Dónde Estamos')

@section('content')
<div class="container text-center mt-4">
    <h1>Ubicación de Nuestra Sede</h1>
    <p>Encuéntranos en la siguiente dirección:</p>
    <p><strong>MisfitsGamin</strong></p>
    <p>C/ de José María Haro, 63, Algirós, 46022 València, Valencia</p>

    
    <div class="map-responsive">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434508619!2d144.9537353159046!3d-37.816279742021824!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577a7f2ed4a3b6!2sMelbourne%20Cricket%20Ground!5e0!3m2!1sen!2sau!4v1617707204960!5m2!1sen!2sau"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
    </div>
</div>
@endsection
