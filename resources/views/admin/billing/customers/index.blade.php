@extends('layouts.app')

@section('content')
    <h1>Factures clients</h1>
    <table>
        <thead>
        <tr>
            <th>Nom du client</th>
            <th>Montant</th>
            <th>Statut</th>
            <th>Réservation</th>
        </tr>
        </thead>
        <tbody>
        @php $invoices = \App\Models\Invoice::customer()->orderBy('id','DESC')->paginate(20); @endphp
        @forelse($invoices as $invoice)
            <tr>
                <td><a href="{{ route('invoice.download', $invoice) }}">{{ $invoice->user->name }}</a></td>
                <td>{{ $invoice->ttc_total }}</td>
                <td>{{ __('invoices.'.$invoice->status) }}</td>
                <td>{!! $invoice->booking ? '<a href="'.route('user.bookings.show', $invoice->booking).'">Lien vers la réservation</a>' : '' !!}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Aucune facture pour l'instant</td>
            </tr>
        @endforelse
        {{ $invoices->links() }}
        </tbody>
    </table>
@endsection
