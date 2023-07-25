@extends('layouts.email')

@section('content')
    <p>Bonjour,</p>
    <p>Nous vous informons que la réservation du <strong>{{ $booking->starts_at->format('d/m/y') }}</strong> de
        <strong>{{ $booking->customerCompanyName() }}</strong> a été annulée :
    </p>
    <ul>
        @foreach($booking->agendaElements as $element)
            <li>
                Le {{ $element->start->format('d/m/Y') . ' de ' . $element->start->format('H:i') . ' à ' .$element->end->format('H:i') }}
                :
                {{ $element->space->spaceGroup->name }}, {{ $element->space->name }}</li>
        @endforeach
    </ul>

    <p>Le créneau qu'elle occupait est donc libre.</p>
@endsection
