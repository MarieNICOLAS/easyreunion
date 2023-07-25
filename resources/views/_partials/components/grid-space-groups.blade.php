@php
    use App\Services\ImageService;
@endphp

<div class="h-full w-full boxShadow">
    <a href="{{ $space_group['type'] === 'sg' ? route('spaceGroup', $space_group['slug']) : route('space', [$space_group['sg_slug'], $space_group['slug']]) }}" aria-label="Aller à la page {{ $space_group['name']  }}" rel="nofollow" title="{{ $space_group['name']  }}">

        <figure role="group" aria-label="fig-caption" class="w-full h-64 overflow-hidden bg-gray-200">

                 @php
                    (isset($space_group['thumbnail_images']) && count($space_group['thumbnail_images']) > 0) ?  $image = $space_group['thumbnail_images'][0] : $image = null;
                 @endphp

                @if ($image)
                        <img
                            class="w-full h-auto object-cover object-center"
                            src="{{ $image->file ?? ImageService::getThumbImg($image) }}"
                            alt=" {{ $space_group['name']  }}">
                @endif
        </figure>
    </a>

    <div role="contentinfo" class="flex flex-col w-full divide-y divide-gray-200 border-gray-200 border-l border-r">
        <div class="flex w-full flex-1">
            <div class="flex justify-between items-center text-xs py-2 px-2 whitespace-nowrap">
                <p class="fontDescription ml-5"> {{ $space_group['max_capacity'] }} personnes</p>
                @if($space_group['has_disabled_access'])
                    <span class="h-4 w-4"><img src="{{ asset('images/wheelchair-solid.svg') }}" alt="acces handicap"
                                               class="w-full h-auto ml-1"></span>
                @endif
            </div>
            @if($space_group['type'] === 'sp')
                <div class="flex-grow grid place-content-center text-xs py-2 px-2 whitespace-nowrap">
                    <p class="flex gap-x-2 flex-nowrap fontDescription"><span class="hidden lg:block">Salle de </span>{{ $space_group['area'] }}m²</p>
                </div>
            @endif
            @if($space_group['type'] === 'sg')
                <div class="flex-grow grid place-content-center text-xs py-2 px-2 whitespace-nowrap">
                    <div class="flex gap-4">
                        <span class="h-4 w-4"><img src="{{ asset('images/icones/people-group-solid.svg') }}"
                                                   alt="reunion en groupe" class="w-full h-auto"></span>
                        <span class="h-4 w-4"><img src="{{ asset('images/icones/video-solid.svg') }}"
                                                   alt="visioconférence" class="w-full h-auto"></span>
                    </div>
                </div>
            @endif
            <div class="flex-1 py-2 px-2 grid place-content-center whitespace-nowrap">
                <p class="fontDescription">{{ $space_group['zip'] }} {{ $space_group['city'] }}</p>
            </div>
        </div>

            <article
                class="flex-grow w-full py-2 px-2 font-bold text-center border-b hover:bg-blue-400">
                <a href="{{ $space_group['type'] === 'sg' ? route('spaceGroup', $space_group['slug']) : route('space', [$space_group['sg_slug'], $space_group['slug']]) }}" aria-label="Aller à la page {{ $space_group['name']  }}" title="{{ $space_group['name']  }}">
                    <h2 class="fontDescription_Space-name hover:text-white">{{ $space_group['name'] }}</h2>
                </a>


            </article>


        @if($space_group['type'] === 'sp')

                <a rel="nofollow"
                   href="{{ route('request-quote.index') . '?' .  ($space_group['type'] === 'sg' ? 'group=' : 'space=') . urlencode($space_group['slug']) }}" aria-label="Aller à la page {{ $space_group['name']  }}"  title=" Demande de devis">
                    <div
                        class="font-semibold text-center border text-black hover:bg-blue-400 hover:text-white grid place-content-center w-full py-2 px-2">
                        Demande de devis
                    </div>
                </a>

        @endif
        @if($space_group['type'] === 'sg')
            <div>
                <a href="/#contact" aria-label="Aller à la section contact" title="Pour louer une salle pour vos réunions contactez-nous!">
                    <div
                        class="font-semibold text-center border text-black hover:bg-blue-400 hover:text-white grid place-content-center w-full py-2 px-2">
                        Contactez-nous
                    </div>
                </a>
            </div>
        @endif
    </div>

</div>
