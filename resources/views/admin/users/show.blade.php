@extends('layouts.app')

@section('content')

    <div class="min-h-screen bg-gray-100">


        <main class="py-10">
            <!-- Page header -->
            @if($user->active == 0)
                <div class="bg-red w-full text-center text-white text-2xl">
                    COMPTE DESACTIVE
                </div>
            @endif



            <div
                class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        <div class="relative">
                            <img class="h-16 w-16 rounded-full" src="{{ asset('storage/users/'. $user->avatar) }}">
                            <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <p class="text-sm font-medium text-gray-500">Compte créé le {{ $user->created_at }}</p>
                    </div>
                </div>
                <div
                    class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
                    <a href="{{ route('admin.users.hijack', $user) }}" type="button"
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                        Hijack
                    </a>
                    @if($user->rank === "admin")
                        <a href="{{ route('admin.team.remove', $user) }}" type="button"
                           class="btn dark h-in">
                            Enlever rôle admin
                        </a>
                    @else
                        @if($user->active == 0)
                            <a href="{{ route('admin.team.active', $user) }}" type="button"
                               class="btn success h-in">
                                Activer
                            </a>
                        @else
                            <a href="{{ route('admin.team.desactive', $user) }}" type="button"
                               class="btn danger h-in">
                                Désactiver
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            <div
                class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl lg:grid-flow-col-dense lg:grid-cols-3">
                <div class="space-y-6 lg:col-start-1 lg:col-span-2">
                    <!-- Description list-->
                    <section aria-labelledby="applicant-information-title">
                        <div class="bg-white shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <h2 id="applicant-information-title"
                                    class="text-lg leading-6 font-medium text-gray-900">
                                    Détails du client
                                </h2>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-2 gap-y-8 sm:grid-cols-3">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Prénom
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $user->first_name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Nom
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $user->last_name }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Email
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $user->email }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Montant total commandé
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $user->bookings->sum('amount_total') }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Nombre de commandes
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $user->bookings->count() }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Dernière connexion
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $user->last_login }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </section>
<!
                    <section aria-labelledby="notes-title">
                        <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
                            <div class="divide-y divide-gray-200">
                                <div class="px-4 py-5 sm:px-6">
                                    <h2 id="notes-title" class="text-lg font-medium text-gray-900">Commandes</h2>
                                </div>
                                <div class="px-4 py-6 sm:px-6">
                                    <table>
                                        <tbody>
                                        @forelse($user->bookings as $booking)
                                            <tr>
                                                <td><a href="{{ route('admin.bookings.show', $booking) }}">Commande
                                                        du {{ $booking->created_at  }}</a></td>
                                            </tr>
                                        @empty
                                            Pas encore de commande
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
<!--
                <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">


                    @if($user->partners()->exists())
                        <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6 mt-6">
                            <h2 id="timeline-title" class="text-lg font-medium text-gray-900">Comptes partenaires
                                associés</h2>

                            <div class="mt-6 flow-root">
                                <table>
                                    <tbody>
                                    @foreach($user->partners as $partner)
                                        <li>{{ $partner->name }}</li>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </section>-->


            </div>
            <div>
                @if($user->active == 0)
                    <a href="{{ route('admin.team.suppressed', $user) }}" type="button"
                       class="btn danger w-full text-center text-white text-4xl">
                        SUPPRIMER DEFINITIVEMENT
                    </a>
                @endif
            </div>
        </main>
    </div>

@endsection
