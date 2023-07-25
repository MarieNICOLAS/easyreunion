@extends('layouts.app-front')

@section('title', 'Location de salle - liste complète')
@section('meta-description', "Une location de salle de réunion à Paris formel et informel. Une salle de réunion toute équipée. Réservez votre salle de conférence sur notre site ou en nous contactant. Des espaces flexibles dédiés à des usages spécifiques.")
@section('canonical', Request::url() )


@section('content')
@include('_partials.components.map-space')
<div class="headinSet bgImg-tech">
            <span class="mx-auto text-[6vw] leading-none sm:text-5xl">Catalogue des salles</span>
</div>
    <main class="page flex flex-col justify-center items-center">
        <h1 id="space-value">Trouver l'espace pour
                vos séminaires et vos conférences</h1>
        <h2 class="my-10 text-xl">Recherchez votre salle parmi ces différents espaces</h2>
        <button id="openMap" class="flex mt-10 mb-10 btn gap-5 w-60 easyBtn rounded justify-center items-center h-in">
            <span class="text-base">Afficher la carte</span>
            <img class="h-10 w-10" src="/images/icones/map-icon.svg" alt="incon carte">
        </button>

        <!-- Push catalogue list in VueJs -->
        <div id="catalogue" class="w-full w-90Cat"></div>
    </main>

@endsection

@push('scripts')
    <script src="{{ mix('js/catalogue.js') }}"></script>
@endpush

