@extends('layouts.app-front')
<title>@yield('title', __('meta.about_us.title'))</title>
@section('meta-description', __('meta.about_us.description'))
@section('content')
@if(session('success'))
{{ session('success') }}
@endif

<main class="flex flex-col">
    <div class="headinSet">
        <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">Spécialiste de la location d’espaces et <br> organisateurs d’évènements depuis 2012</h1>
    </div>
    <section class="bodyPages md:px-28 md:py-14">
        <h2>A propos</h2>
        <h3>Notre histoire</h3>
        <div>
            <p>
                Depuis 2012, Easy Réunion propose des salles de réunion à destination des entreprises, associations et organisations. 
                Nous avons fondé notre entreprise sur le principe de l’économie circulaire. En d’autres termes, nous proposons à nos espaces partenaires d’occuper les salles dont ils disposent et d’en assurer la gestion afin d’y organiser des évènements, pour vous ! 
                L’objectif est de permettre à la fois à nos partenaires de valoriser leurs espaces et de vous faire profiter d’un cadre exceptionnel, dans des lieux prestigieux, en plein cœur de Paris pour vos évènements professionnels. 
                L’équipe de Easy Réunion vous propose une organisation clé en main, pour un évènement sur-mesure.
            </p>
            <p>
                Grâce au soutien de l’Académie d’Agriculture de France, les fondateurs d’Easy Réunion ont commercialisé <a href="/espaces/espace-bellechasse">l’espace Bellechasse</a> , premier espace exclusif situé en plein centre de Paris.
                 Aujourd’hui, Easy Réunion propose un large panel de salles à la location, pour la journée ou la demi-journée. Parmi notre sélection d’espaces, nous trouverons, pour vous, la salle qui répondra à vos exigences et mettrons tout en œuvre pour que votre évènement soit mémorable et à la hauteur de vos attentes.
                Afin de donner de la hauteur à votre évènement, nous vous proposons une multitude de services complémentaires qui seront gage de réussite ! Des services de restauration peuvent vous être mis à disposition, du petit-déjeuner, au traiteur, en passant par un maître d’hôtel, nous vous offrons un service de restauration sur-mesure. 
            </p>   
            <p> 
                En outre, nous sommes en mesure de vous mettre à disposition les services d’une hôtesse qui se chargera du vestiaire. Enfin, élément incontournable de la réussite de votre évènement : du matériel technique adapté à vos besoins, géré par des professionnels. Techniciens seront là pour maîtriser les solutions techniques dont vous aurez besoin : <a href="/pages/visio-conference">vidéo projection, streaming, micros…</a> et bien d’autres encore !
            </p>
        </div>
        <h2>Un savoir-faire à la hauteur de vos espérances</h2>
        <div>
            <p>
                Easy Réunion évolue au travers de ses valeurs et objectifs sans cesse renouvelés afin de correspondre au mieux à vos attentes.
                Notre objectif est de valoriser les espaces inexploités de nos partenaires, tout en vous proposant une organisation sur-mesure pour vos évènements. De la gestion commerciale à l’exploitation de nos espaces, nous mettons tout en œuvre pour vous offrir une solution clé en main, en intégrant des services sur-mesure, pensés pour vous. 
                
            </p> 
            <p> 
                Ne laissez rien au hasard en nous confiant l’organisation de vos évènements professionnels.
                Spécialiste de la gestion technique, logistique et commerciale des espaces de réception et de réunion, notre équipe vous oriente et vous guide dans le choix le plus adapté à vos exigences et contraintes organisationnelles. 
                
                Nous nous engageons à construire, avec vous, des prestations flexibles et adaptées à vos besoins
                Construire une relation de confiance avec vous et vous accompagner dans le développement de votre projet, voilà notre objectif.
            </p>
        </div>

    </section>
</main>

@endsection
