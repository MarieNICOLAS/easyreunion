@extends('layouts.app')

@section('content')
    <section class="grid place-content-center">

        <div class="container grid gap-y-12 place-content-center w-full">

            @can('create', \App\Models\SpaceGroup::class)
                <a href="{{ route('partner.space-groups.create') }}"
                   role="button"
                   class="btn info mx-auto h-in">
                    Ajouter un espace
                </a>
            @endcan

                @if(Auth::user()->rank === 'admin')
                    <div class="flex justify-between">
                        <div class="relative">
                            <input type="text" id="searchSpace" placeholder="Rechercher un espace" />
                            @csrf
                            <div id="resultFastSearch" class="absolute z-50 bg-white border-gray-300 p-4 border" style="display: none">

                            </div>
                        </div>

                        <div>
                            <a role="button" href="{{ route('partner.space-groups.front.menu') }}" class="btn neutral h-in">Menu NOS ESPACES</a>
                        </div>
                     </div>
                @endif


                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                @foreach($spacegroups as $spaceGroup)
                    <div
                        class="{{ $spaceGroup->status == "draft" ? "bg-orange" : "bg-white" }} relative rounded-lg border border-gray-300 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <div class="flex-1 min-w-0">
                            <a href="{{ Auth::user()->rank === 'admin' ? route('partner.space-groups.show', $spaceGroup) : route('spaceGroup', $spaceGroup) }}"
                               class="focus:outline-none">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $spaceGroup->name }}
                                    @if($spaceGroup->front_menu)
                                        <span style="color: blue">({{ $spaceGroup->front_menu +1 }})</span>
                                    @endif
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $spaceGroup->address }}
                                </p>
                            </a>
                        </div>
                        <div>
                            @foreach($spaceGroup->spaces as $space)
                                <div>
                                    <a href="{{ route('partner.spaces.show', $space) }}">{{ $space->name }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $spacegroups->links() }}

        </div>

    </section>

@endsection

@push('end-body')

    <script>

        let inputSearch = document.getElementById('searchSpace');
        let letters;
        let searchUrl = "{{ route('api.spaces.fast.search') }}";
        let token = document.querySelector('input[name="_token"]').value;
        let divResult = document.getElementById('resultFastSearch');

        inputSearch.addEventListener('input', function() {

            letters = inputSearch.value;

            fetch(searchUrl+"/"+letters, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': token
                }
            })
                .then(response => response.json())
                .then((res) => {

                let html = "<ul>";
                for(let i = 0; i < res.length; i++) {
                    html += `<li><a href="space-groups/${res[i].slug}">${res[i].name}</a></li>`;
                }

                html += "</ul>";
                divResult.style.display = "block";
                divResult.innerHTML = html;


                setTimeout(function() {
                    divResult.style.display = 'none';
                }, 3000);



            });

        })

    </script>

@endpush
