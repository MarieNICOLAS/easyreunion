@extends('layouts.app')

@section('content')
    <div id="bookings"></div>
@endsection
@push('end-body')
    <script src="{{ asset('js/bookings.js') }}"></script>
@endpush
