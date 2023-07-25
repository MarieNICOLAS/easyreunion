@extends('layouts.app')

@section('content')
    <h1>Factures</h1>

    <h1>Factures à payer</h1>
    <table>
        <thead>
        <tr>
            <th>Partenaire</th>
            <th>IBAN</th>
            <th>Montant</th>
            <th>Demande le</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse(\App\Models\Invoice::partners()->pending()->with('partner')->get() as $invoice)
            <tr>
                <td>{{ $invoice->partner->name }}</td>
                <td>{{ $invoice->partner->iban }}</td>
                <td>{{ $invoice->ttc_total }} eur</td>
                <td>{{ $invoice->created_at }}</td>
                <td><a class="btn success" href="{{ route('admin.invoices.mark-as-paid', $invoice) }}">Marquer comme
                        payé</a>
                    <a class="btn dark h-in" href="{{ route('invoice.download', $invoice) }}">Télécharger</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Aucune facture en attente</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <h1>Toutes les factures</h1>
    <table>
        <thead>
        <tr>
            <th>Nom du client</th>
            <th>Facture</th>
            <th>Montant</th>
            <th>Statut</th>
        </tr>
        </thead>
        <tbody>
        @php $invoices = \App\Models\Invoice::partners()->orderBy('id','DESC')->paginate(20); @endphp
        @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->partner->name }}</td>
                <td><a href="{{ route('invoice.download', $invoice) }}">Télécharger</a></td>
                <td>{{ $invoice->ttc_total }}</td>
                <td>{{ __('invoices.'.$invoice->status) }}</td>
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
