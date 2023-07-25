@extends('layouts.email')

@section('content')
    <p>Bonjour,</p>
    <p>Un évènement auquel vous participez commencera demain !</p>
    <p>Cet évènement est organisé par {{ $booking->user?->organization?->name ?? $booking->user->name }}.
    </p>

    <table>
        <thead>
        <tr>
            <th>Salle</th>
            <th>Début</th>
            <th>Fin</th>
        </tr>
        </thead>
        <tbody>
        @foreach($booking->agendaElements as $element)
            <tr>
                <td>{{ $element->agenda->space->name }}</td>
                <td>{{ $element->start }}</td>
                <td>{{ $element->end }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p>Retrouvez toutes les informations sur votre espace partenaire <a
            href="{{ route('partner.bookings.show', $booking) }}">en cliquant ici !</a></p>
@endsection
