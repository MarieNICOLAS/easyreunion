@extends('layouts.app')
@section('title', 'Gestion des demandes')

@section('content')
    <div class="float-right mr-6">

        <a class="btn info mx-2 h-in {{ $type === 'pending' ? 'btn-active' : '' }}"
           href="?type=pending">En attente</a>
        <a class="btn info mx-2 h-in {{ $type === 'all' ? 'btn-active' : '' }}"
           href="?type=all">*</a>
    </div>


    <h3 class="mb-4">Demandes en attente de traitement</h3>


    @if(Session::has('success'))
        @include('_partials.alerts.success', ['success' => Session::get('success')])
    @endif
    <table class="min-w-full divide-y divide-gray-200 mb-4">
        <thead class="bg-blue-back">
        <tr>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Entreprise
            </th>
            <th scope="col"
                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Espace
            </th>
            <th scope="col"
                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Message
            </th>
            <th scope="col"
                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                Date
            </th>
            <th scope="col"
                class="px-6 py-3 text-center text-xs font-medium  uppercase tracking-wider">
                Action
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        @forelse($requests as $request)
            <tr>
                <td>{{ $request->company }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                            <a href="">{{ $request->space->name }}</a>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div
                        class="text-sm text-gray-900">{{ strip_tags(substr($request->message, 0, 60)) }}
                        ...
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="text-sm font-medium text-gray-900">
                            <a href="">{{ $request->created_at }}</a>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-center text-sm text-gray-500">
                    <a href="{{ route('admin.estimate-requests.show', $request) }}"
                       class="btn dark h-in">Voir</a>
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center font-bold">Aucune demande en attente !</td>
            </tr>
        @endforelse

        </tbody>
        {{ $requests->appends(request()->input())->links() }}
    </table>
@endsection
