@extends('layouts.email')

@section('content')
    <p>Bonjour {{ $user->name }},</p>

    <p>Un compte vous a été créé sur Easy Réunion !</p>

    <p>Vous pouvez dès à présent vous connecter sur notre site avec le mot de passe {{ $password }}, qu'il vous faudra
        changer dès votre première connexion.</p>

@endsection
