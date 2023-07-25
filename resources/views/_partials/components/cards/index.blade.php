<div class="flex flex-wrap gap-x-8 gap-y-6 justify-evenly cursor-default z-0">

    @foreach($cards as $card)
        @include('_partials.components.cards.card',
        array_merge($card, [
            'route_name' => $route_name ?? 'space',
        ]))
    @endforeach

</div>
