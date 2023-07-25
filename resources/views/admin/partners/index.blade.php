@extends('layouts.app')

@section('content')
    <div id="partners-index"></div>
@endsection
@push('end-body')
    <script src="{{ asset('js/partners-index.js') }}"></script>
@endpush
