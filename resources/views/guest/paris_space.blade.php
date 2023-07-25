@php
    use App\Services\SpacesService;

    $spaceService = new SpacesService();
    $addressJson = $spaceService->getSpacesJson();

    $filteredAddresses = array_filter($addressJson, function ($item) {
        return strpos($item['address'], 'Paris') !== false;
    });

    // Convertir le tableau filtré en JSON
    $filteredJson = json_encode($filteredAddresses);

@endphp
@extends('layouts.app-front')
@section('title', 'location salle paris pour vos réunion, séminaire ou formation')
@section('meta-description', " Location salle Paris - Louez la salle idéale pour votre événement dans la ville lumière. Découvrez notre sélection de salles de réception, de conférence et de séminaire à louer à Paris. Contactez-nous pour réserver votre salle dès maintenant.")
@section('canonical', Request::url() )

@section('content')

<main class="flex flex-col">
    <div class="headinSet headinSetBg">
            <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">Location de salle à Paris</h1>
    </div>
    <section class="paris_page md:px-28 md:py-14">
        <h2>Location de salle à Paris : Des espaces exceptionnels pour tous vos événements</h2>
        <div class="article_container">
        @foreach ($filteredAddresses as $address)
            <div class="page-article_item">
                <div class="page-article_img">
                    <a href="/espaces/{{ $address['slug'] }}">
                        <img src="{{ $address['highlight_image'] }}" alt="Image {{ $address['name'] }}">
                    </a>
                </div>
                <div class="page-article_txt">
                    <a class="easy-DarkBlue" href="/espaces/{{ $address['slug'] }}">{{ $address['name'] }}</a>
                    <p>{{ $address['address'] }}</p>
                    <p class="easy-BlueTxtI">Capacité maximale: {{ $address['highest_capacity'] }} personnes</p>
                </div>
            </div>
        @endforeach
        </div>


    </section>
</main>

@endsection
