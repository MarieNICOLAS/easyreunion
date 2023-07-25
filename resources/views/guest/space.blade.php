@extends('layouts.app-front')

@section('title', ($space->title === "" || $space->title === null)? $space->name : $space->title)
@section('meta-description', ($space->meta === "" || $space->meta === null) ? trim(str_replace(['&amp;', '&nbsp;', '&amp;eacute;'], ['','', 'é'], substr(strip_tags($space->presentation), 0,100))): $space->meta)

@section('canonical', Request::url() )

@section('content')
    @include('_partials.components.map-space')
    <main class="flex flex-col gap-y-4 items-center md:py-10 lg:max-w-7xl mx-auto">


        <div class="overflow-hidden w-full">

            <div class="relative max-w-7xl mx-auto px-10 sm:px-6 lg:px-10 bg-f5f5 noPadding">

                <div class="mx-auto text-base max-w-prose lg:grid lg:grid-cols-2 lg:gap-8 lg:max-w-none paddingMobil">

                        <div class="breadcrumbs flex content-center">
                            <div>
                                <div class="breadcrumbsItem">
                                    <a href="{{ route('welcome') }}" title="Accueil Easy Reunion">
                                        <i class="material-icons">home</i>
                                    </a>
                                </div>
                                <div class="breadcrumbsItem">
                                    <a href="{{ route('catalogue') }}" title="Voir toutes les salles">Location de salle</a>
                                </div>
                                @if (isset($space->spaceGroup->slug))
                                    <div class="breadcrumbsItem">
                                        <a href="{{ route('spaceGroup', $space->spaceGroup->slug) }}">{{ $space->spaceGroup->name }}</a>
                                    </div>
                                @endif
                                <div class="breadcrumbsItem breadcrumbsDesktopItem easy-DarkBlue font-semibold">
                                    {{ $space->name }}
                                </div>
                            </div>
                        </div>


                </div>
                <div class="mt-8">
                    <div class="flex items-center gap-10 my-10 flexColMobil">
                                        <h1 id="space-value" class="text-3xl fontSmobil leading-8 font-extrabold tracking-tight easy-DarkBlue sm:text-4xl">
                                                {{ $space->name }}
                                        </h1>
                                        <button id="openMap" class="flex btn rounded gap-5 w-60 easyBtn justify-center items-center h-in">
                                            <span class="text-base">Afficher la carte</span>
                                            <img class="h-10 w-10" src="/images/icones/map-icon.svg" alt="incon carte">
                                        </button>
                    </div>
                    <div>
                            <div>

                                    <div class="w-full md:h-92 mx-auto">
                                        @include('_partials.components.slider', [
                                            'images' => $space->media->pluck('url'), 'mediaData' => $space->media, 'space_name' => $space->name, 'view' => 'space'
                                        ])
                                    </div>


                                <ul class="easy-DarkBlue paddingMobil roomAndSpaceInfo">
                                    <li>
                                        <img src="{{ asset('images/icones/residential_113295.svg') }}" alt="icon ville" title="Ville">
                                            {{ $space->city }}
                                    </li>
                                    <li>
                                        <img src="{{ asset('images/icones/location_map_marker_icon_131522.svg') }}" alt="icon address" title="Addresse">
                                            {{ ($space->address != "") ? $space->address : $space->spaceGroup?->address }}
                                    </li>
                                    <li>
                                        <img src="{{ asset('images/icones/europe_navigation_map_dotted_france_country_icon_250852.svg') }}" alt="icon code postal" title="Code postal">
                                        {{ ($space->zip_code != "") ? $space->zip_code : $space->spaceGroup->zip_code  }}
                                    </li>
                                    <li>
                                        <img src="{{ asset('images/icones/basic-pencil-ruler_97804.svg') }}" alt="incon ville" title="Superficie du lieu"> {{ $space->area }}m²
                                    </li>
                                    <li>
                                        <img src="{{ asset('images/icones/team_businessmen_men_communication_group_meeting_conference_icon_250719.svg') }}" alt="incon capacité maximale" title="Capacité du lieu"> Jusqu'à {{ $space->capacity }}
                                        personnes
                                    </li>
                                    @if($space ['has_disabled_access'])
                                    <li>
                                        <div class="flex">
                                            <span class="font-semibold">Accès handicapé : </span>
                                            <img src="{{ asset('images/wheelchair-solid.svg') }}" alt="icon acces handicap" title="Accès handicapé du lieu"
                                                class="w-5 h-auto ml-1">
                                        </div>

                                    </li>
                                    @endif




                                    @if($space->brochure != null && $space->brochure != "")
                                        <li>
                                            <a href="{{ asset($space->brochure) }}" target="_blank" class="btn easyBtn rounded text-whiteF h-in">Télécharger la plaquette</a>
                                        </li>
                                    @endif
                                </ul>
                                @if(get_class($space) == "App\Models\Space")
                                    <div class="mt-5 paddingMobil">
                                        <a class="btn easyBtn h-in mb-12"
                                            rel="nofollow"
                                            href="{{ route('request-quote.index') }}?space={{ $space->slug }}">
                                            Demander un devis
                                        </a>
                                    </div>
                                @endif
                            </div>


                    </div>
                    <div class="mt-8 lg:mt-0 paddingMobil">
                        <div
                            class="mt-5 prose prose-indigo text-gray-500 lg:max-w-none lg:row-start-1 lg:col-start-1">
                            {!! $space->presentation !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(get_class($space) == "App\Models\SpaceGroup")
            <div class="w-full paddingMobil2 lg:px-10">
                <h2 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight sm:text-4xl mb-10">
                    Les salles {{ $space->name }}
                </h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-x-4 gap-y-2">
                    @foreach($space->spaces as $salle)
                        @include('_partials.components.cards.space', ['space' => $salle])
                    @endforeach
                </div>
            </div>
        @endif

        @if(get_class($space) == "App\Models\Space")

            @if(count($materials) > 0)
                <div class="relative bg-f5f5 sm:py-24 md:py-6 w-full lg:px-10">
                    <div class="relative px-4 sm:px-6 lg:px-0 w-full">
                        <!-- Content area -->
                        <div class="pt-12">
                            <h2 class="text-3xl text-gray-900 font-extrabold tracking-tight sm:text-4xl">
                                Équipement et caractéristiques
                            </h2>
                        </div>

                        <!-- Tags section -->
                        <div class="mt-10">
                            @include('_partials.components.grid-tags-group')
                        </div>
                    </div>
                </div>
            @endif

            <div class="relative bg-f5f5 py-16 sm:py-24">
                <div class="lg:mx-auto lg:max-w-7xl lg:px-10 lg:grid lg:grid-cols-2 lg:gap-24 lg:items-start">
                    <div class="relative sm:py-16 lg:py-0">
                        <div aria-hidden="true" class="hidden sm:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-screen">
                            <div class="absolute inset-y-0 right-1/2 w-full rounded-r-3xl lg:right-72"></div>
                            <svg class="absolute top-8 left-1/2 -ml-3 lg:-right-8 lg:left-auto lg:top-12" width="404"
                                 height="392" fill="none" viewBox="0 0 404 392">
                                <defs>
                                    <pattern id="02f20b47-fd69-4224-a62a-4c9de5c763f7" x="0" y="0" width="20"
                                             height="20"
                                             patternUnits="userSpaceOnUse">
                                        <rect x="0" y="0" width="4" height="4" class="text-gray-200"
                                              fill="currentColor"/>
                                    </pattern>
                                </defs>
                                <rect width="404" height="392" fill="url(#02f20b47-fd69-4224-a62a-4c9de5c763f7)"/>
                            </svg>
                        </div>

                        <div class="relative mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-0 lg:max-w-none lg:py-20">
                            <!-- Testimonial card-->
                            <div class="relative pt-64 pb-10 rounded-2xl shadow-xl overflow-hidden">
                                <img class="absolute inset-0 h-full w-full object-cover"
                                     src="{{   $space->media->count() > 0 ? $space->media->random()->url : ''  }}"
                                     alt="{{ $space->meta_title }}">
                            </div>
                        </div>
                    </div>

                    <div class="relative mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-0">
                        <!-- Content area -->
                        <div class="pt-12 sm:pt-16 lg:pt-20">
                            <h2 class="text-3xl text-gray-900 font-extrabold tracking-tight sm:text-4xl">
                                Dispositions et capacités
                            </h2>
                        </div>

                        <!-- Tags section -->
                        <div class="mt-10">
                            <dl class="grid grid-cols-2 gap-x-4 gap-y-8">
                                @foreach($tags as $name => $capacity)
                                    <div class="border-t-2 border-gray-100 pt-6 flex gap-x-3 items-center">
                                        <img class="h-16 w-auto"
                                             src="{{ asset('images/tags/er-tag-salle-' . $name . '.png') }}"
                                             alt="{{ $name }}">
                                        <dl class="text-base font-medium easy-DarkBlue">
                                            <dt>{{ __('tags.'.$name) }}</dt>
                                            @if ($capacity)
                                                <dd>{{ $capacity }} pers.</dd>
                                            @endif
                                        </dl>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>


                </div>
            </div>

        @endif
        <section class="w-full paddingMobil mt-10 lg:px-10">

            <p>Partager ce lieu sur</p>

            <div class="mt-5 flex gap-5">
                    <button class ="btnSocial flex justify-center items-center py-5 share_facebook shareF"
                    data-url="">
                        <img src="{{ asset('images/social/facebook-app-symbol.png') }}" alt="facebook">
                    </button>
                    <button class ="btnSocial flex justify-center items-center py-5 share_twitter shareT"
                    data-url="">
                        <img src="{{ asset('images/social/003-twitter-1.png') }}" alt="twitter">
                    </button>
                    <button class ="btnSocial flex justify-center items-center py-5 share_linkedin shareL"
                    data-url="">
                        <img src="{{ asset('images/social/006-linkedin-5.png') }}" alt="linkedin">
                    </button>

            </div>

        </section>

    </main>

@endsection
@push('end-body')
    <script src="{{ asset('js/social.js') }}"></script>
@endpush
