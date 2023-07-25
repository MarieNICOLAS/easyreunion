@extends('layouts.app')

@section('content')
    <div class="bg-white md:w-1/2 mx-auto px-6 py-6">
        <h2>Créer un espace</h2>

        <section class="container grid grid-cols-1 space-y-6">
            Ajouter un espace pour le groupe {{ $space_group->name }}
        </section>

        <form action="{{ route('partner.space-groups.space.create', $space_group) }}" method="post">
            @csrf

            <div class="form-group">
                <label for="name">Nom de l'espace</label>
                <input type="text" name="name"/>
            </div>
            <div class="form-group">
                <label for="capacity_max">Capacité</label>
                <input type="number" name="capacity_max" min="1"/>
            </div>
            <div class="form-group">
                <label for="area">Surface (m²)</label>
                <input type="number" name="area"/>
            </div>

            <button type="submit"
                    class="btn success h-in"
                    aria-expanded="false"> Créer
            </button>
        </form>
    </div>
@endsection
