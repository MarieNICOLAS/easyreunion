<?php

namespace Tests\Traits;

use App\Events\DepositReceived;
use App\Models\Booking;
use App\Models\EstimateElement;
use App\Models\Offer;
use App\Models\OfferElement;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * Permet aux tests unitaires de manipuler les réservations plus facilement.
 */
trait UseBooking
{
    use WithFaker;
    use UseAddress, UseAgenda;

    /**
     * @param $user
     *
     * @return Booking
     */
    private function useBooking($user): Booking
    {
        $this->useAddress($user);
        $space = $this->useSpace($user);
        $agenda = $this->useAgenda($user);
        $space_group = $space->spaceGroup;
        $partner = $user->selectedPartner();

        // On récupére le panier (modèle Estimate)

        $cart = $user->getCurrentCart();
        $cart->billing_address_id = $user->addresses()->first()->id;
        $cart->booking_date = $this->faker()->dateTimeBetween('+1 week', '+24 week')->format('Y-m-d H:i:s');
        $cart->save();
        $amount = $cart->calculateDeposit();

        // Nouvel offre (modèle Offer)

        $offer = new Offer;
        $offer->name = $this->faker()->sentence(3);
        $offer->partner_id = $partner->id;
        $offer->description = $this->faker()->sentence(12);
        $offer->start = '09:00';
        $offer->stop = '18:00';
        $offer->space_group_id = $space_group->id;
        $offer->save();

        // On ajoute un element dans l'offre (modèle OfferElement).

        $offerElement = new OfferElement;
        $offerElement->agenda_id = $agenda->id;
        $offerElement->description = $this->faker()->sentence(12);
        $offerElement->unit_type = 'prestation';
        $offerElement->tax_rate = 20.00;
        $offerElement->unit_price = 1.00;
        $offerElement->optional = false;
        $offerElement->offer_id = $offer->id;
        $offerElement->partner_id = $partner->id;
        $offerElement->save();

        // On associe l'offre récemment créé au panier.

        EstimateElement::create([
            'description' => $offerElement->description,
            'quantity' => 1,
            'offer_id' => $offer->id,
            'offer_element_id' => $offerElement->id,
            'amount_paid' => 0.00,
            'estimate_id' => $cart->id,
        ]);

        DepositReceived::dispatch($cart, $amount);

        return $partner->bookings()->first();
    }
}
