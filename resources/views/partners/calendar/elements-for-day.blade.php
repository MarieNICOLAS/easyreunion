@extends('layouts.app')

@push('head')
    <meta property="date" content="{{ $date }}"/>
    <meta property="agendaId" content="{{ $agendaId }}"/>
@endpush

@section('content')
    <div id="agenda-elements-editor"></div>
@endsection

@push('end-body')
    <script src="{{ asset('js/agenda-elements-editor.js') }}"></script>
@endpush
