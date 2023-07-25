@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">

        <main class="py-10">
            <!-- Page header -->
            <div
                class="max-w-3xl mx-auto px-4 sm:px-6 md:flex md:items-center md:justify-between md:space-x-5 lg:max-w-7xl lg:px-8">
                <div class="flex items-center space-x-5">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $partner->name }}</h1>
                        <p class="text-sm font-medium text-gray-500">Compte créé le {{ $partner->created_at }}</p>
                    </div>
                </div>
                <div
                    class="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">

                    @if(!$partner->is_validated)
                        <a class="btn success h-in"
                           href="{{ route('admin.partners.requests.approve', $partner) }}">Accepter la demande</a>
                        <a class="btn dark h-in"
                           href="{{ route('admin.partners.requests.delete', $partner) }}">Supprimer la demande</a>
                    @else
                        <a class="btn dark h-in"
                           href="{{ route('admin.partners.delete', $partner) }}">Désactiver le partenaire</a>
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
                                    Détails du partenaire
                                </h2>
                            </div>
                            <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                                <dl class="grid grid-cols-1 gap-x-2 gap-y-8 sm:grid-cols-3">
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Plan
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $partner->plan }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Type
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $partner->type }}
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-1">
                                        <dt class="text-sm font-bold font-medium text-gray-500">
                                            Taux
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ $partner->commission }}%
                                        </dd>
                                    </div>

                                </dl>
                            </div>
                        </div>
                    </section>

                    <section aria-labelledby="notes-title">
                        <div class="bg-white shadow sm:rounded-lg sm:overflow-hidden">
                            <div class="divide-y divide-gray-200">
                                <div class="px-4 py-5 sm:px-6">
                                    <h2 id="notes-title" class="text-lg font-medium text-gray-900">Commandes</h2>
                                </div>
                                <div class="px-4 py-6 sm:px-6">
                                    <table>
                                        <tbody>
                                        @forelse($partner->bookings as $booking)
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

                <section aria-labelledby="timeline-title" class="lg:col-start-3 lg:col-span-1">


                    <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6 ">
                        <h2 id="timeline-title" class="text-lg font-medium text-gray-900">Liste des
                            utilisateurs</h2>
                        <ul>
                            @foreach($partner->users as $user)
                                <li>{{ $user->name }}</li>
                            @endforeach
                        </ul>
                        <hr class="my-1"/>
                        <p>Ajouter un admin</p>
                        <form method="POST" action="{{ route('admin.partners.users.add', $partner) }}">
                            @csrf
                            <select name="admin">
                                @foreach(\App\Models\User::getAdmins() as $admin)
                                    <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                                @endforeach
                            </select>
                            <input class="btn success mx-2 h-in mt-5" type="submit" value="Ajouter">
                        </form>

                        <p class="mt-6">Ajouter un utilisateur</p>
                        <form method="POST" action="{{ route('admin.partners.users.add', $partner) }}">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"/>
                            </div>
                            <div class="form-group">
                                <label>Prénom</label>
                                <input type="text" name="first_name"/>
                            </div>
                            <div class="form-group">
                                <label>Nom</label>
                                <input type="text" name="last_name"/>
                            </div>
                            <input class="btn success h-in mt-2" type="submit" value="Ajouter">
                        </form>
                    </div>

                </section>


            </div>
        </main>
    </div>

@endsection
