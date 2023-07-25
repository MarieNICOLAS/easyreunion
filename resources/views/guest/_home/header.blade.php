<br/><br/>
<div class="max-w-screen-xl mx-auto space-y-12">
    <header class="flex justify-around">
        <div class="first flex flex-col justify-around">
            <b class="easy-DarkBlue">Pour vos réunions et conférences</b>
            <h1>
                Location de salles<br/>
                pour vos évènements<br/>
                professionnels
            </h1>

            <div class="mt-10 flex gap-5 paddingBtn">
                <a class="easyBtn text-white rounded txtcenter px-5 py-5 btnMobil" href="{{ route('catalogue') }}">
                    Location de salles
                </a>
                <a class="easy-DarkBlue easyLightBlue-bg rounded txtcenter px-5 py-5 btnMobil" href="/#contact">
                    Nous contacter
                </a>
            </div>
        </div>

        <div class="second dNoneForMobil container-diapo">
            <img srcset="{{ asset('images/fond-easyreunion.webp') }} 1919w, {{ asset('images/erbg-mobil.jpg') }} 482w"
                 src="{{ asset('images/fond-easyreunion.webp') }}"
                 alt="Photo bibliothèque de l'espace Bellechasse"
                 class="rounded header-img"
                 title="La bibliothèque de l'espace Bellechasse"
            >

            <img src="https://www.easyreunion.fr/images/er-image-bg3.webp"
                 alt="Photo Le salon Gustav-Malher de l'espace Saint-Augustin"
                 class="rounded header-img"
                 title="Le salon Gustav-Malher de l'espace Saint-Augustin"
            >

            <img src="https://www.easyreunion.fr/images/location-amphitheatre-seminaire-06.webp"
                 alt="Photo Amphitheatre chaptal"
                 class="rounded header-img"
                 title="Amphitheatre de l'espace chaptal">

            <img src="https://www.easyreunion.fr/images/er-image-bg5.webp"
                 alt="Photo Auditorium de l'espace Bellechasse"
                 class="rounded header-img"
                 title="Auditorium de l'espace Bellechasse">

            <div class="slider-nav">
                <span class="prev" id="prevButtonSlide">&lt;</span>
                <span class="next" id="nextButtonSlide">&gt;</span>
            </div>
        </div>
    </header>
</div>

<div id="headerBottom container-diapo" class="forMobile forMobile2">
    <img srcset="{{ asset('images/fond-easyreunion.webp') }} 1919w,
                                    {{ asset('images/erbg-mobil.jpg') }} 482w"
         src="{{ asset('images/fond-easyreunion.webp') }}" alt="Photo bibliothèque de l'espace Bellechasse"
         class="rounded header-img" title="Page d'accueil - la bibliothèque de l'espace Bellechasse">
</div>


<script>
    const sliderImages = document.querySelectorAll('.container-diapo img');
    let currentIndex = 0;

    const nextSlide = () => {
        sliderImages[currentIndex].style.display = 'none';
        let nextIndex = (currentIndex + 1) % sliderImages.length;
        sliderImages[nextIndex].style.display = 'block';
        currentIndex = nextIndex;
    }

    const prevSlide = () => {
        sliderImages[currentIndex].style.display = 'none';
        let prevIndex = (currentIndex - 1 + sliderImages.length) % sliderImages.length;
        sliderImages[prevIndex].style.display = 'block';
        currentIndex = prevIndex;
    }

    document.getElementById('prevButtonSlide').addEventListener('click', prevSlide );
    document.getElementById('nextButtonSlide').addEventListener('click', nextSlide );

    setInterval(nextSlide, 7000);
</script>
