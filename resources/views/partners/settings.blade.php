@extends('layouts.app')

@section('content')
    <h1>Paramètres du compte partenaire</h1>

    @foreach($errors->all() as $error)
        <li>
            {{ $error }}
        </li>
    @endforeach
    <form method="POST" action="{{ route('partner.settings.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label for="company">Nom de l'entreprise</label>
            <input required type="text" name="company" value="{{ old('company') ?? $selectedPartner->company }}"/>
        </div>

        <div>
            <label for="email">Email de contact</label>
            <input required type="email" name="email" value="{{ old('email') ?? $selectedPartner->email }}"/>
        </div>

        <div>
            <label for="phone">Téléphone</label>
            <input required type="text" name="phone" value="{{ old('phone') ?? $selectedPartner->phone }}"/>
        </div>

        <div>
            <label for="website">Site internet</label>
            <input required type="text" name="website" value="{{ old('website') ?? $selectedPartner->website }}"/>
        </div>

        <div>
            <label for="iban">IBAN</label>
            <input required type="text" name="iban" value="{{ old('iban') ?? $selectedPartner->iban }}"/>
        </div>

        <input type="submit" value="update" class="btn success"/>
    </form>
@endsection
