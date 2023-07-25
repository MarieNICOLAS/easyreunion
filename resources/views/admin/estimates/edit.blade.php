@extends('layouts.app')

@section('content')
    <input type="hidden" id="estimateId" value="{{ $estimate->id }}"/>
    <div id="estimate-editor"></div>
@endsection
@push('end-body')
    <script src="{{ asset('js/estimate-editor.js') }}"></script>
@endpush
