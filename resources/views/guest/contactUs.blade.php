@extends('layouts.app-front')

@section('title', 'Contactez-nous')
@section('meta-description', "Contactez Easy Réunion par téléphone au +33 1 79 72 33 03 ou par mail contact@easyreunion.fr")
@section('canonical', Request::url() )

@section('content')

@if(session('success'))
        {{ session('success') }}
    @endif

<main class="flex flex-col">
    <div class="headinSet">
        <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">Easy Réunion à votre service</h1>
    </div>
    <section class="bodyPages md:px-28 md:py-14">
        <h2>Contactez-nous</h2>
        <h3>N'hésitez pas à nous contacter pour toute demande de renseignements, suggestion ou commentaire. Nous sommes à votre disposition pour vous répondre dans les meilleurs délais.</h3>
        
        {{-- Contact --}}
        <article class="bg-center bg-cover py-10 rounded-2xl easyLightBlue-bg">
        
            <div class="w-full md:w-1/2 mx-auto">
                @if(session('success'))
                    @include('_partials.alerts.success', ['success' => session('success')])
                @endif
                @if($errors->count() > 0)
                    @include('_partials.alerts.errors', ['errors' => $errors->all()])
                @endif
            </div>
            <form action="{{ route('contact') }}" method="POST" id="contactForm"
                  class="grid grid-cols-1 md:grid-cols-2 gap-y-6 md:gap-y-0 gap-x-6 max-w-screen-lg w-4/5 mx-auto z-10">
                @csrf
                <div class="h-full flex flex-col gap-y-4 fromStyle">
                    <label class="w-full" alt="Entrer votre nom">
                        <span class="invisible">Entrez votre nom et prénom</span>
                        <input type="text" name="name" placeholder="Votre nom" class="w-full h-full max-h-8 "
                               value="{{ old('name') }}">
                    </label>
                    <label class="w-full">
                        <span class="invisible">Entrez votre adresse mail</span>
                        <input type="email" name="email" placeholder="Votre email" class="w-full h-full max-h-8 "
                               value="{{ old('email') }}">
                    </label>
                    <label class="w-full">
                        <span class="invisible">Entrez votre numéro de téléphone</span>
                        <input type="tel" name="phone" placeholder="Votre numéro de téléphone"
                               value="{{ old('phone') }}"
                               class="w-full h-full max-h-8">
                    </label>
                </div>
                <div class="h-full flex flex-col gap-y-4">
                    <label class="flex-1 w-full">
                        <span class="invisible">Entrez votre demande</span>
                        <textarea class="w-full h-full rounded-2xl" placeholder="Votre message à Easy Réunion" rows="6"
                                  name="message">{{ old('message') }}</textarea>
                    </label>
                    <div class="grid place-content-center">
                        <button
                            data-sitekey="{{ config('services.recaptcha.public_key') }}"
                            data-callback='onSubmit'
                            data-action='contact'
                            class="btn easyBtn rounded-2xl g-recaptcha uppercase text-white py-5 px-4 w-auto transition"
                        >Envoyer votre message
                        </button>
                    </div>
                </div>
            </form>
        </article>
    </section>
    
    <section>
        <h3 class="md:px-28 md:py-14">N’hésitez pas à nous laisser votre avis, nous serons ravis de vous lire !</h3>
       
        <div class="imgDisplay easyLightBlue-bg">
        <p class="easy-BlueTxtI font-bold dNoneForMobil">Retrouvez-nous sur</p>
                    <div role="contentinfo">
                        <a href="https://www.youtube.com/@easyreunion" class="hoverIcon" target="_blank"
                        rel="noopener noreferrer">
                            <img
                                src="{{ asset('images/social/ernew-youtube.png') }}" alt="Notre actualité sur YouTube">
                            <p class="text-center">YouTube</p>
                        </a>
                    </div>
                    <div role="contentinfo">
                        <a href="https://www.linkedin.com/company/easy-r%C3%A9union/" class="hoverIcon"
                        target="_blank" rel="noopener noreferrer">
                            <img
                                src="{{ asset('images/social/ernew-linkedin.png') }}" alt="Notre actualité sur Linkedin">
                            <p class="text-center">Linkedin</p>
                        </a>
                    </div>
                    <div role="contentinfo">
                        <a href="https://instagram.com/easyreunion?igshid=YmMyMTA2M2Y=" class="hoverIcon"
                        target="_blank" rel="noopener noreferrer">
                            <img
                                src="{{ asset('images/social/ernew-insta.png') }}" alt="Notre actualité sur Instagram">
                            <p class="text-center">Instagram</p>
                        </a>
                    </div>
                    <div role="contentinfo">
                        <a href="https://g.page/r/CaybzFEQptweEB0/review" class="hoverIcon"
                        target="_blank" rel="noopener noreferrer">
                            <img
                                src="{{ asset('images/social/4-removebg-preview1.png') }}" alt=" votre avis sur google">
                            <p class="text-center">Avis Google</p>
                        </a>
                    </div>
                </div>
    </section>
</main>
@endsection
@push('scripts')
    @include('_partials.components.recaptcha', ['formId' => 'contactForm'])
@endpush