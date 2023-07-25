@extends('layouts.email')

@section('content')
    Votre évènement approche.  <a
        href="{{ route('user.bookings.show', $booking) }}">Rendez-vous sur la page de réservation pour confirmer le
        nombre de participants et payer le restant dû !</a>

@endsection
