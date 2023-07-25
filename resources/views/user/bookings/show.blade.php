@extends('layouts.app')

@section('content')
    <h3>Ma commande #{{ $booking->id }}</h3>

    @if($booking->amount_paid < $booking->amount_total)
        @if($booking->invoices->where('status', 'pending_payment')->count() > 0 )
            <table>
                <tr>
                    <th>Facture</th>
                    <th>Montant</th>
                    <th>Action</th>
                </tr>
                @foreach($booking->invoices->where('status', 'pending_payment') as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_id }}</td>
                        <td>{{ $invoice->ttc_total }} euros</td>
                        <td><a class="btn success h-in" href="{{ route('invoices.redirect-to-pay', $invoice) }}">Payer</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>Quand vous êtes sûr de vous (minimum 3 jours avant l'évènement), confirmez le nombre de personnes
                présentes et la quantité des options réservées, pour générer une facture et procéder au paiement</p>
            <form method="POST" action="{{ route('user.bookings.final-confirm', $booking) }}">
                @csrf

                @foreach($booking->estimate->lines as $line)
                    <div class="form-group">
                        <label>Quantité pour l'option {{ $line->description }}</label>
                        <input type="number" value="{{ $line->quantity }}" name="quantityFor[{{ $line->id }}]"/>
                    </div>
                @endforeach
                <input type="submit" value="Confirmer"/>
            </form>
        @endif
    @else
        <p>Vos factures ont bien été payées.</p>
        <p>Contenu de la réservation</p>

        @if($booking->ends_at <= \Carbon\Carbon::now())
            <p>Remonter un problème sur la salle</p>
            <form method="POST" action="{{ route('spaces.actions.store-two') }}">
                @csrf
                <div class="form-group">
                    <label>Salle</label>
                    <select name="space">
                        @foreach($booking->spaces as $space)
                            <option value="{{ $space->id }}">{{ $space->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Problème rencontré</label>
                    <textarea name="content"></textarea>
                </div>
                <input type="submit" value="Confirmer" class="btn info h-in"/>
            </form>
        @endif
    @endif
@endsection
@push('end-body')
    @if($booking->invoices()->where('status', 'pending_payment')->count() > 0)
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function (event) {
                const stripe = Stripe('{{ config('services.stripe.key') }}');

                const elements = stripe.elements();
                const cardElement = elements.create('card');

                cardElement.mount('#card-element');

                const cardHolderName = document.getElementById('card-holder-name');
                const cardButton = document.getElementById('card-button');

                cardButton.addEventListener('click', async (e) => {
                    const {paymentMethod, error} = await stripe.createPaymentMethod(
                        'card', cardElement, {
                            billing_details: {name: cardHolderName.value}
                        }
                    );

                    if (error) {
                        // Display "error.message" to the user...
                    } else {
                        document.getElementById('paymentMethodId').value = paymentMethod.id;
                        document.getElementById('pay').submit();
                    }
                });
            });
        </script>
    @endif
@endpush
