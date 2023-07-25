@php
    use App\Services\SpacesService;
    $spaceService = new SpacesService();
//    $spacesFormElements = $spaceService->getSpacesFormList();
//    $allSpaces = $spacesFormElements['allSpaces'];

    $spaceMenus = $spaceService->getMenus();
@endphp
<div class="flex flex-wrap w-full px-2 md:px-24 py-4 bg-bleu text-black justify-between items-center easyLightBlue-bg">
    <div id="barReservationMobile" style="height: 40px">
        Réservation par <a href="mailto:contact@easyreunion.fr" title="Une conférence ou un séminaire à organiser? contactez-nous par mail"><span class="font-bold">mail</span></a>
        ou
        <a href="tel:+33179723303" class="inline-block bg-white rounded-2xl px-1 py-2 ml-1" title="Pour toute information supplémentaire concernant une location de salle contactez-nous par téléphone"><span class="font-bold">
                01 79 72 33 03</span></a>
    </div>
    <div class="space-x-4 dNoneForMobil">
        @guest
            <span class="">
                 <a href="/#contact" title="Propriétaire d'une salle de location?">
                    Propriétaire d'une salle ? Photographe, traiteur... ?
                 </a>
            </span>
            <a href="{{ route('auth.login-page') }}" class="btn dense h-in rounded easyBtn white">
                Connexion
            </a>
        @endguest
        @auth
            <a href="{{ Auth::user()->homeUrl }}"
               class="btn dense bg-gray hover:bg-gray-800 h-in">{{ Auth::user()->is_admin ? 'Espace admin' : (Auth::user()->is_partner ? "Espace Partenaire" : "Mes réservations") }}
            </a>
            <a href="{{ route('auth.logout') }}" class="btn  h-in rounded easyBtn rounded" title="Quittez votre compte">Déconnexion</a>
        @endauth
    </div>
</div>

<header id="stickNav" class="flex w-full py-2 pl-12 lg:px-23 justify-between items-center shadow-md easy-bg z-50">
    <a href="{{ route('welcome') }}" title="Location salle de réunion ou formation à Paris et Île-de-France">
        <img class="wImg" src="{{ asset('images/logo/new-logo-small.png') }}" alt="Image logo Easy-Reunion" />
    </a>
    <div class="menu-responsive menuPhone bg-transparent transition transform flex lg:space-x-12 items-center justify-start lg:items-center lg:justify-start max-w-[300px] lg:max-w-[unset] w-full lg:w-auto min-w-screen lg:min-w-[unset] text-center lg:text-left fixed lg:relative top-0 right-0 lg:top-[unset] lg:right-[unset] h-full lg:h-auto flex-col lg:flex-row pt-12 pb-8 lg:py-0 overflow-y-auto overflow-x-hidden lg:overflow-x-unset lg:overflow-y-unset">
        <button type="button" class="btn-close absolute top-4 right-14 block lg:hidden font-bold">
            <svg class="w-8 h-8" viewBox="0 0 24 24">
                <path fill="currentColor"
                      d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
            </svg>
        </button>
        <nav class="dropdown w-full p-5 lg:w-auto lg:py-0">
            <button class="btnMenu w-full text-1rem lg:w-auto place-content-center items-center flex gap-5 font-bold">Nos espaces
                <img src="{{ asset('images/logo/down-arrow-svgrepo-com.svg') }}" class="text-xxs" alt="Down Arrow" title="Navigation - Nos espaces">
            </button>


            <div class="hidden w-full lg:w-auto relative lg:absolute" style="background-color: white">
                <a href="{{ route('catalogue') }}"
                   class="w-full lg:w-auto py-4 lg:py-0 block font-bold text-left whitespace-nowrap" title="Trouvez votre salle avec notre catalogue">Tous nos espaces
                </a>
                <a href="/location-salle-paris"
                    class="w-full lg:w-auto py-4 lg:py-0 block font-bold text-left whitespace-nowrap"
                    title="Louez votre salle à Paris">Location à Paris
                </a>
                @foreach($spaceMenus as $name => $slug)
                    <a href="/espaces/{{ $slug }}"
                       class="w-full lg:w-auto text-left text-sm lg:py-0 block pad-2 whitespace-nowrap" title="Présentation des salles {{ $name }}">
                        {{ $name }}
                    </a>
                @endforeach
            </div>
        </nav>
        <nav class="dropdown w-full p-5 lg:w-auto lg:py-0">
            <button class="btnMenu w-full text-1rem lg:w-auto place-content-center items-center flex gap-5 font-bold">Nos services
                <img src="{{ asset('images/logo/down-arrow-svgrepo-com.svg') }}" class="text-xxs" alt="Down Arrow" title="Navigation - Nos services">
            </button>
            <div class="hidden w-full lg:w-auto relative lg:absolute">
                <a href="/services-restauration"
                                            class="w-full lg:w-auto py-4 lg:py-0 block whitespace-nowrap" title="Nos services cocktail / restauration">Restauration
                </a>
                <a href="/services-technique"
                                            class="w-full lg:w-auto py-4 lg:py-0 block whitespace-nowrap" title="Services techniques / Streaming">Technique
                </a>
            </div>
        </nav>
        <nav class="dropdown w-full p-5 lg:w-auto lg:py-0">
            <button class="btnMenu w-full text-1rem lg:w-auto place-content-center flex items-center gap-5 font-bold">Evénements
                <img src="{{ asset('images/logo/down-arrow-svgrepo-com.svg') }}" class="text-xxs" alt="Down Arrow" title="Navigation - Nos Evénements">
            </button>
            <div class="hidden w-full lg:w-auto relative lg:absolute">
                <a href="{{ route('page.show', 'formation') }}" title="Salle pour vos formation">Formation</a>
                <a href="{{ route('page.show', 'réunion') }}" title="Salle pour vos réunion">Réunion</a>
                <a href="{{ route('page.show', 'seminaire') }}" title="Espaces pour vos séminaire">Séminaire</a>
                <a href="{{ route('page.show', 'conference') }}" title="Salle pour vos conference">Conférence</a>
                <a href="{{ route('page.show', 'visio-conference') }}" title="Location salle pour vos evènements numériques">Digital</a>
                <a href="{{ route('page.show', 'cocktail-banquet-gala-restauration') }}" title="Location salle pour vos cocktail, banquet, gala">Cocktail, Banquet, Gala</a>
                <a href="{{ route('page.show', 'assemblee') }}" title="Location de salle pour vos assemblées">Assemblée</a>
            </div>
        </nav>
        <nav class="btnTel pr-5">
            <a href="tel:+33179723303" class="inline-block rounded-2xl btn dense h-in rounded easyBtn white" title="Appelez-nous au 01 79 72 33 03">
                <svg xmlns="http://www.w3.org/2000/svg" style="display: inline; font-weight: bold" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                    <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                </svg>
                <span class="font-bold" id="showPhoneNumber">
                    01 79 72 33 03
                </span>
            </a>
        </nav>
    </div>
    <button class="btn-open block lg:hidden ml-5" aria-label="Menu">
        <svg class="w-8 h-8" viewBox="0 0 24 24">
            <path fill="currentColor"
                  d="M3,6H21V8H3V6M3,11H21V13H3V11M3,16H21V18H3V16Z"/>
        </svg>
       <span class="mr-5">menu</span>
    </button>
</header>


@push('scripts')
<script src="{{ asset('js/header.js') }}"></script>
@endpush
