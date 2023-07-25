@extends('layouts.app')

@section('content')

    <h1>Liste des utilisateurs ayant accès au compte partenaire</h1>

    <table>
        <thead>
        <tr>
            <th>Nom</th>
            <th>Membre depuis</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($teamMembers as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->created_at }}</td>
                <td>@if($user->id !== Auth::user()->id)
                        <a
                            href="{{ route('partner.team.remove', $user) }}">Supprimer</a>
                    @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2 class="mt-8">Ajouter un utilisateur</h2>
    @if(count($errors) > 0)
        @include('_partials.alerts.errors', ['errors' => $errors->all()])
    @endif
    <form class="w-full md:w-1/2 " method="POST" action="{{ route('partner.team.invite') }}">
        @csrf

        <div class="form-group">
            <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
            <input name="first_name" type="text" value="{{ old('first_name') }}"/>
        </div>

        <div class="form-group">
            <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input name="last_name" type="text" value="{{ old('last_name') }}"/>
        </div>

        <div class="form-group">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input name="email" type="email" value="{{ old('email') }}"/>
        </div>


        <input class="btn success mx-2 my-2  h-in" type="submit" value="Inviter"/>
    </form>

@endsection
