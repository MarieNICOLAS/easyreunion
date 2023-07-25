@extends('layouts.app-front')

@section('title', 'Nos services techniques pour vos évènements')
@section('meta-description', "Digitalisez vos évènements en y intégrant des solutions techniques adaptées ! Animer vos réunions grâce à nos divers services : vidéo projection, streaming et sonorisation seront à votre disposition.")
@section('canonical', Request::url() )
@push('scripts')
<!-- Balisage JSON-LD généré par l'outil d'aide au balisage de données structurées de Google -->
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Article",
  "name": "Services techniques",
  "image": "https://www.easyreunion.fr/images/bg-pages/er-sonorisation.png",
  "articleSection": "Les outils pour animer votre plénière",
  "articleBody": "L'indispensable qui vous permettra d'animer votre réunion, la vidéo projection est la solution dont vous ne pouvez pas vous passer !",
  "url": "https://www.easyreunion.fr/services-technique"
}
</script>
@endpush
@section('content')

<main class="flex flex-col">
    <div class="headinSet bgImg-tech">
        <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">Services techniques</h1>
    </div>
    <section class="bodyPages md:px-80">
        <h2 class="text-center">Les outils pour animer votre plénière</h2>
        <article>
           
            <h3 class="text-center">Vidéo projection</h3>
            <div class="displayArticle_Page">
                <figure>
                    <img src="{{ asset('images/bg-pages/er-asset-bellechasse.png') }}" alt="Espace-Bellechasse-Auditorium-Paris">
                </figure>
                <p>
                    L'indispensable qui vous permettra d'animer
                    votre réunion, la vidéo projection est la solution
                    dont vous ne pouvez pas vous passer ! 
                </p>
                <p>
                    L'ajout d'un support de présentation donnera du
                    rythme à votre intervention et vous permettra
                    également d'avoir un fil conducteur, tant pour
                    l'orateur que pour les participants de votre évènement.
                </p>
                <p>
                    L'ensemble de nos salles sont équipées d'un vidéo projecteur afin que vous bénéficiez de tout le confort escompté ! 
                </p>
                
                
            </div>           
        </article>
        
        <article>
            <h3 class="text-center">Sonorisation</h3>
            <div class="displayArticle_Page2">    
                    <figure>
                        <img src="{{ asset('images/bg-pages/er-sonorisation.png') }}" alt="Nos dispositifs de sonorisation">
                    </figure>
                <div>
                    <p>
                        Notre service de sonorisation vous permettra
                        d'assurer la clarté de votre message.
                        Incontournable pour vos plénières rassemblant
                        un grand nombre de participants, les micros
                        seront vos alliés.
                    </p>
                    <p>
                        En fonction du format de votre évènement, nous
                        vous proposerons le matériel qui s'adapte au
                        mieux à vos objectifs. Nous pouvons mettre à
                        votre disposition trois types de micros différents,
                        qui ont chacun une utilité bien distincte.
                    </p>
                    <p>
                        Le <span class="font-bold">micro col de cygne</span> conviendra allègrement au format conférence, ainsi que pour une
                        assemblée générale. Il s'agit d'un micro fixe qui sera dédié au intervenants et apportera un
                        aspect solennel à votre discours.
                    </p>
                    <p>
                        Le <span class="font-bold">micro HF</span>, quant à lui, s'adaptera parfaitement à un format plus souple. Il permet la liberté
                        de mouvements de son utilisateur, il pourra ainsi circuler facilement dans la salle et favorisera
                        les moments d'échange entre les intervenants et les participants.
                    </p>
                    <p>
                        Le <span class="font-bold">micro pieuvre</span> est pensé pour le format hybride. Il permet de capter le son de la salle et
                        de le diffuser aux participants en visioconférence. Celui-ci permet également d'émettre le
                        son envoyé par l'ensemble des participants à distance au sein de votre plénière. Cette
                        solution permet de fluidifier les échanges et de combiner différents formats.
                    </p>
                </div>
            </div>  
        </article>
        <article>
            <h3 class="text-center">Éclairage</h3>
            <div class="displayArticle_Page">
                <figure>
                    <img src="{{ asset('images/bg-pages/er-eclairage.png') }}" alt="Éclairage techenique">
                </figure>
                <p>
                    Pour vos évènements prestigieux, notamment si
                    vous optez pour une salle dotée d'une tribune, il
                    sera primordial d'ajuster les éclairages.
                </p>
                <p>
                    Nos techniciens effectueront les ajustements
                    nécessaires pour mettre en valeur les intervenants
                    sur scène. Si vous souhaitez donner une
                    atmosphère particulière au sein de la salle, c'est
                    également l'occasion de leur faire part de votre vision !
                </p>
            </div>           
        </article>
        <article>
            <h3 class="text-center">Interprétariat</h3>
            <div class="displayArticle_Page2">  
                <figure>
                    <img src="{{ asset('images/bg-pages/er-Interprétariat.png') }}" alt="Interprétariat">
                </figure>
                    <p>
                        Dans le cas où certains de vos participants
                        parlent une langue étrangère à celle pratiquée
                        par les intervenants, la présence d'un interprète
                        sera nécessaire, afin de le discours soit à la
                        portée de tous !
                    </p>
                    <p>
                        Pour cela, une cabine de traduction sera mise à
                        disposition de l'interprète que nous vous aurons
                        sélectionné au préalable. Des casques de
                        traduction seront distribués aux participants en
                        question.
                    </p>   
            </div> 
        </article>
        <h2 class="text-center">Nos services pour votre évènements phygital</h2>   
        <article>
            <div class="displayArticle_Page">
                <h3 class="text-center">Visioconférence</h3>
                <figure>
                    <img src="{{ asset('images/bg-pages/er-visioconférence.png') }}" alt="image visioconférence">
                </figure>
                <p>
                    Afin de permettre une certaine flexibilité aux
                    participants de votre réunion, la visioconférence
                    est une solution efficace qui permettra à chacun de
                    pouvoir assister à la réunion, même à distance.
                    Pour la visioconférence, plusieurs options s'offrent
                    à vous ! Vous pouvez opter pour le format
                    classique, c'est-à-dire utiliser la caméra et le
                    micro de votre propre ordinateur.
                </p>
                <p>
                    Cependant, pour le confort de tous, nous vous recommandons de privilégier le matériel
                    adapté à ce format. Une caméra pourra ainsi être mise à votre disposition, qui permettra aux
                    participants en distanciel de profiter d'une vision globale ou de faire un focus sur
                    l'intervenant.
                </p>
                <p>
                    Aussi, l'utilisation de micros vous permettra de capter efficacement les interventions des
                    participants en présentiel, mais également de diffuser le son de manière limpide dans la
                    salle.
                </p>
            </div>
        </article>
        <article>
            <div class="displayArticle_Page2">
                <h3 class="text-center">Streaming</h3>
                <figure>
                    <img src="{{ asset('images/bg-pages/er-streaming.png') }}" alt="image visioconférence">
                </figure>
                <p>
                    Avec le live streaming, votre séminaire sera
                    diffusé en direct sur Internet. Vous allez ainsi
                    permettre au public à distance de se
                    connecter en direct, afin de visionner votre
                    évènement. Il prendra part et vivra
                    l'expérience de votre événement en étant
                    ailleurs.
                </p>
                <p>
                    Cette solution vous offre également la
                    possibilité de visionner votre conférence en
                    différé. Vous disposerez ainsi d'une
                    enregistrement de votre évènement, que
                    vous pourrez partager.
                </p>
                <p>
                La mise en œuvre de cette solution nécessite l'intervention de techniciens qui se chargeront
                d'installer le matériel, d'effectuer les ajustements au niveau de l'orientation de la caméra, du
                réglage des micros et de la lumière.
                </p>
            </div>
        </article>
    </section>
</main>

@endsection