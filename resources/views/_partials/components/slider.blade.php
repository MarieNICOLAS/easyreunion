@php
    if(!isset($space_name)) $space_name = "easy-reunion";
@endphp
<div id="lightbox">

    <div class="slider-container2">
        <div class="text-white flex justify-center">
            <span class="changeCurrent"></span>
            <span>/</span>
            <span id="allImgIndex"></span>
        </div>
        <div class="sliderCarousel">
        @foreach($mediaData as $i => $image)
            <img src="{{ asset('storage/media/'.$image->content) ?? '' }}" class="slider-img active" alt="{{ ($image->name == 'Image') ? $space_name.'-'.$i+1 : '' }}" data-id="{{ $i+1 }}"/>
        @endforeach

        </div>
    </div>
    <nav class="absolute px-10 w-full mobilPosition">
        <img src="{{ asset('images/icons8-close-button-32.png') }}" alt="close" onclick="closeCar()" class="closeBtn">
        <ul class="flex justify-between">
            <li class="py-3 px-1 easyBtn rounded-lg text-white text-center cursor-pointer prevL">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </li>

            <li class="py-3 px-1 easyBtn rounded-lg text-white text-center cursor-pointer nextL">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </li>
        </ul>
    </nav>
</div>

<div class="img-space_group container-bloc-img paddingMobil2">
    <div class="first">
        @if(isset($mediaData[0]))
            <img src="{{ asset('storage/media/'.$mediaData[0]->content) ?? '' }}" onclick="openLightbox('0')" alt="{{ ($mediaData[0]->name == 'Image') ? $space_name.'-0' : '' }}" data-id="0"/>
        @else
            <img src="{{ asset('images/default-image.png') }}" alt="Image par défaut" data-id="0"/>
        @endif
    </div>
    <div class="second">
        <div class="row-gallery">
            @if(isset($mediaData[1]))
                <img src="{{ asset('storage/media/'.$mediaData[1]->content) ?? '' }}" onclick="openLightbox('1')" alt="{{ ($mediaData[1]->name == 'Image') ? $space_name.'-1' : '' }}" data-id="1"/>
            @else
                <img src="{{ asset('images/default-image.png') }}" alt="Image par défaut" data-id="1"/>
            @endif

            @if(isset($mediaData[2]))
                <img src="{{ asset('storage/media/'.$mediaData[2]->content) ?? '' }}" onclick="openLightbox('2')" alt="{{ ($mediaData[2]->name == 'Image') ? $space_name.'-2' : '' }}" data-id="2"/>
            @else
                <img src="{{ asset('images/default-image.png') }}" alt="Image par défaut" data-id="2"/>
            @endif

        </div>
        <div class="row-gallery">
            @if(isset($mediaData[3]))
                <img src="{{ asset('storage/media/'.$mediaData[3]->content) ?? '' }}" onclick="openLightbox('3')" alt="{{ ($mediaData[3]->name == 'Image') ? $space_name.'-3' : '' }}" data-id="3"/>
            @else
                <img src="{{ asset('images/default-image.png') }}" alt="Image par défaut" data-id="3"/>
            @endif


            @if(isset($mediaData[4]))
                <img src="{{ asset('storage/media/'.$mediaData[4]->content) ?? '' }}" onclick="openLightbox('4')" alt="{{ ($mediaData[4]->name == 'Image') ? $space_name.'-4' : '' }}" data-id="4"/>
                <button class="flex mt-10 mb-10 btn rounded gap-5 w-60 easyBtn justify-center items-center h-in dNoneForMobil" onclick="openLightbox('0')" >
                    Voir toutes les photos
                </button>
            @else
                <img src="{{ asset('images/default-image.png') }}" alt="Image par défaut" data-id="4"/>
            @endif


        </div>
    </div>
</div>




@push('scripts')
    <script>

        const images = document.querySelectorAll('.slider-img');
        const lightbox = document.querySelector("#lightbox");
        const nextL = document.querySelector(".nextL");
        const prevL = document.querySelector(".prevL");
        var currentImg = 0;
        
        const allImgIndex =  document.getElementById('allImgIndex');
        allImgIndex.innerHTML = images.length;
        const openLightbox = (indx_img) => {

            lightbox.style.visibility = "visible";
            lightbox.style.opacity = 1;

            for (let k = 0; k < images.length; k++) {
                if (images[k].classList.contains('active') && k != indx_img) {
                    images[k].classList.remove('active');
                }
            }

            currentImg = indx_img;
            // index igm indicator
             
            images[indx_img].classList.add('active');
            const changeCurrent = document.querySelector('.changeCurrent');
            changeCurrent.innerText = currentImg;
        }


        const closeCar = () => {
            lightbox.style.visibility= "hidden"
            lightbox.style.opacity= 0
        }

        const slideImg = (direction) => {

            images[currentImg].classList.remove('active');
            
            if( direction == "next") {
            
                currentImg++;
            } else {
            
                currentImg--;
            }


            if(currentImg >= images.length) {
                currentImg = 0;
            }

            if(currentImg < 0) {
                currentImg = images.length-1;
            }

            images[currentImg].classList.add('active');

        }

        
        const changeCurrent = document.querySelector('.changeCurrent');
        nextL.addEventListener('click', function() {
            slideImg('next');
            changeCurrent.innerText = currentImg + 1;
        })
        prevL.addEventListener('click', function() {
            slideImg('prev');
            changeCurrent.innerText = currentImg + 1;
        })

    </script>
@endpush
