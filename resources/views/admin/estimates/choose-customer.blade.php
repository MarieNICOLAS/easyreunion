@extends('layouts.app')

@section('content')
    <div id="create-estimate"></div>
@endsection
@push('end-body')
    <script src="{{ asset('js/create-estimate.js') }}"></script>
@endpush
