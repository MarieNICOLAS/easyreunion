@php
    use App\Services\SpacesService;
    $spaceService = new SpacesService();
    $spacesFormElements = $spaceService->getSpacesFormList();
    $allCitys = $spacesFormElements['allCitys'];
    $allTags = $spacesFormElements['allTags'];
@endphp

<form action="{{ route('catalogue') }}" method="GET" id="searchSpacesForm"
      class=" text-black border-2 rounded">
    <div class="flex justify-between rounded flex-wrap lg:flex-nowrap py-2 D-block">

        {{-- type d'event --}}
        <div class="py-5 px-6">
            <strong>Location pour :</strong><br/>
            <select name="type" class="border-0" aria-label="select-field" id="selectType">
                @foreach($allTags as $oneTag => $oneTagUF)
                    <option value="{{ $oneTag }}" class="selectTypeOption" {{ request()->get('type') === $oneTag ? 'selected' : '' }}>{{ $oneTagUF }}</option>
                @endforeach
            </select>
        </div>


        {{-- Localisation --}}
        <div class="py-5 px-6">
            <strong>Dans la ville de :</strong><br/>
            <!-- Select avec une barre de recherche à l'intérieur -->
            <select name="city" class="border-0" aria-label="select-field" id="selectCity">
                <optgroup label="Localisation">
                    @foreach($allCitys as $oneCity)
                        <option value="{{ $oneCity }}" {{ ($oneCity === 'Paris' || request()->get('city') === $oneCity) ? 'selected' : '' }}>
                            {{ $oneCity }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
        </div>

        {{-- Nombre participants --}}
        <div class="py-5 px-6">
            <strong>Pour :</strong><br/>
            <input type="number"
                id="inputNumberAttendees"
                min="1"
                max="9000"
                name="number_attendees"
                aria-label="select-field"
                placeholder="Nombre de participants"
                class="border-0"
                value="{{ ( request()->get('number_attendees') != null || request()->get('number_attendees') != "" ) ? request()->get('number_attendees') : '' }}"
                >
        </div>

        <div  class="py-5 px-6">
            <br/>
            <button id="searchbar-confirmation" class="py-3 sm:py-1 px-10 btn h-auto text-white -my-2 easyBtn sm:w-auto rounded-r">Chercher</button>
        </div>


    </div>
</form>


<script>
    // reload page on form submit validation
    document.getElementById('searchSpacesForm').addEventListener('submit', function (event) {
        event.preventDefault();
        let action = this.getAttribute('action');
        let city = document.getElementById('selectCity').value;
        let attendees = document.getElementById('inputNumberAttendees').value;
        let type = document.getElementById('selectType').value;

        let url = action + "?";

        // ville
        if (city != "") {
            url += `city=${city}`;
        }
        if (type != "") {
            url += `&type=${type}`;
        }

        // ville et type
        if (attendees != "") {
            url += `&attendees=${attendees}`;
        }
        if (url != "") {
            window.location.href = url;
        }
    })
</script>
