@extends('layouts.app')

@section('content')
    <h1>Gérer mon abonnement</h1>

    <p>Le forfait de base est obligatoire et permet d'être référencé sur la plateforme.</p>
    <p>Une fois le forfait pris, vous pourrez choisir l'option qui vous correspond le mieux pour accéder à l'ensemble de
        notre outil.</p>

    @if(is_null($selectedPartner->plan))
        @include('partners.subscribe')
    @else
        Votre abonnement de base est actif. Prochain renouvellement {{ $selectedPartner->getSubscriptionRenewDate() }} .

        <form method="POST" action="{{ route('partner.settings.plan.change') }}">
            @method('PUT')
            @csrf
            <fieldset>
                <legend class="sr-only">
                    Plan
                </legend>
                <div class="bg-white rounded-md -space-y-px">

                    <label
                        class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none">
                        <input type="radio" name="plan" value="annuaire"
                               {{ $selectedPartner->plan === 'annuaire' ? 'checked="checked"' : '' }}
                               class="h-4 w-4 mt-0.5 cursor-pointer text-blue border-gray-300 focus:ring-indigo-500"
                               aria-labelledby="privacy-setting-0-label"
                               aria-describedby="privacy-setting-0-description">
                        <div class="ml-3 flex flex-col">
                            <span id="privacy-setting-0-label" class="block text-sm font-medium">Annuaire</span>
                            <span id="privacy-setting-0-description" class="block text-sm">
                                Soyez référencez. Les utilisateurs intéressés vous contactent via la messagerie. 0% de commission
                            </span>
                        </div>
                    </label>

                    <label
                        class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none">
                        <input type="radio" name="plan" value="annuaire-plus"
                               {{ $selectedPartner->plan === 'annuaire-plus' ? 'checked="checked"' : '' }}
                               class="h-4 w-4 mt-0.5 cursor-pointer text-blue border-gray-300 focus:ring-indigo-500"
                               aria-labelledby="privacy-setting-0-label"
                               aria-describedby="privacy-setting-0-description">
                        <div class="ml-3 flex flex-col">
                            <span id="privacy-setting-0-label" class="block text-sm font-medium">Annuaire +</span>
                            <span id="privacy-setting-0-description" class="block text-sm">
                                Accédez en plus à notre outil de réservation. 30% de commission
                            </span>
                        </div>
                    </label>

                    @if($selectedPartner->type === 'spaceowner')
                        <label
                            class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none">
                            <input type="radio" name="plan" value="gestion-commerciale"
                                   {{ $selectedPartner->plan === 'gestion-commerciale' ? 'checked="checked"' : '' }}
                                   class="h-4 w-4 mt-0.5 cursor-pointer text-blue border-gray-300 focus:ring-indigo-500"
                                   aria-labelledby="privacy-setting-0-label"
                                   aria-describedby="privacy-setting-0-description">
                            <div class="ml-3 flex flex-col">
                                <span id="privacy-setting-0-label"
                                      class="block text-sm font-medium">Gestion commerciale</span>
                                <span id="privacy-setting-0-description" class="block text-sm">
                                On s'occupe en plus de faire de la promo pour votre salle et gérons l'agenda. 35% de commission
                            </span>
                            </div>
                        </label>

                        <label
                            class="rounded-tl-md rounded-tr-md relative border p-4 flex cursor-pointer focus:outline-none">
                            <input type="radio" name="plan" value="gestion-complete"
                                   {{ $selectedPartner->plan === 'gestion-complete' ? 'checked="checked"' : '' }}
                                   class="h-4 w-4 mt-0.5 cursor-pointer text-blue border-gray-300 focus:ring-indigo-500"
                                   aria-labelledby="privacy-setting-0-label"
                                   aria-describedby="privacy-setting-0-description">
                            <div class="ml-3 flex flex-col">
                                <span id="privacy-setting-0-label"
                                      class="block text-sm font-medium">Gestion complète</span>
                                <span id="privacy-setting-0-description" class="block text-sm">
                                Vous nous passez les clefs, on s'occupe du reste. 40% de commission
                            </span>
                            </div>
                        </label>
                    @endif
                </div>
            </fieldset>
            <input type="submit" class="btn success h-in"/>
        </form>
    @endif
@endsection

