@extends('layouts.app')

@section('content')
    <div id="calendar"></div>
@endsection

@push('end-body')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush
