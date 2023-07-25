@extends('layouts.app')

@section('content')
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900 text-center">
            Statistiques générales
        </h3>

        <dl class="mt-5 grid grid-cols-1 gap-5 ">
            <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden mx-auto">
                <dt>
                    <div class="absolute bg-blue rounded-md p-3">
                        <!-- Heroicon name: outline/users -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <p class="ml-16 text-sm font-medium text-gray-500 truncate">Nombre de réservations sur un mois</p>
                </dt>
                <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">
                        {{ $selectedPartner->bookings()->whereDate('bookings.created_at','<=', \Carbon\Carbon::now()->subMonth())->count() }}
                    </p>

                    <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('partner.bookings.index') }}"
                               class="font-medium text-blue hover:text">Aller à la page
                                réservations</a>
                        </div>
                    </div>
                </dd>
            </div>

        </dl>
    </div>

    <div class="flex mt-6 justify-between flex-col md:flex-row">
        <div class="flex flex-col w-full md:w-1/2 pr-3 ">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                Réservations prochaines
            </h3>
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateur
                                <th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date de début de la prestation
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant total
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse($selectedPartner->bookings()->future()->limit(3)->get() as $booking)
                                <tr class="{{ $loop->even ? 'bg-white' : 'bg-gray-50'  }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('partner.bookings.show', $booking ) }}">{{ $booking->user->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $booking->starts_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $booking->amount_total }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun problème actuellement</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-col w-full md:w-1/2 pl-3">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                Commandes dernières 48h
            </h3>
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date de début de la prestation
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Montant total
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($selectedPartner->bookings()->whereDate('bookings.created_at', '>=', \Carbon\Carbon::now()->subDays(2))->get() as $booking)
                                <tr class="{{ $loop->even ? 'bg-white' : 'bg-gray-50'  }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('partner.bookings.show', $booking ) }}">{{ $booking->user->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $booking->starts_at }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $booking->amount_total }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucune commande dans les dernières 48h</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
