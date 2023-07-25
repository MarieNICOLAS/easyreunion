<footer>
    <div class="w-full px-6 md:px-24 py-8 bg-gray-200 grid grid-cols-1 md:grid-cols-4 gap-x-12 gap-y-8">
        <div>
            <h3 class="text-2xl font-semibold mb-3">À propos</h3>
            <p class="opacity-70">L'équipe d'Easy Réunion, spécialiste de la location de salle, organise vos réunions,
                séminaires & cocktails, trouve une salle adaptée à vos besoins et à votre budget, et cela dans les
                meilleurs
                délais.
                <br/>
            </p>
        </div>

        <div>
            <h3 class="text-2xl font-semibold mb-3">Easy Réunion</h3>

            <p>
                <a href="/qui-sommes-nous" title="Découvrez Easy-Réunion"><span class="font-bold easyDarkBlue2 hover:text-black">Qui sommes-nous ?</span></a>
            </p>

            <p>
                <a href="/vos-temoignages" title="Votre avis sur nos services"><span class="font-bold easyDarkBlue2 hover:text-black">Vos témoignages</span></a>
            </p>
            <p>
                <a href="/jobs" title="Offres d'emploi"><span class="font-bold easyDarkBlue2 hover:text-black">Nous recrutons</span></a>
            </p>

            <p>
                <a href="/pages/faq" title="Foire aux questions "><span class="font-bold easyDarkBlue2 hover:text-black">FAQ</span></a>
            </p>
        </div>


        <div>
            <h3 class="text-2xl font-semibold mb-3">Nous contacter</h3>
            <p class="opacity-70">
                Propriétaire : Vatel Event<br>
                8 rue d'Angoulême - 78000 Versailles<br>
                Tél: +33 1 79 72 33 03<br>
                Email : contact@easyreunion.fr<br/>
                
            </p>
            <a class="hover:text-black" href="/contactez-nous" title="Easy Réunion est là pour vos évènements">
                    <span class="font-bold easyDarkBlue2 hover:text-black">Contactez-nous</span>
            </a>
        </div>



        <div>
            <h3 class="text-2xl font-semibold mb-3">Liens utiles</h3>

            <p>
                <a href="{{ route('auth.login-page') }}"
                   class="hover:text-black" title="Connexion">
                    <span class="font-bold easyDarkBlue2 hover:text-black">Connexion</span>
                </a>
            </p>

            <p>
                <a href="{{ route('articles.list') }}"
                class="hover:text-black" title="Conseils et astuces pour organiser votre événement">
                    <span class="font-bold easyDarkBlue2 hover:text-black">Notre blog</span>
                </a>
            </p>
            <p>
                <a class="hover:text-black" href="{{ route('sitemap_page') }}" title="Naviguez facilement!"><span class="font-bold easyDarkBlue2 hover:text-black">Plan du site</span></a>
            </p>
            <p>
                <a class="hover:text-black" href="{{ route('page.show', 'mentions-legales') }}" title="Tous les détails sur nos services"><span class="font-bold easyDarkBlue2 hover:text-black">Mentions légales</span></a>
                -
                <a class="hover:text-black" href="{{ route('page.show', 'cgv') }}" title="Easy-Réunion - Conditions générales de vente"><span class="font-bold easyDarkBlue2 hover:text-black">CGV</span></a>
            </p>
            <p>
                <a class="hover:text-black" href="/notre-equipe" title="Qui se cache derrière vos évènements ?"><span class="font-bold easyDarkBlue2 hover:text-black">Notre équipe</span></a>
            </p>
        </div>
    </div>

    <div class="flex flex-wrap w-full px-6 md:px-24 py-8 bg-blue-dark text-white justify-between items-center">
        <div>
            Réservations directement sur le <a class="font-bold" href="/#contact">site</a>, par <a href="mailto:contact@easyreunion.fr"
                                                         class="font-bold">mail</a>
            ou
            <a href="tel:+33179723303" class="inline-block bg-white bg-opacity-10 rounded-2xl px-3 py-2 ml-1"><span class="font-bold">+33 1 79
                72 33
                03 </span></a>
        </div>
        <div>
        Tous droits réservés Vatel Event © - 2023
        </div>
    </div>
</footer>
