@extends('layouts.app-front')

@section('title', "Recherche location salle reunion")
@section('meta-description', "location de salle reunion pour votre prochain événement à Paris. Découvrez une grande sélection de salles adaptées à toutes vos occasions : conférence, séminaire et plus encore.")

@section('content')
@include('_partials.components.map-space')
<h1 class="relative flex flex-col items-center text-white py-36" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('/images/about/location-pic.jpg'); background-position: 0% 15%;">
        <span class="text-4xl uppercase pb-4 bannerTxtAnime">Easy Reunion</span>
        <span class="text-2xl txt-mobil font-light uppercase bannerTxtAnimeL">Location de salle pour tous vos événements</span>
</h1>

@include('_partials.components.search-spaces')


    <main class="w-full max-w-screen-xl mx-auto pt-6 pb-16 px-10">



        <section class="space-y-2">
            <h2 class="my-10">Location d'espaces dédies à chacun de vos évènements professionnels</h2>

            <p class="leading-3 text-justify noneMobil">Nous vous proposons des salles de réunion à Paris, pour vos évènements formels et informels.
                 Selon vos besoins, une salle de réunion modulable, équipée et adaptée à vos besoins sera ainsi toujours mise à votre disposition.
                 Que ce soit pour une demi-journée ou encore une journée d'étude. Réservez votre salle de conférence sur notre site ou en nous contactant directement,
                 nous vous proposerons des espaces flexibles ou dédiés à des usages spécifiques.
                 Louer un bureau dans une petite salle de formation ou dans un espace de réunion pouvant accueillir un public plus conséquent fait partie de notre panel de prestations.
                 Salles de réunion, salles de formation, salles de séminaire, salles de conférence et open spaces répondront à vos besoins professionnels.
                 De tels espaces peuvent accueillir tous types d’évènements de la simple salle de réunion au grand amphithéâtre à Paris.
                 Les dimensions variables de nos salles de séminaire vous permettront de choisir entre des dispositions distinctes de salles, selon vos désirs.
                 Formats en U, classe, réunion, carré ou îlot… Autant de dispositions de salles de réunion influençant la perception de l'évènement par votre public.
                 Faîtes nous connaître vos attentes en conséquence !</p>
        </section>
        <button id="openMap" class="flex btn gap-5 w-60 my-10 info justify-center items-center h-in">
                <span class="text-base">Afficher la carte</span>
                <img class="h-10 w-10" src="/images/icones/map-icon.svg" alt="incon carte">
        </button>
        <section class="w-full space-y-8">

            <div  class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6 mx-auto">
                @foreach($spaces as $space_group)
                    @include('_partials.components.grid-space-groups', compact('space_group'))
                @endforeach
            </div>

        </section>
        <a href="{{ route('catalogue') }}" class="btn dense easyBtn h-in w-full">VOIR TOUTES LES SALLES</a>
    </main>
@endsection
