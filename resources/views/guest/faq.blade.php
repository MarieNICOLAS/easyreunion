@extends('layouts.app-front')

@section('title', 'foire aux questions - location de salle pour vos événements')
@section('meta-description', "Découvrez les réponses à toutes vos questions sur la location de salle sur notre page FAQ.
 Nous avons rassemblé les informations les plus utiles pour vous aider à trouver la salle parfaite pour votre événement.")
@section('canonical', Request::url() )
@push('scripts')
<!-- FAQPage, Question, Answer structured data -->
<script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "FAQPage",
        "mainEntity": [{
          "@type": "Question",
          "name": "Comment puis-je réserver une salle ?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Pour réserver une salle, vous devez prendre contact avec notre service commercial.
                      Nous vous invitons à parcourir notre catalogue de salles afin de sélectionner la salle
                      qui s'adapte au mieux à l'évènement que vous souhaitez organiser. Veillez à vérifier que
                      la salle en question dispose des services souhaités. Dès lors que vous avez trouvé la
                      salle idéale, cliquez sur le bouton 'Demander un devis', puis remplissez le formulaire.
                      Notre équipe commerciale vous contactera dans les plus brefs délais pour finaliser votre
                      réservation.</p>"
          }
        }, {
          "@type": "Question",
          "name": "Quels types de salles proposez vous ?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Nous proposons une grande variété de salles pour les entreprises à Paris, allant des salles de réunion et de conférence aux salles de formation et de coworking. Nous avons également des salles pour des événements d'entreprise tels que des soirées de gala, des cocktails, des lancements de produits, des célébrations de fin d'année, etc.</p>"
          }
        }, {
          "@type": "Question",
          "name": "Quels sont les équipements inclus dans ma réservation ?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Lorsque vous effectuez une réservation de salle, certains équipements sont inclus. La
                        connexion Wi-Fi, la mise à disposition de paperboard, d'une télécommande pour vos
                        présentations et le mobilier présent initialement dans la salle sont compris dans le
                        devis. Si vous souhaitez ajouter des équipements et services supplémentaires, ceux-ci
                        seront ajoutés.</p>"
          }
        }]
      }
</script>
@endpush

