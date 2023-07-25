@extends('layouts.app')

@section('content')
    <div class="mt-3">
        <h1>Actions</h1>
        @if(session('success'))
            @include('_partials.alerts.success', ['success' => session('success')])
        @endif
        <table>
            <thead>
            <tr>
                <th>Salle</th>
                <th>Contenu</th>
                <th>Créé par</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($selectedPartner->spaceGroups as $sg)
                @foreach($sg->spaces as $space)
                    @foreach($space->actions()->pending()->get() as $action)
                        <tr>
                            <td>{{ $action->space->name }}</td>
                            <td>{{ $action->content }}</td>
                            <td>{{ $action->author?->name }}</td>
                            <td>{{ $action->created_at }}</td>
                            <td><a
                                    href="{{ route('partner.actions.toggle-completed', $action) }}">Marquer comme
                                    terminé</a>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
