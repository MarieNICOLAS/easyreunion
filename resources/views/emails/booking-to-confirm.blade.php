@extends('layouts.email')

@section('content')
    <p>Bonjour,</p>

    <p>Une nouvelle commande de vos service vient d'être passée !</p>

    <p>Vous pouvez la visualiser et la confirmer <a href="{{ route('partner.bookings.show', $booking) }}">en cliquant ici</a></p>
@endsection
