Choisissez le forfait qui vous convient

<form method="POST" action="{{ route('partner.settings.plan.subscribe') }}" id="subscribe">
    @csrf
    <select name="plan" required>
        <option value="monthly">Plan Mensuel - 60 euros / mois</option>
        <option value="annual">Plan Annuel - 600 euros / an</option>
    </select>

    <div>
        <label for="coupon">Bon de réduction</label>
        <input type="text" name="coupon"/>
    </div>

    <input id="card-holder-name" type="text">

    <input type="hidden" name="paymentMethodId" id="paymentMethodId"/>

    <!-- Stripe Elements Placeholder -->
    <div id="card-element"></div>

    <button id="card-button" data-secret="{{ $selectedPartner->createSetupIntent()->client_secret }}">
        M'abonner
    </button>

</form>

@push('end-body')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            const stripe = Stripe('{{ config('services.stripe.key') }}');

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                e.preventDefault()
                const {setupIntent, error} = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                } else {
                    document.getElementById('paymentMethodId').value = setupIntent.payment_method;
                    document.getElementById('subscribe').submit();
                }
            });
        });

    </script>

@endpush
