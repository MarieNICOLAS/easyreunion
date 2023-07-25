@extends('layouts.email')

@section('content')
    <h2>Votre récap de la semaine</h2>

    <p>Merci de confirmer que votre planning est à jour toutes les semaines ! Votre planning est automatiquement
        désactivé
        12 jours après la dernière confirmation en cas d'absence de nouvelle confirmation. Rendez-vous sur les pages de
        vos agendas <a href="{{ route('partner.agenda.index') }}">en cliquant ici</a></p>

    <h3>Réservations non confirmées</h3>
    <ul>
        @foreach($partner->bookings()->future()->wherePivot('status', 'unconfirmed')->get() as $booking)
            <li><a href="{{ route('partner.bookings.show', $booking) }}">Réservation
                    de {{ $booking->estimate->billing_address->customer_name }}</a></li>
        @endforeach
    </ul>

    <h3>Réservations pour la semaine à venir</h3>
    <ul>
        @foreach($partner->bookings()->future()->where('starts_at', '<=', \Carbon\Carbon::now()->addWeek())->get() as $booking)
            <li><a href="{{ route('partner.bookings.show', $booking) }}">Réservation
                    de {{ $booking->estimate->billing_address->customer_name }}</a></li>
        @endforeach
    </ul>

@endsection
