@extends('layouts.app')

@section('content')
    <table>
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Depuis</th>
        </tr>
        @forelse($partners as $partner)
            <tr onclick="window.location='{{ route('admin.partners.show', $partner) }}'" class="cursor-pointer">
                <td>{{ $partner->name }}</td>
                <td>{{ $partner->type }}</td>
                <td>{{ $partner->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">Aucune demande actuellement</td>
            </tr>
        @endforelse
    </table>
@endsection
