@extends('layouts.app')

@section('content')
    <h1>Factures de commission Easy Réunion</h1>
    <table>
        <thead>
        <tr>
            <th>Numéro</th>
            <th>Montant</th>
            <th>Partenaire associé</th>
        </tr>
        </thead>
        <tbody>
        @php $invoices = \App\Models\Invoice::commission()->orderBy('id','DESC')->paginate(20); @endphp
        @forelse($invoices as $invoice)
            <tr>
                <td><a href="{{ route('invoice.download', $invoice) }}">{{ $invoice->invoice_id }}</a></td>
                <td>{{ $invoice->ttc_total }}</td>
                <td>{{ $invoice->partner->name }}</td>
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
