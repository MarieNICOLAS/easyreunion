<article
    onclick="window.location.href=`{{ isset($slug) ? route($route_name, $slug) : ''  }}`"
    class="w-96 rounded-lg border-gray-300 border-2 overflow-hidden">
    <div
        class="images bg-gray-200 w-full h-72 relative select-none flex items-center justify-start overflow-hidden cursor-pointer"
        style="--slider-index:0;"
        data-cs-element="card-slider" data-cs-element-id="{{ $id = Str::random(16) }}">

        @if (isset($images))
            @foreach($images as $image)
                <img src="{{ $image['file'] ?? '' }}" alt="{{ $space->meta_title }}" style="flex: 0 0 100%"
                     class="object-cover w-full h-auto transition transform"/>
            @endforeach

            @if (1 < count($images))
                <nav
                    onclick="event.preventDefault();event.stopPropagation()"
                    class="absolute bottom-0 right-4">
                    <ul class="flex gap-x-2">
                        <li class="py-3 px-1 easyBtn text-white text-center cursor-pointer" onclick="(event => {
                const element = event.target.closest('[data-cs-element]'), images = Array.from(element.children).filter(e => 'nav' !== e.tagName.toLowerCase()), newIndex = +getComputedStyle(element).getPropertyValue('--slider-index') - 1
                event.preventDefault(), setTimeout(() => element.style.setProperty('--slider-index', newIndex === -1 ? images.length-1 : newIndex), 0)
            })(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 19l-7-7 7-7"/>
                            </svg>
                        </li>
                        <li class="py-3 px-1 easyBtn text-white text-center cursor-pointer" onclick="(event => {
                const element = event.target.closest('[data-cs-element]'), images = Array.from(element.children).filter(e => 'nav' !== e.tagName.toLowerCase()), newIndex = +getComputedStyle(element).getPropertyValue('--slider-index') + 1
                event.preventDefault(), setTimeout(() => element.style.setProperty('--slider-index', newIndex === images.length ? 0 : newIndex), 0)
            })(event)">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </li>
                    </ul>
                </nav>
            @endif
        @endif
    </div>

    <div
        class="flex flex-col gap-y-2">
        <p
            onclick="event.preventDefault();event.stopPropagation()"
            class="px-4 py-2 text-lg select-text">
            {{ $name ?? 'Sans nom' }}
        </p>
        <div
            onclick="event.preventDefault();event.stopPropagation()"
            class="px-4 text-sm flex gap-x-3 select-none cursor-revert">
            <p class="flex gap-x-3 flex-1">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        fill-rule="evenodd"
                        clip-rule="evenodd"
                        d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>

                <span>de {{ $lowest_capacity ?? ($capacity_min ?? '??') }} à {{ $highest_capacity ?? ($capacity_max ?? '??') }}</span>
            </p>
            <p class="italic">{{ $description ?? 'Pas de description' }}</p>
        </div>
        <div class="flex select-none text-center">
            <a class="p-3 flex-1 hover:bg-gray-200 flex gap-x-3 justify-center cursor-pointer">
                <span>En savoir plus</span>
                <span>&gt;</span>
            </a>
        </div>
    </div>
</article>
