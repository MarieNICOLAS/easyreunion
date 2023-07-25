<div class="grid grid-cols-2 gap-x-4 gap-y-8 headinTags">
    <!-- tags type 'material' -->
    <div>
        <h3>Équipements techniques</h3>
        @if (!empty($allTags['material']))
            @foreach($allTags['material'] as $tag)
                <div>
                    <dt>{{ __('tags.'.$tag->name) }}</dt>
                </div>
            @endforeach
        @else
            <p>En cours de renseignement <a href="/contactez-nous">contactez nous</a> pour plus d'informations</p>
        @endif
    </div>

    <!-- tags type 'mobilier' -->
    <div>
        <h3>Mobilier</h3>
        @if (!empty($allTags['mobilier']))
            @foreach($allTags['mobilier'] as $tag)
                <div>
                    <dt>{{ __('tags.'.$tag->name) }}</dt>
                </div>
            @endforeach
        @else
            <p>En cours de renseignement <a href="/contactez-nous">contactez nous</a> pour plus d'informations</p>
        @endif
    </div>

    <!-- tags type 'services' -->
    <div>
        <h3>Services disponibles</h3>
        @if (!empty($allTags['services']))
            @foreach($allTags['services'] as $tag)
                <div>
                    <dt>{{ __('tags.'.$tag->name) }}</dt>
                </div>
            @endforeach
        @else
            <p>En cours de renseignement <a href="/contactez-nous">contactez nous</a> pour plus d'informations</p>
        @endif
    </div>

    <div>
        <h3>Salle adaptée pour</h3>
        @if (!empty($allTags['type']))
            @foreach($allTags['type'] as $tag)
                <div>
                    <dt>{{ __('tags.'.$tag->name) }}</dt>
                </div>
            @endforeach
        @else
            <p>En cours de renseignement <a href="/contactez-nous">contactez nous</a> pour plus d'informations</p>
        @endif
    </div>
</div>
