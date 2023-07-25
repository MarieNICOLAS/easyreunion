@extends('layouts.email')

@section('content')
    Un problème est apparu sur la réservation <a
        href="{{ route('admin.bookings.show',$booking) }}">#{{ $booking->id  }}</a>
@endsection
