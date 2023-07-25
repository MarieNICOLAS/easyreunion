@extends('layouts.app')

@section('content')
    <h2>Mes réservations futures</h2>

    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">

        @forelse(Auth::user()->bookings()->future()->get() as $booking)
            <div class="group relative">
                <div
                    class="w-full h-56 bg-gray-200 rounded-md overflow-hidden group-hover:opacity-75 ">
                    <img src="{{ asset('images/er-image-bg.jpg') }}"
                         class="w-full h-full object-center object-cover">
                </div>
                <h3 class="mt-4 text-sm text-gray-700">
                    <a href="{{ route('user.bookings.show', $booking) }}">
                        <span class="absolute inset-0"></span>
                        Réservation pour le {{ $booking->starts_at }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">Mise à jour le {{ $booking->updated_at }}</p>
            </div>
        @empty
            <p>Aucune réservation en cours</p>
        @endforelse
    </div>

    <hr/>
    <h2>Mes réservations passées</h2>
    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">

        @forelse(Auth::user()->bookings()->past()->get() as $booking)
            <div class="group relative">
                <div
                    class="w-full h-56 bg-gray-200 rounded-md overflow-hidden group-hover:opacity-75 lg:h-72 xl:h-80">
                    <img src="{{ asset('images/er-image-bg.jpg') }}"
                         class="w-full h-full object-center object-cover">
                </div>
                <h3 class="mt-4 text-sm text-gray-700">
                    <a href="{{ route('user.bookings.show', $booking) }}">
                        <span class="absolute inset-0"></span>
                        Réservation du {{ $booking->starts_at }}
                    </a>
                </h3>
                <p class="mt-1 text-sm text-gray-500">Mise à jour le {{ $booking->updated_at }}</p>
            </div>
        @empty
            <p>Aucune réservation passée</p>
        @endforelse
    </div>
@endsection
