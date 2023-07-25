<div>
    <section id="contact" class="bg-center bg-cover relative pr-10">

        <div class="w-full md:w-1/2 mx-auto">
            @if(session('success'))
                @include('_partials.alerts.success', ['success' => session('success')])
            @endif
            @if($errors->count() > 0)
                @include('_partials.alerts.errors', ['errors' => $errors->all()])
            @endif
        </div>


        <div class="text-center forMobile">
            <h3 style="margin-top: 30px">Demander un devis</h3>
        </div>


        <h2 class="my-20 text-center dNoneForMobil">
            Contactez-nous pour réserver votre salle ou toute autre demande
        </h2>

        <div class="flex rounded" style="background-color: #E4E4E8">

                <div class="first">
                    <form action="{{ route('contact') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="h-full flex flex-col gap-y-4 justify-center items-center" style="padding: 2%;">
                            <label class="w-4/5">
                                <span class="invisible">Entrez votre nom et prénom</span>
                                <input type="text" name="name" placeholder="Votre nom" class="rounded w-full h-full max-h-8"
                                       value="{{ old('name') }}">
                            </label>
                            <label class="w-4/5">
                                <span class="invisible">Entrez votre adresse mail</span>
                                <input type="email" name="email" placeholder="Votre email" class="rounded w-full h-full max-h-8"
                                       value="{{ old('email') }}">
                            </label>
                            <label class="w-4/5">
                                <span class="invisible">Entrez votre numéro de téléphone</span>
                                <input type="tel" name="phone" placeholder="Votre numéro de téléphone"
                                       value="{{ old('phone') }}"
                                       class="rounded w-full h-full max-h-8">
                            </label>

                            <label class="flex-1 w-4/5">
                                <span class="invisible">Entrez votre demande</span>
                                <textarea class="w-full h-full rounded" placeholder="Votre message à Easy Réunion" rows="8"
                                          name="message">{{ old('message') }}</textarea>
                            </label>
                            <button
                                data-sitekey="{{ config('services.recaptcha.public_key') }}"
                                data-callback='onSubmit'
                                data-action='contact'
                                class="rounded easyBtn g-recaptcha uppercase text-white py-5 px-4 w-4/5 transition"
                            >Envoyer votre message
                            </button>
                        </div>

                    </form>
                </div>

                <div class="second dNoneForMobil">
                    <img src="{{ asset('images/er-image-bg4.webp') }}" alt="Photo Salle du conseil de l'espace chaptal"
                         title="Page d'accueil - Salle du conseil de l'espace chaptal">
                </div>
        </div>
    </section>

</div>
