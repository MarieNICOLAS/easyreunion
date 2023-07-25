@extends('layouts.app')

@section('content')
    <h1>Envoyer mes factures à Easy Réunion</h1>
    <table>
        <thead>
        <tr>
            <th>Montant</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->ttc_total }} euros</td>
                <td>{{ __('invoices.' . $invoice->status) }}</td>
                <td>{{ $invoice->created_at }}</td>
                <td><a href="{{ route('invoice.download', $invoice) }}">Télécharger</a></td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Aucune facture pour l'instant</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    {{ $invoices->links() }}

    @foreach($errors->all() as $error)
        <li>
            {{ $error }}
        </li>
    @endforeach
    <form method="POST" action="{{ route('partner.invoices.upload') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <label for="id" class="block text-sm font-medium text-gray-700">Numéro de la facture</label>
            <input name="id" type="text" value="{{ old('id') }}"/>
        </div>

        <div>
            <label for="amount" class="block text-sm font-medium text-gray-700">Montant de la facture</label>
            <input name="amount" value="{{ old('amount') }}" step=".01" min="10.00" max="" placeholder="100,00"
                   type="number"/>
        </div>

        <div>
            <label for="file" class="block text-sm font-medium text-gray-700">Facture</label>
            <input type="file" name="invoice"/>
        </div>

        <input class="btn success h-in" type="submit" value="Envoyer"/>
    </form>

@endsection
