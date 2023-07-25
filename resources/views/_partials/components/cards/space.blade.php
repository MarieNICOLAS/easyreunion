<article class="shadow-lg rounded-xl border overflow-hidden">
    <div class="relative">
        <div class="w-full h-48">
            @if ($space->media->first())
            <a href="{{ route('space', [$space->sg_slug, $space->slug]) }}">
                <img class="object-cover h-full w-full" src="{{ $space->media->first()->url }}" alt="{{ $space->name }}"/>
            </a>
            @endif
        </div>

    </div>
    <div class="flex flex-col p-4">
        <p class="txt-space font-medium">{{ $space->name }}</p>
        <div class="flex mt-2 justify-around space-x-16 items-center ">
            <p class="flex items-center fontSpace_Card">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M12,13C14.67,13 20,14.33 20,17V20H4V17C4,14.33 9.33,13 12,13M12,14.9C9.03,14.9 5.9,16.36 5.9,17V18.1H18.1V17C18.1,16.36 14.97,14.9 12,14.9Z"/>
                </svg>
                {{ $space->capacity_max }} personnes
            </p>
            <p class="flex txt-space fontSpace_Card items-center">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M13,11H18L16.5,9.5L17.92,8.08L21.84,12L17.92,15.92L16.5,14.5L18,13H13V18L14.5,16.5L15.92,17.92L12,21.84L8.08,17.92L9.5,16.5L11,18V13H6L7.5,14.5L6.08,15.92L2.16,12L6.08,8.08L7.5,9.5L6,11H11V6L9.5,7.5L8.08,6.08L12,2.16L15.92,6.08L14.5,7.5L13,6V11Z"/>
                </svg>
                {{ $space->area }}m²
            </p>
        </div>
        <a href="{{ route('space', [$space->sg_slug, $space->slug]) }}" class="mt-2 w-full py-5 btn info light text-md h-in" 
            title="Voir l'emplacement {{ $space->name }}">Voir la salle</a>
    </div>
</article>
