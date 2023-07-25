@extends('layouts.app')

@section('content')


    <h2>Paramètre de la page d'accueil</h2>

    <ul class="">
        <li class="li-table"><a href="#">Menu TOUS NOS ESPACES</a></li>
        <li>En-tête du site</li>
        <li>Bloc type de salles</li>
        <li>Trouver rapidement votre salle 1</li>
        <li>Des évènement sur mesure</li>
        <li>Trouver rapidement votre salle 2 (à la une)</li>
        <li>Easy réunion - spécaliste</li>
        <li>Photo contact</li>
        <li>Trouver rapidement votre salle 3 (en exclusivité)</li>
        <div id="settings"></div>
    </ul>

@endsection
@push('end-body')
    <script src="{{ asset('js/settings.js') }}"></script>
@endpush
