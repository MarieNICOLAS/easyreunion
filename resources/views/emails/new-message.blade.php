@extends('layouts.email')

@section('content')
    <p>Bonjour !</p>

    <p>Un nouveau message vous a été envoyé. Vous pouvez le visualiser et y répondre sur <a
            href="{{ route('messaging.index') }}">la messagerie du site</a>.</p>

    <p>Cordialement</p>
@endsection
