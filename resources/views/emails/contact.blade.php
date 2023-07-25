@extends('layouts.email')

@section('content')

{{ $name }} a envoyé un message :

{{ $comment }}

Pour lui répondre {{ $name }} - {{ $email }} - {{ $phone }}

@endsection
