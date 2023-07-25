@extends('layouts.app-front')
@push('scripts')
<!-- Balisage JSON-LD généré par l'outil d'aide au balisage de données structurées de Google -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "LocalBusiness",
  "name": "Easy Réunion",
  "image": "https://www.easyreunion.fr/images/logo/new-logo-small.png",
  "telephone": "+33 1 79 72 33 03",
  "email": "contact@easyreunion.fr",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "8 rue d'Angoulême",
    "addressLocality": "Versailles",
    "postalCode": "78000"
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": [
      "Monday",
      "Tuesday",
      "Wednesday",
      "Thursday",
      "Friday"
    ],
    "opens": "09:00",
    "closes": "17:00"
  },
  "sameAs": [
    "URL de votre page Facebook",
    "https://www.linkedin.com/company/easy-r%C3%A9union/",
    "https://www.instagram.com/easyreunion/?igshid=YmMyMTA2M2Y%3D",
    "https://www.youtube.com/@easyreunion"
  ],
  "url": "https://www.easyreunion.fr/",
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": "48.810279044158285",
    "longitude": "2.128099352356981"
  }
}
</script>

@endpush
@section('content')

    @if(session('success'))
        {{ session('success') }}
    @endif

    <main id="home_page_main" class="w-full mt-2">

        @include('guest._home.header')

        @include('guest._home.search_bar')

        @include('guest._home.gallery_exclusive')

        @include('guest._home.bloc_event')

        @include('guest._home.gallery_featured')

        <br/><br/>
        @include('guest._home.bloc_service')
        <br/><br/>

        @include('guest._home.bloc_easy')

        @include('guest._home.form')

        {{-- Network --}}
        <section class="py-6 text-black space-y-4 flex flex-col">
            <h2 class="my-10 text-center">Retrouvez nos événements sur les réseaux sociaux</h2>
            <div class="flex felxcol1 justify-center">
                <div role="contentinfo">

                    <a href="https://www.youtube.com/@easyreunion" target="_blank" class="hoverIcon"
                            rel="noopener noreferrer" title="Suivez notre actualité sur youtube">
                        <img class="max-h-20 basis-1/2 h-full w-auto mx-auto"
                             src="{{ asset('images/social/ernew-youtube.png') }}" alt="Notre actualité sur YouTube">
                        <p class="text-center">YouTube</p>
                    </a>
                </div>
                <div role="contentinfo">
                    <a href="https://www.linkedin.com/company/easy-r%C3%A9union/" class="hoverIcon" target="_blank" rel="noopener noreferrer" title="Suivez notre page linkedin">
                        <img class="h-full max-h-20 basis-1/2 w-auto mx-auto"
                             src="{{ asset('images/social/ernew-linkedin.png') }}" alt="Notre actualité sur Linkedin">

                        <p class="text-center">Linkedin</p>
                    </a>

                </div>
                <div role="contentinfo">
                    <a href="https://instagram.com/easyreunion?igshid=YmMyMTA2M2Y=" class="hoverIcon"
                        target="_blank" rel="noopener noreferrer" title="Easy Réunion - Nos activités sur Instagram">
                        <img class="h-full max-h-20 basis-1/2 w-auto mx-auto"
                             src="{{ asset('images/social/ernew-insta.png') }}" alt="Notre actualité sur Instagram">
                        <p class="text-center">Instagram</p>
                    </a>
                </div>
            </div>
        </section>

    </main>

@endsection

@push('scripts')
    <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
    <script src="{{ asset('js/txt-anime.js') }}"></script>

    @include('_partials.components.recaptcha', ['formId' => 'contactForm'])
@endpush
