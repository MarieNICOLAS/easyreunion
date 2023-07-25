@extends('layouts.email')

@section('content')
    <p>Une nouvelle demande de devis a été effectuée depuis le site !</p>

    <p><strong>Nom :</strong> {{ $name }}</p>
    <p><strong>Entreprise :</strong> {{ $company }}</p>
    <p><strong>Téléphone :</strong> {{ $phone }}</p>
    <p><strong>Email :</strong> {{ $email }}</p>
    <p><strong>Début :</strong> {{ $start }}</p>
    <p><strong>Fin :</strong> {{ $end }}</p>
    <p><strong>Espace / salle :</strong> {{ $space->name }}</p>
    <p><strong>Heure :</strong> {{ $time }}</p>
    <p><strong>Message</strong></p>
    <p>{!! $comment !!}</p>

    <a href="{{ route('admin.estimate-requests.show', $estimateRequest) }}">Cliquez ici pour accéder à la demande</a>

@endsection
