<article class="shadow-lg rounded-xl border overflow-hidden">
    <div class="relative">
        <div class="w-full h-48">

            @if (isset($highlight_image))
                <img class="object-cover h-full w-full" src="{{ $highlight_image  }}" alt="{{ $image->name }}"/> 
            @endif
        </div>
        <p class="absolute rounded-r-lg p-2 pr-4 top-4 flex items-center bg-white">
            <svg class="h-5 w-5 mr-2 text-blue" viewBox="0 0 24 24">
                <path fill="currentColor"
                      d="M17.27 6.73L13.03 16.86L11.71 13.44L11.39 12.61L10.57 12.29L7.14 10.96L17.27 6.73M21 3L3 10.53V11.5L9.84 14.16L12.5 21H13.46L21 3Z"/>
            </svg>
            <span>{{ $zip_code }}</span>
        </p>
        <!-- TODO Enable this when the disability will be added in space group model
                <p class="absolute bg-blue text-white rounded-r-lg p-2 top-16">
                    <svg class="h-5 w-5" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M496.101 385.669l14.227 28.663c3.929 7.915.697 17.516-7.218 21.445l-65.465 32.886c-16.049 7.967-35.556 1.194-43.189-15.055L331.679 320H192c-15.925 0-29.426-11.71-31.679-27.475C126.433 55.308 128.38 70.044 128 64c0-36.358 30.318-65.635 67.052-63.929 33.271 1.545 60.048 28.905 60.925 62.201.868 32.933-23.152 60.423-54.608 65.039l4.67 32.69H336c8.837 0 16 7.163 16 16v32c0 8.837-7.163 16-16 16H215.182l4.572 32H352a32 32 0 0 1 28.962 18.392L438.477 396.8l36.178-18.349c7.915-3.929 17.517-.697 21.446 7.218zM311.358 352h-24.506c-7.788 54.204-54.528 96-110.852 96-61.757 0-112-50.243-112-112 0-41.505 22.694-77.809 56.324-97.156-3.712-25.965-6.844-47.86-9.488-66.333C45.956 198.464 0 261.963 0 336c0 97.047 78.953 176 176 176 71.87 0 133.806-43.308 161.11-105.192L311.358 352z" />
                    </svg>
                </p>
        -->
    </div>
    <div class="flex flex-col p-4">
        <p class="text-md font-medium">{{ $name ?? 'Sans nom' }}</p>
        <div class="flex mt-2 justify-around space-x-16 items-center">
            <p class="flex items-center">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,6A2,2 0 0,0 10,8A2,2 0 0,0 12,10A2,2 0 0,0 14,8A2,2 0 0,0 12,6M12,13C14.67,13 20,14.33 20,17V20H4V17C4,14.33 9.33,13 12,13M12,14.9C9.03,14.9 5.9,16.36 5.9,17V18.1H18.1V17C18.1,16.36 14.97,14.9 12,14.9Z"/>
                </svg>
                {{ $highest_capacity }} personnes max
            </p>
            <p class="flex items-center">
                <svg class="h-5 w-5 mr-2" viewBox="0 0 24 24">
                    <path fill="currentColor"
                          d="M13,11H18L16.5,9.5L17.92,8.08L21.84,12L17.92,15.92L16.5,14.5L18,13H13V18L14.5,16.5L15.92,17.92L12,21.84L8.08,17.92L9.5,16.5L11,18V13H6L7.5,14.5L6.08,15.92L2.16,12L6.08,8.08L7.5,9.5L6,11H11V6L9.5,7.5L8.08,6.08L12,2.16L15.92,6.08L14.5,7.5L13,6V11Z"/>
                </svg>
                {{ $highest_capacity }}m² max
            </p>
        </div>
        <a href="{{ route('spaceGroup', $slug) }}" class="mt-2 w-full py-5 btn info light text-md">En savoir plus</a>
    </div>
</article>
