@extends('layouts.app-front')

@section('title', 'Easy Reunion - Vos témoignages')
@section('meta-description', "Ils nous font confiance. les témoignages de nos anciens clients. Location de salle, evénement et services techniques. Nous somme là pour vous!")
@section('canonical', Request::url() )

@section('content')
<main class="flex flex-col">
<div class="headinSet">
        <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">Ce que pensent les clients d'Easy Réunion</h1>
    </div>
    <section class="bodyPages md:px-28">
        <h2>De la location à l’évènement</h2>
        <h3>Vos témoignages</h3>

        <article class="bg-gray-100 xl:px-48">
        <div class="grid grid-cols-1 md:grid-cols-2 grid-rows-2">
            <div class="flex flex-col shadow-md easy-bg-Card my-4 md:m-10 p-10 border-spe borderL">
                <img src="{{ asset('images/quoteImg.png') }}" alt="citation">
                    <p class="text-lg easy-DarkBlue">Easy Réunion m'a permis de créer un événement sur-mesure, qui m’a permis de réunir
                        tous mes collaborateurs. Nous avons bénéficié d'une magnifique terrasse, exposée plein Sud et les
                        services ont surpassé nos attentes.</p>
                    <div class="customer">
                        <p class="font-bold mt-3">Pierre D.</p>
                        <p class="text-gray-600 text-sm">Client</p>
                    </div>
            </div>
            <div class="flex flex-col shadow-md easy-bg-Card my-4 md:m-10 p-10 border-spe borderR">
            <img src="{{ asset('images/quoteImg2.png') }}" alt="citation">
                <p class="text-lg easy-DarkBlue">Je remercie toute l'équipe d'Easy Réunion pour m'avoir accompagné tout au long de la
                    mise en place de mon projet de valorisation d'espace. Le contact a été facile et ils ont répondu
                    rapidement à mes interrogations.</p>
                    <div class="customer">
                        <p class="font-bold mt-3">Antonin S.</p>
                        <p class="text-gray-600 text-sm">Client</p>
                    </div>
            </div>
            <div class="flex flex-col justify-center shadow-md easy-bg-Card my-4 md:m-10 p-10 border-spe borderR">
            <img src="{{ asset('images/quoteImg2.png') }}" alt="citation">
                <p class="text-lg easy-DarkBlue">Proximité, confiance et transparence…voilà ce qu'ont été pour moi les services d'Easy
                    Réunion. Je les remercie pour m'avoir conseillée sur la meilleure option pour louer une salle de
                    formation à Paris.</p>
                    <div class="customer">
                        <p class="font-bold mt-3">Anne F.</p>
                        <p class="text-gray-600 text-sm">Responsable Communication</p>
                    </div>
                
            </div>
            <div class="flex flex-col shadow-md easy-bg-Card my-4 md:m-10 p-10 border-spe borderL">
            <img src="{{ asset('images/quoteImg.png') }}" alt="citation">
                <p class="text-lg easy-DarkBlue">En tant que professionnelle, il peut parfois être malaisé de trouver une salle de
                    libre pour organiser une réunion d’équipe. Grâce aux solutions d'Easy Réunion, j'ai pu tout prévoir
                    sur-mesure.</p>
                <div class="customer">
                    <p class="font-bold mt-3">Virigine M.</p>
                    <p class="text-gray-600 text-sm">Secrétaire R.H.</p>
                </div>
            </div>
        </div>
    </article>

    </section>
    <h2 class="text-center mb-10">Ils nous font confiance...</h2>
    <section class=" flex justify-center items-center flex-wrap w-full gap-10">
        <img class="h-24 opacity-20 hover:opacity-100 my-3 xl:my-0"
             src="/images/about/client-min-ecologie.jpg" alt="Logo ministère de l'écologie">
        <img class="h-24 opacity-20 hover:opacity-100 my-3 xl:my-0"
             src="/images/about/client-laposte.jpg" alt="Logo La Poste">
        <img class="h-24 opacity-20 hover:opacity-100 my-3 xl:my-0" src="/images/about/client-sncf.jpg"
             alt="Logo SNCF">
        <img class="h-24 opacity-20 hover:opacity-100 my-3 xl:my-0" src="/images/about/client-bnp.png"
             alt="Logo BNP">
        <img class="h-24 opacity-20 hover:opacity-100 my-3 xl:my-0" src="/images/about/client-total.jpg"
             alt="Logo Total">
    </section>
    
</main>
@endsection
