@extends('layouts.app')

@section('content')
    <div class=" mx-10 leading-10">

        @if(Auth::user()->partners()->exists())
            <p>Votre demande est en cours de validation</p>
        @else
            <p>
                Bonjour ! <br/>
                Nous sommes très heureux de vous compter prochainement parmi nos partenaires. <br/>
                Merci de remplir ce formulaire. Une fois rempli, il sera examiné par l'équipe d'Easy Réunion. <br/>
                Dès que votre demande sera validée, vous pourrez commencer à remplir vos disponibilités sur la
                plateforme !
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('become-a-partner.add', 'annuaire') }}" method="post"
                  class="lg:w1/6 md:w-1/2 sm:w-full">
                @csrf

                <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">

                    <!-- Type de presta -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Type de prestation
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="type" name="type"
                                    class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                <option value="spaceowner">Propriétaire de salles</option>
                                <option value="traiteur">Traiteur</option>
                                <option value="dj">DJ</option>
                                <option value="agent">Agent d'entretien</option>
                            </select>
                        </div>
                    </div>

                    <!-- Nom de l'entreprise -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="company" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Nom de l'entreprise
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" name="company" id="company"
                                   class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md"
                                   placeholder="My company">
                        </div>
                    </div>
                    <!-- Nom du contact -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Nom du contact
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" name="name" id="name"
                                   class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md"
                                   placeholder="John Doe">
                        </div>
                    </div>
                    <!-- Email du contact -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Email du contact
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="email" name="email" id="email"
                                   class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md"
                                   placeholder="email@example.com">
                        </div>
                    </div>
                    <!-- Phone du contact -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="phone" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Numéro de contact
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <input type="text" name="phone" id="phone"
                                   class="max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md"
                                   placeholder="01 23 45 67 89">
                        </div>
                    </div>
                    <!-- Company website -->
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="website" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Company Website
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="mt-1 flex rounded-md shadow-sm">
                    <span
                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                        https://
                    </span>
                                <input type="text" name="website" id="website"
                                       class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300"
                                       placeholder="www.easy-reunion.com">
                            </div>
                        </div>
                    </div>

                    <!-- Champ libre -->
                </div>

                <div class="pt-5">
                    <button type="submit"
                            class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Envoyer
                    </button>
                </div>
            </form>
    </div>
    @endif
@endsection
