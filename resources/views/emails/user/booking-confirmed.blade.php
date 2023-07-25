@extends('layouts.email')

@section('content')
    <p>Bonjour,</p>
    <p>Nous vous informons que votre réservation du <strong>{{ $booking->starts_at->format('d/m/Y') }}</strong> a
        bien été confirmée.
    </p>

    <ul>
        @foreach($booking->agendaElements as $element)
            <li>
                Le {{ $element->start->format('d/m/Y') . ' de ' . $element->start->format('H:i') . ' à ' .$element->end->format('H:i') }}
                :
                {{ $element->space->spaceGroup->name }}, {{ $element->space->name }}</li>
        @endforeach
    </ul>

    <p>Notre équipe demeure à votre entière disposition pour tout complément d’information.</p>
@endsection
