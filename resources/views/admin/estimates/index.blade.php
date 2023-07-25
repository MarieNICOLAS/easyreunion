@extends('layouts.app')

@section('content')
    <div id="estimates"></div>
@endsection
@push('end-body')
    <script src="{{ asset('js/estimates.js') }}"></script>
@endpush
