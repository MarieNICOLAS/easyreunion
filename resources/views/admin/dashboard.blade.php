@extends('layouts.app')

@section('content')
    <div id="dashboard"></div>
@endsection

@push('end-body')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
