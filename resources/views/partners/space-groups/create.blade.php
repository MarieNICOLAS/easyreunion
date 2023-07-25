@extends('layouts.app')

@section('content')

    <main>


        <section class="container grid grid-cols-1 space-y-6">

            <h2 class="text-2xl font-extrabold tracking-tight text-current lg:text-4xl text-center">
                Création d'un espace
            </h2>

            <ul role="list" class="space-y-10">
                <li class="bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">
                    <hgroup class="flex flex-col lg:flex-row gap-x-6 gap-y-4 items-start lg:items-end">
                        <h3 class="text-xl font-extrabold tracking-tight text-current lg:text-3xl">
                            Informations générales
                        </h3>
                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Tous les coordonnées permettant d'identifier et de localiser votre espace.
                        </p>
                    </hgroup>
                    <form
                        class="grid grid-cols-1 space-y-3"
                        method="POST" action="{{ route('partner.space-groups.store') }}">
                        @csrf
                            <div
                                class="form-group">
                                <label for="name">
                                    Nom
                                </label>
                                <input type="text" name="name" id="name"

                                       placeholder="Nom de votre espace">
                            </div>

                        <div class="grid grid-cols-2 space-x-6">

                            <div class="grid grid-cols-1">
                                <div
                                    class="form-group"  style="margin-top: 0!important;">
                                    <label for="address">
                                        Adresse
                                    </label>
                                    <input type="text" name="address" id="address"
                                           placeholder="Adresse de l'espace">
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 space-x-3">
                                    <div
                                        class="col-span-1 md:col-span-2 lg:col-span-3 form-group"  style="margin-top: 0!important;">
                                        <label for="city">
                                            Ville
                                        </label>
                                        <input type="text" name="city" id="city"
                                               placeholder="Ville où se situe l'espace">
                                    </div>
                                    <div class="form-group"  style="margin-top: 0!important;">
                                        <label for="zip_code" class="block text-xs font-medium text-gray-900">
                                            Code postal
                                        </label>
                                        <input type="text" name="zip_code" id="zip_code"
                                               placeholder="Code postal">
                                    </div>
                                </div>
                            </div>

                            <aside class="bg-gray-200">
                                <!-- TODO : Ajouter carte -->
                            </aside>

                        </div>
                        <div>
                            <button
                                class="btn success">
                                Créer l'espace
                            </button>
                        </div>
                    </form>
                </li>

                <li class="bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">
                    <hgroup class="flex flex-col lg:flex-row gap-x-6 gap-y-4 items-start lg:items-end">
                        <h3 class="text-xl font-extrabold tracking-tight text-current lg:text-3xl">
                            Présentation
                        </h3>
                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Photos représentant l'espace.
                        </p>
                    </hgroup>
                    <div>
                        <p class="tracking-tight text-gray-500">
                            Soumettez le premier formulaire pour afficher le contenu de cette carte.
                        </p>
                    </div>
                </li>

                <li class="bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">
                    <hgroup class="flex flex-col lg:flex-row gap-x-6 gap-y-4 items-start lg:items-end">
                        <h3 class="text-xl font-extrabold tracking-tight text-current lg:text-3xl">
                            Salles
                        </h3>
                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Toutes les salles présentes dans l'espace.
                        </p>
                    </hgroup>
                    <div>
                        <p class="tracking-tight text-gray-500">
                            Soumettez le premier formulaire pour afficher le contenu de cette carte.
                        </p>
                    </div>
                </li>

            </ul>

        </section>

    </main>

@endsection
