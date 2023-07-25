
@php
    use App\Services\SpacesService;
    $spaceService = new SpacesService();
    $spacesFormElements = $spaceService->getSpacesFormList();
    $allSpaces = $spacesFormElements['allSpaces'];
@endphp
@extends('layouts.app-front')

@section('title', 'Easy Réunion - Plan du site naviguer facilement')
@section('meta-description', "Explorez notre plan de site pour trouver rapidement toutes les pages de notre site.
            Trouvez des informations sur nos services, blog et plus encore.")
@section('canonical', Request::url() )

@section('content')
<main class="flex flex-col">
    <section class="bodyPages">
        <h1 class="text-black text-center text-5xl font-bold mt-10 mb-20">Plan du site</h1>
        <div>
            <p class="txtcenter">Naviguez facilement et trouvez tout ce que vous cherchez en un seul endroit grâce à notre plan de site pratique</p>
            <h2 class="txtcenter">Accueil</h2>
            <div class="flex flex-col justify-center items-center gap-10 text-xl">
                <a href="{{ route('welcome') }}">Page d'accueil</a>
                <a href="{{ route('catalogue') }}">Catalogue</a>
                <a href="/location-salle-paris">Location à paris</a>
                <a href="/services-restauration">Services restauration</a>
                <a href="/services-technique">Services technique</a>
                <a href="/qui-sommes-nous">Qui-sommes-nous</a>
                <a href="/notre-equipe">Notre-equipe</a>
                <a href="/vos-temoignages">Vos-temoignages</a>
                <a href="/jobs">Nous recrutons</a>
                <a href="/pages/faq">FAQ</a>
                <a href="{{ route('articles.list') }}">Blog</a>
                <a href="/contactez-nous">Contactez-nous</a>
            </div>

            <div class="splitBar w-auto mx-15"></div>

            <h2 class="txtcenter">Pages</h2>
            <div class="flex flex-wrap justify-center items-center gap-7 mx-15">
            @foreach(\App\Models\Page::all() as $page)
                <a class="filterLinkMap" href="/pages/{{ $page['slug'] }}">{{ $page->title }}</a>
            @endforeach
            </div>

            <div class="splitBar w-auto mx-15"></div>

            <h2 class="txtcenter">Espaces</h2>
            <div class="flex flex-wrap justify-center items-center gap-7 mx-15">
            @foreach($allSpaces as $space)
                <a class="filterLinkMap" href="/espaces/{{ $space['slug'] }}">
                    {{ $space['name'] }}
                </a>
                @endforeach
            </div>
            
        </div>
    </section>
</main>
@endsection
@push('scripts')
<script src="{{ asset('js/remove-linkSitmap.js') }}"></script>
@endpush
