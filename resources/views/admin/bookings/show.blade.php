@extends('layouts.app')

@section('content')
    <input type="hidden" id="bookingId" value="{{ $booking->id }}"/>
    <div id="booking-editor"></div>
@endsection
@push('end-body')
    <script src="{{ asset('js/booking-editor.js') }}"></script>
@endpush