@section('content')
<main>
    <div class="headinSet bgImg-tech">
            <h1 class="mx-auto text-[6vw] leading-none sm:text-5xl">FAQ - Questions fréquentes</h1>
    </div>
    <section class="bodyPages md:px-28 FAQ_set">
        
        <div class="container-faq mt-11">
            <div class="question">
                <div class="visible-pannel">
                    <h2>Comment puis-je réserver une salle ?</h2>
                
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                
                    
                </div>
                <div class="toggle-pannel">
                    <p>Pour réserver une salle, vous devez prendre contact avec notre service commercial.
                        Nous vous invitons à parcourir notre <a href="/location-salle">catalogue des salles</a> afin de sélectionner la salle
                        qui s'adapte au mieux à l'évènement que vous souhaitez organiser. Veillez à vérifier que
                        la salle en question dispose des <a href="/services-technique">services </a> souhaités. Dès lors que vous avez trouvé la
                        salle idéale, cliquez sur le bouton <a href="/request-quote?space=amphitheatre-chaptal">"Demander un devis"</a> , puis remplissez le formulaire.
                        Notre équipe commerciale vous contactera dans les plus brefs délais pour finaliser votre
                        réservation.</p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2 class="leading-10">Quels types d'événements puis-je organiser avec Easy Réunion ?</h2>
                
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                 
                </div>
                <div class="toggle-pannel">
                    <p>Nous proposons des salles destinées à recevoir tous types d'évènements
                        professionnels. Easy Réunion est en mesure de vous mettre à disposition des salles
                        pouvant accueillir jusqu'à 200 participants pour vos <a href="/pages/réunion">réunions,</a> <a href="/pages/formation">formations,</a> <a href="/pages/seminaire">seminaire,</a> 
                        <a href="/pages/conference">conférences</a> et <a href="/pages/assemblee">assemblées générales</a>. <a href="/pages/cocktail-banquet-gala-restauration">Cocktails déjeunatoires, banquets et galas</a> 
                        sont également organisés au sein de nos espaces. Nous organisons également vos
                        évènements digitaux, nous mettons à votre disposition, selon vos besoins, un panel de
                        <a href="/services-technique">services techniques</a> sur-mesure.</p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2>Quels sont les équipements inclus dans ma réservation ?</h2>
                
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                
                </div>
                <div class="toggle-pannel">
                    <p>Lorsque vous effectuez une réservation de salle, certains équipements sont inclus. La
                        connexion Wi-Fi, la mise à disposition de paperboard, d'une télécommande pour vos
                        présentations et le mobilier présent initialement dans la salle sont compris dans le
                        devis. Si vous souhaitez ajouter des équipements et <a href="/services-technique">services</a> supplémentaires, ceux-ci
                        seront ajoutés.</p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2>Comment puis-je modifier ma réservation ?</h2>
                
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                
                </div>
                <div class="toggle-pannel">
                    <p>Si vous souhaitez apporter des modifications à votre réservation, nous vous invitons à
                        contacter directement le service commercial par mail ou par téléphone. Veuillez noter
                        que des frais de modification peuvent être appliqués, notamment dans le cadre d'une
                        réservation incluant une prestation de restauration, conformément à l'article 6 des
                        CGV. En cas d'annulation, vous demeurez redevable de tout ou partie du devis,
                        conformément à <a href="/pages/cgv">l'article 3 des CGV.</a></p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2>Quelles méthodes de paiement sont acceptées ?</h2>
                
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                
                </div>
                <div class="toggle-pannel">
                    <p>Nous acceptons les paiements uniquement par virement bancaire. Découvrez les détails
                        relatifs au règlement de votre facture en consultant <a href="/pages/cgv">l'article 5 des CGV.</a></p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2 class="leading-10">Est-il possible de réserver une salle en dehors des horaires indiqués ?</h2>
                
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                
                </div>
                <div class="toggle-pannel">
                    <p>Oui, nous accueillons vos évènements professionnels en dehors des horaires indiqués
                        dans le formulaire de <strong>demande de devis.</strong> Nous vous invitons à <a href="/contactez-nous">contacter</a> notre service
                        commercial pour obtenir plus d'informations à ce sujet.</p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2>Puis-je louer une salle pour une demi journée ?</h2>
                
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                
                </div>
                <div class="toggle-pannel">
                    <p>Oui, la location de salle est disponible à la journée ou à la demi journée. Les horaires
                        pour la journée entière sont de <strong>8h30 à 18h</strong>. Pour la demi journée, vous pouvez
                        programmer votre évènement en matinée, de <strong>8h30 à 12h30</strong>, ou bien en après-midi, de
                        13h30 à 18h.</p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2>Les salles de réunion sont-elles accessibles aux personnes à mobilité réduite ?</h2>
                    
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                
                </div>
                <div class="toggle-pannel">
                    <p>Oui, nous proposons des salles accessibles aux personnes à mobilité réduite. Easy
                        Réunion s'efforce à vous proposer un maximum d'espaces disposant d'accès facilitant
                        l'accès à ces personnes. Nous vous invitons à <a href="/contactez-nous">contacter</a> notre service commercial pour
                        plus d'informations à ce sujet.</p>
                </div>
            </div>

            <div class="question">
                <div class="visible-pannel">
                    <h2>Comment se déroule un événement ?</h2>
                    
                        <img src="{{ asset('images/tags/plus-svgrepo-com.svg') }}" alt="icone plus"/>
                    
                </div>
                <div class="toggle-pannel">
                    <p>Easy Réunion se charge de toute la partie organisationnelle, ainsi que de la logistique
                        de votre évènement. Un régisseur se chargera de l'accueil et de la mise en place des
                        divers aménagements et services prévus. Celui-ci sera également présent pour vous
                        accompagner tout au long de la journée et coordonner les différentes prestations
                        (technique, restauration, vestiaire). Découvrez en détails le déroulement d'un
                        évènement type dans cet <a href="/article/cle-organiser-formation">article.</a></p>
                </div>
            </div>

        </div>
    </section>
</main>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
<script src="{{ asset('js/pannelFAQ.js') }}"></script>
@endpush