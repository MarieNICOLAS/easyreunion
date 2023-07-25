@extends('layouts.app')

@section('content')
    <div class="bg-white shadow overflow-hidden sm:rounded-lg md:w-2/3 mx-auto">
        <div class="px-4 py-5 sm:px-6">
            @if($request->estimate)
                <div class="float-right">
                    <a class="btn success mx-2 h-in" href="{{ route('admin.estimates.edit', $request->estimate) }}">Accéder
                        au devis</a>
                </div>
            @elseif($request->status !== 'converted')
                <div class="float-right">
                    <a class="btn success mx-2 h-in" href="{{ route('admin.estimate-requests.create-estimate', $request) }}">Créer
                        un devis</a>
                    <a onclick="toggleModal(this)" class="btn dark h-in confirm-delete"
                       data-href="{{ route('admin.estimate-requests.close', $request) }}">Clôturer</a>
                </div>
            @endif
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Demande {{ ($request->space) ? "salle ".$request->space->name  : ""}}
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Détails de la demande</p>
        </div>
        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Nom</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->name }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Entreprise</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->company }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Adresse email</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->email }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->phone }}</dd>
                </div>

                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Début</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->start }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Fin</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->end }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Horaires</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->time }}</dd>
                </div>
                <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">Demande effectuée le</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->created_at }}</dd>
                </div>

                <div class="sm:col-span-2">
                    <dt class="text-sm font-bold font-medium text-gray-500">Message</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $request->message }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @include('_partials.components.confirm-delete-modal')
@endsection
