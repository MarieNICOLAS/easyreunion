@php
    use App\Services\SpacesService;
    $spaceService = new SpacesService();
    $addressJson = $spaceService->getSpacesJson();
@endphp
<div id="mapContent">
            <img src="{{ asset('images/icons8-close-button-32.png') }}" class="closeBtnMpa" title="fermer la carte" alt="icon fermer la carte" onclick="closeMap()">
     <div class="flex w-full p-5">
         <div class="side-grid dNoneForMobil">
             @foreach($addressJson as $address)
                 <div class="card" data-name="{{ $address['name'] }}">
                     <a href="/espaces/{{ $address['slug'] }}">
                         <img src="{{ $address['highlight_image'] }}" alt="Image {{ $address['name'] }}" title="Découvrez {{ $address['name'] }}">
                     </a>
                     <div class="spacesGroupName">
                         <span class="text-ellipsis">{{ $address['name'] }}</span>
                     </div>
                     <div class="capacity">
                         <span>Capacité maximale: <br> <span class="easy-DarkBlue font-medium"> {{ $address['highest_capacity'] }} presonnes</span></span>
                     </div>
                     <div class="descriptionJs">
                         <button class="openTxt">Description :</button>
                         <div class="txtContent">
                             <p class="txt">{{ $address['meta'] }}</p>
                             <button class="closeTxt">Fermer</button>
                         </div>

                     </div>
                 </div>
             @endforeach
         </div>
         <div id="myMap"></div>
     </div>

</div>

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script>
    const spaceValue = document.getElementById("space-value");
    const spaceName = spaceValue.innerText;

    // open map content
    const openMap = document.getElementById("openMap");
    const mapContent = document.getElementById("mapContent");

    openMap.addEventListener("click", function() {
        mapContent.style.visibility = "visible";
        mapContent.style.opacity = "1";
    });

    const closeMap = () => {
        mapContent.style.visibility = "hidden";
        mapContent.style.opacity = 0;
    };
    //get json address from the space service
    const addressData = {!! json_encode($addressJson) !!};
    //filter for spacesGroup pages only
    let filteredData = addressData.filter(obj => obj.name === spaceName && obj.lat && obj.lon);

    // get all spaces
    if (filteredData.length === 0) {
        filteredData = addressData;
    }

    const lat = 48.866667;
    const lon = 2.333333;

    let macarte = null;

    function initMap() {
        macarte = L.map('myMap').setView([lat, lon], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
            attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
            minZoom: 1,
            maxZoom: 20
        }).addTo(macarte);
        // coordinate in spacesGroup pages
        if (filteredData.length > 0) {
            const lat = filteredData[0].lat;
            const lon = filteredData[0].lon;
            macarte.setView([lat, lon], 13);
        }

        filteredData.forEach(function(obj) {
            // create popup
            const address = obj.address;
            const latitude = obj.lat;
            const longitude = obj.lon;

            const customIcon = L.icon({
                iconUrl: '/../images/icones/map-marker.svg',
                iconSize: [32, 32],
                iconAnchor: [16, 2],
            });

            let marqueur = L.marker([latitude, longitude],{ icon: customIcon }).addTo(macarte);

            marqueur.on('mouseover', function (e) {
                this.openPopup();
            });
            marqueur._icon.setAttribute('data-name', obj.name);
            marqueur._icon.setAttribute('data-lat', obj.lat);
            marqueur._icon.setAttribute('data-lon', obj.lon);

            let popupContent = "<div class='flex flex-col space-y-2' data-name='" + obj.name + "'>";

            popupContent += "<div class='flex justify-center items-center'><p class='font-bold'><a class='mapLink' href='/espaces/" + obj.slug + "'>" + obj.name + "</a></p><img src='/../images/icones/map-icon.svg' class='h-5 w-5 ml-1' alt='incon aller sur la page espace'></div>";
            popupContent += "<div class='flex justify-center items-center'><a class='mapLink' href='/espaces/" + obj.slug + "'><img class='h-28 w-30 rounded' src=" + obj.highlight_image + " alt='louez votre salle dans cet espace " + obj.name + " '></a></div>"
            popupContent += "<p><span class='easy-DarkBlue text-sm font-bold'>Adresse</span><span class='font-semibold text-sm italic'> : " + obj.address + "</span></p>";
            popupContent += "<p><span class='easy-DarkBlue text-sm font-bold'>Capacité maximale</span><span class='font-bold text-sm italic'> : " + obj.highest_capacity + "  personnes</span></p>";
            popupContent += "</div>";

            marqueur.bindPopup(popupContent);
        });

        // get side cards
        const cards = document.querySelectorAll('.card');

        cards.forEach(card => {
            // the data-name of the card
            const cardName = card.getAttribute('data-name');

            // find the same data-id
            const marqueur = Array.from(document.querySelectorAll('.leaflet-marker-icon')).find(icon => icon.getAttribute('data-name') === cardName);

            if (marqueur) {

                card.addEventListener('mouseover', function() {

                    marqueur.classList.add('animate-marker');

                    // Center the map on the marker
                    const markerLat = marqueur.getAttribute('data-lat');
                    const markerLon = marqueur.getAttribute('data-lon');
                    macarte.setView([markerLat, markerLon], 13);
                });

                card.addEventListener('mouseout', function() {

                    marqueur.classList.remove('animate-marker');
                });
            }
        });
    }

    window.onload = function() {
        initMap();
    };

    // Text description
    const openTxt = document.querySelectorAll('.openTxt');
    const txtDescription = document.querySelectorAll('.txtContent');
    const closeTxt = document.querySelectorAll('.closeTxt');

    openTxt.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            txtDescription[index].style.display = 'block';
            btn.style.display = 'none';
            closeTxt[index].style.display = 'block';
        });
    });

    closeTxt.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            txtDescription[index].style.display = 'none';
            btn.style.display = 'none';
            openTxt[index].style.display = 'block';
        });
    });
</script>
@endpush
