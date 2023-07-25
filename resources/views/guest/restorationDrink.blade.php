@extends('layouts.app-front')

@section('title', 'Nos services de restauration pour vos évènements')
@section('meta-description', " Découvrez le format de restauration idéal ! Easy Réunion vous propose un large panel de menu qui s’adapteront à votre évènement, ainsi qu’à vos convives.")
@section('canonical', Request::url() )
@push('scripts')
<!-- Balisage JSON-LD généré par l'outil d'aide au balisage de données structurées de Google -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Article",
  "name": "Services de restauration",
  "image": "https://www.easyreunion.fr/images/bg-pages/er-viennoiserie.png",
  "articleSection": "Un café, pour bien démarrer la journée !",
  "articleBody": "Nous proposons diverses formules en fonction du format que vous choisirez. Accueillez vos collaborateurs avec des boissons chaudes, ils pourront profiter de notre café en grain biologique et responsable ainsi que d'un thé de qualité. Du jus de fruit local, provenant de la ferme du clos d'Ancoigny, située à Saint Nom la Bretêche, dans le département des Yvelines. Pour un accueil gourmand, optez pour un assortiment de viennoiseries : pains au chocolat, croissants et pains au raisins Rythmez votre journée en ;agrémentant de pauses !",
  "url": "https://www.easyreunion.fr/services-restauration"
}
</script>
@endpush
@section('content')
<main class="flex flex-col">
    <div class="headinSet bgImg-resto">
        <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">Services de restauration</h1>
    </div>
    <section class="bodyPages md:px-80">
            <article>
                <h2 class="text-center">Un café, pour bien démarrer votre réunion !</h2>
                <div class="displayArticle_Page">
                    <figure>
                        <img src="{{ asset('images/bg-pages/er-viennoiserie.png') }}" alt="service viennoiserie">
                    </figure>
                    <p>
                        Pour débuter la journée comme il se doit et ravir vos
                        invités, un petit-déjeuner sera le bienvenue ! Vos
                        participants apprécieront pour sûr cette douce attention à
                        leur égard et pourront ainsi débuter la journée sur une note
                        positive ! 
                    </p>
                </div> 
                <div class="displayArticle_Page2">
                    <figure>
                        <img src="{{ asset('images/bg-pages/cafe-mister_bean.png') }}" alt="le café mister bean">
                    </figure>
                    <p>
                        Nous proposons diverses formules en
                        fonction du format que vous choisirez.
                        Accueillez vos collaborateurs avec des
                        boissons chaudes, ils pourront profiter de
                        notre café en grain biologique et
                        responsable ainsi que d'un thé de qualité.
                        Du jus de fruit local, provenant de la
                        ferme du clos d'Ancoigny, située à <strong> Saint-Nom-la-Bretèche</strong>, dans le département
                        des Yvelines. Pour un accueil gourmand,
                        optez pour un assortiment de
                        viennoiseries : pains au chocolat,
                        croissants et pains au raisins
                    </p>
                    <p>
                        Rythmez votre journée en l'agrémentant de pauses ! Pourront vous être servies à divers
                        moments de la journée des boissons chaudes. L'occasion pour vos participants d'échanger
                        leurs impressions et de décompresser autour d'un bon café ou thé. Cette attention
                        apportera du réconfort à vos collaborateurs et sera au service du bon déroulement de votre
                        évènement.
                    </p>
                </div> 
                <div class="justify-center hidden">
                    <a href="{{ asset('images/dl/PLAQUETTE_PETIT_DEJ_er.pdf') }}" 
                        download="PLAQUETTE_PETIT_DEJ_er"
                        class="btn easyBtn text-whiteF">Télécharger la plaquette petit-déjeuner</a>
                </div> 
            </article>
            <article class="my-32">
                <h2 class="text-center">L'incontournable pause déjeuner pour votre séminaire</h2>
                <h3 class="text-center">Plateaux repas</h3>
                <div class="displayArticle_Page">
                     <figure>
                        <img src="{{ asset('images/bg-pages/er-plateau-repas.png') }}" alt="Plateau repas">
                    </figure>
                    <p>
                        Format idéal pour vos évènement en petit
                        comité, les plateaux repas vous permettront
                        d'optimiser votre pause déjeuner.
                    </p>
                    <p>
                        Préparés à la commande, les plateaux-repas
                        sont cuisinés à partir d’ingrédients frais et de
                        saison. Les plats sont uniques et feront voyager
                        les papilles de vos invités, entre préparations
                        traditionnelles ou plus recherchées.
                    </p>
                </div>   
                <div class="justify-center hidden">
                    <a href="{{ asset('images/dl/MENU_TRAITEUR_EURO_CATRING.pdf') }}" 
                    download="MENU_TRAITEUR_EURO_CATRING.pdf"
                    class="btn easyBtn text-whiteF">Télécharger la plaquette plateaux repas</a>
                </div>  
            </article>
            <article>
                <h3 class="text-center">Cocktail buffet</h3>
                <div class="displayArticle_Page2">
                    <figure>
                        <img src="{{ asset('images/bg-pages/er-buffet.png') }}" alt="Image Cocktail et buffet">
                    </figure>
                    <p>
                        Le format cocktail s'adaptera allègrement à
                        vos évènements d'envergure ! Instaurez une
                        ambiance conviviale et détendue, propice à
                        la rencontre et à l'échange entre vos
                        collaborateurs.
                    </p>
                    <p>
                        A cette occasion, vous montrerez que vous
                        avez à cœur d’assurer le confort de vos
                        invités, ce qui participera à la réussite de
                        votre évènement professionnel.
                    </p>
                    <p>
                        Notre partenaire privilégié propose un vaste choix de formules adaptées à tous les goûts !
                        Concoctés à partir de produits frais et locaux, les mets préparés par notre traiteur sauront
                        satisfaire vos convives.
                    </p>
                </div>
            </article>
            <article>
                <h3 class="text-center">Boissons</h3>
                <div class="displayArticle_Page">
                    <figure>
                        <img src="{{ asset('images/bg-pages/er-buffet2.png') }}" alt="Image Boissons de prestige">
                    </figure>
                    <p>
                        Apportez une touche festive à votre évènement
                        en incluant des boissons symbolisant le prestige.
                        Champagne, vins pourront être servis à vos
                        convives.
                    </p>
                    <p>
                        Diverses boissons pourront vous être également
                        proposées, telles que des sodas, jus de fruits, eau
                        gazeuse ou tout simplement de l'eau plate.
                    </p>
                </div>
            </article>
            <article>
                <div class="displayArticle_Page2">
                    <h2 class="text-center">Du personnel pour vous accompagner pendant votre cocktail</h2>
                    <h3 class="text-center">Maîtres d’hôtel</h3>
                    <figure>
                            <img src="{{ asset('images/bg-pages/er-serveur.png') }}" alt="Image Maîtres d’hôtel">
                    </figure>
                    <p>
                        Lors de l'organisation d'évènements incluant de la
                        restauration, notamment en format cocktail ou buffet
                        la présence d'un maître d'hôtel est requise.
                    </p>
                    <p>
                        Ainsi, vous assurez une réception prestigieuse à vos
                        convives. Expert dans son domaine, le maître d'hôtel
                        mettra son savoir-faire à votre service, pour faire
                        vivre une expérience haut de gamme à vos invités.
                    </p>
                </div>
            </article>
            <article>
                <div class="displayArticle_Page">
                    <h3 class="text-center">Serveurs</h3>
                    <figure>
                            <img src="{{ asset('images/bg-pages/er-serveur2.png') }}" alt="Image Serveurs">
                    </figure>
                    <p>
                        Pour accompagner le maître d'hôtel, des membres
                        de notre équipe assureront le service lors de votre
                        évènement.
                    </p>
                    <p>
                        Soutien indispensable, gage de la réussite de votre
                        réception, nos serveurs sauront rendre cet instant
                        mémorable. Afin de fluidifier ce moment de
                        convivialité, nos serveurs seront vos alliés.
                    </p>
                </div>
            </article>
    </section>
</main>
@endsection