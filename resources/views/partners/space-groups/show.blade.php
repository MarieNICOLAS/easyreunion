@extends('layouts.app')

@section('content')

    <main>
        <section class="container grid grid-cols-1 space-y-6">

            <h2 class="text-2xl font-extrabold tracking-tight text-current lg:text-4xl text-center">
                Espace "{{ $space_group->name  }}"
            </h2>

            <ul role="list" class="space-y-10">
                <li class="bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">
                    <hgroup class="flex flex-col lg:flex-row gap-x-6 gap-y-4 items-start lg:items-end">
                        <h3 class="text-xl font-extrabold tracking-tight text-current lg:text-3xl">
                            Informations générales
                        </h3>
                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Toutes les coordonnées permettant d'identifier et de localiser votre espace.
                        </p>
                    </hgroup>
                    <div class="grid grid-cols-2 space-x-6 space-y-6">
                        <form action="{{ route('partner.space-groups.update', ['space_group' => $space_group]) }}"
                              enctype="multipart/form-data"
                              id="formSpaceData"
                              method="post" name="space-group">
                            <div class="grid grid-cols-1">
                                <div
                                    class="form-group" style="margin-top: 0!important;">
                                    <label for="name">
                                        Nom
                                    </label>
                                    <input type="text" name="name" id="name"
                                           value="{{ old('name') ?? $space_group->name }}"
                                           placeholder="Nom de votre espace">
                                </div>


                                @if(Auth::user()->rank === 'admin')
                                    <div
                                        class="form-group" style="margin-top: 0!important;">
                                        <label for="slug">
                                            Lien unique de la page
                                        </label>
                                        <input type="text" name="slug" id="slug"
                                               value="{{ old('slug') ?? $space_group->slug }}"
                                               placeholder="Url de la page de l'espace">
                                    </div>
                                @endif

                                <div
                                    class="form-group" style="margin-top: 0!important;">
                                    <label for="address">
                                        Adresse
                                    </label>
                                    <input type="text" name="address" id="address"
                                           value="{{ old('address') ?? $space_group->address }}"
                                           placeholder="Adresse de l'espace">
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-4 md:grid-cols-3 space-x-3">
                                    <div
                                        class="form-group col-span-3" style="margin-top: 0!important;">
                                        <label for="city">
                                            Ville
                                        </label>
                                        <input type="text" name="city" id="city"
                                               value="{{ old('city') ?? $space_group->city }}"
                                               placeholder="Ville où se situe l'espace">
                                    </div>
                                    <div
                                        class="form-group" style="margin-top: 0!important;">
                                        <label for="zip_code">
                                            Code postal
                                        </label>
                                        <input type="text" name="zip_code" id="zip_code"
                                               value="{{ old('zip_code') ?? $space_group->zip_code }}"
                                               placeholder="Code postal de la ville">
                                    </div>
                                </div>

                                <input type="hidden" name="lat" value="{{ old('lan') ?? $space_group->lat }}" id="inputLat"/>
                                <input type="hidden" name="lon" value="{{ old('lon') ?? $space_group->lon }}" id="inputLon"/>

                                <div class="form-group">
                                    <label for="meta_title">Meta titre</label>
                                    <input type="text" id="meta_title" name="meta_title"
                                           value="{{ old('meta_title') ?? $space_group->meta_title }}"
                                           placeholder="Meta title"/>
                                </div>
                                <div
                                    class="form-group" style="margin-top: 0!important;">
                                    <label for="meta">
                                        Méta description
                                    </label>
                                    <input type="text" name="meta" id="meta"
                                           value="{{ old('meta') ?? $space_group->meta }}"
                                           placeholder="Méta description (150 car. environ)">
                                </div>
                                <div
                                    class="form-group" style="margin-top: 0!important;">

                                    @if($space_group->brochure)
                                        {{ $space_group->brochure_name }}
                                        <input type="hidden" name="brochure_original" value="{{ $space_group->brochure }}"/>
                                    @endif


                                    <label for="meta">
                                        Ajout de la plaquette
                                    </label>
                                    <input type="file" name="brochure" id="brochure"
                                           accept=".pdf"
                                           placeholder="Ajout de la plaquette">

                                    <div id="messageError" style="display: none;" class="text-red">Seuls les fichiers au format PDF sont acceptés</div>
                                    <div id="messageValide" style="display: none;" class="text-green">fichier validé</div>

                                </div>

                                @if(Auth::user()->rank === 'admin')
                                    <div class="form-group" style="margin-top: 0!important;">
                                        <select class="w-full" name="partner_id" aria-label="select-field">
                                            <option value="">Associer le partenaire</option>
                                                <optgroup label="partenaire">
                                                    @foreach($partners->groupBy(function($partner) {
                                                            return strtoupper(substr($partner->company, 0, 1));
                                                        }) as $letter => $groupedPartners)
                                                        <optgroup label="{{ $letter }}">
                                                            @foreach($groupedPartners as $partner)
                                                                <option value="{{ $partner->id }}" {{ ($partner->id == $space_group->partner_id) ? 'selected' : '' }}>{{ $partner->company }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </optgroup>
                                        </select>
                                    </div>
                                @endif

                            </div>


                            @if(Auth::user()->rank === 'admin')
                                <div class="form-group" style="margin-top: 0!important;">
                                    <select class="w-full" name="status" aria-label="select-field">
                                        @foreach(['draft' => 'Brouillon', 'online' => 'En ligne'] as $status=>$label)
                                            <option value="{{ $status }}" @if ($space_group->status == $status || (!$space_group->status && $status == 'online')) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            <div class="col-span-2 text-right my-2">
                                @csrf
                                <button type="submit" class="btn info h-in float-left">
                                    Mettre à jour
                                </button>
                            </div>
                        </form>
                        <div class="overflow-x-hidden space-y-4">
                            <header class="w-full flex justify-between items-center gap-x-2">
                                <h4 class="text-base font-extrabold tracking-tight text-current gap-x-3 flex items-center w-max">
                                    <span>Photos de couverture</span>
                                    <span aria-hidden="true" hidden>
                                        <span class="relative flex flex-col items-center group">
                                            <!-- Success state -->
                                            <svg data-state="success"
                                                 class="h-5 w-5 text-green-500 hover:text-green-500" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            <!-- Error state -->
                                            <svg data-state="error" class="h-5 w-5 text-red-500 hover:text-red-600"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            <!-- Unknown state -->
                                            <svg data-state="unknown" class="w-5 h-5 text-gray-500 hover:text-gray-600"
                                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                 fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            <span
                                                class="absolute bottom-0 flex flex-col items-center hidden mb-6 group-hover:flex"
                                                role="tooltip">
                                                <span
                                                    class="relative z-10 p-2 text-xs leading-none text-white whitespace-no-wrap bg-black shadow-lg"></span>
                                                <span class="w-3 h-3 -mt-2 transform rotate-45 bg-black"></span>
                                            </span>
                                        </span>
                                    </span>
                                </h4>

                            </header>

                            <form action="#" method="POST" name="form-order">
                                @csrf
                                    @php
                                        $medias = $space_group->media->sortBy('order');
                                        $medias_order_not_null = $medias->filter(function ($media) {
                                            return $media->order !== null;
                                        });
                                        $medias_order_null = $medias->filter(function ($media) {
                                            return $media->order === null;
                                        });
                                        $sorted_medias = $medias_order_not_null->merge($medias_order_null);
                                    @endphp
                                    @foreach($sorted_medias as $i => $media)
                                        <article
                                            class="h-max max-w-[200px] inline-block grid place-content-center float-left articlemedia"
                                            style="flex: 0 0 auto"
                                            data-orderid = "{{ $i+1 }}"
                                            data-mediaid = "{{ $media->id }}"
                                             >


                                            @if ('youtube-video' !== $media->type)
                                                <img src="{{ $media->url }}"
                                                     alt="{{ $media->name }}" class="object-contain h-28 w-auto block">
                                            @endif
                                            @if ('youtube-video' === $media->type)
                                                @php
                                                    $is_embed = strpos($media->content, 'embed') !== false;
                                                    $id_video = $is_embed ? explode('embed/', $media->content)[1] : explode('v=', $media->content)[1];
                                                @endphp
                                                <iframe class="aspect-video h-28 w-auto block"
                                                        src="https://www.youtube.com/embed/{{ $id_video }}"
                                                        frameborder="0"
                                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen></iframe>
                                            @endif

                                            <div class="flex gap-x-1 justify-between">
                                                <a href="{{ route('partner.media.remove', $media->id) }}"
                                                    class="btn p-2 danger h-in"
                                                    onclick="onClickRemoveMedia(event)">
                                                    <svg class="w-4 h-4" fill="currentColor"
                                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                              d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                              clip-rule="evenodd"></path>
                                                    </svg>
                                                </a><!--
                                                <input type="number" min="1" name="order[{{ $media->id }}]"
                                                       class="px-4 py-2 w-20" onchange="onChangeOrder(event)"
                                                       value="{{ $i+1 }}">-->

                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" data-orderid="{{ $i+1 }}" data-direction="before" style="cursor:pointer" onclick="changeOrder(this)" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                                </svg>

                                                <span class="showOrderValue">{{ $i+1 }}</span>

                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" data-orderid="{{ $i+1 }}" data-direction="after" style="cursor:pointer" onclick="changeOrder(this)"  fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                                </svg>
                                            </div>
                                        </article>
                                    @endforeach
                            </form>

                            <form enctype="multipart/form-data" method="POST"
                                  action="{{ route('partner.media.store') }}">
                                <input type="hidden" name="space_group" value="{{ $space_group->id }}"/>
                                <!--
                                <div class="form-group">
                                    <label>URL Vidéo YouTube</label>
                                    <input type="text" name="youtubeurl" onchange="onChangeVideo(event)" />
                                </div>-->

                                <br style="clear: both"/>
                                <div>
                                    <label>Ajouter une image</label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input type="file" name="file" onchange="onChangeImage(event)" />
                                </div>
                                <aside class="preview aspect-video h-64 w-full grid place-content-center" style="display: none">
                                    <img src alt="Aperçu" hidden class="object-contain h-[inherit] w-auto" />
                                    <iframe class="object-contain aspect-video h-[inherit] w-auto" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen hidden></iframe>
                                </aside>
                                @csrf
                                <button type="submit" class="btn info h-in">
                                    Ajouter
                                </button>
                            </form>
                        </div>
                    </div>
                </li>

                <li class="bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">
                    <hgroup class="flex flex-col lg:flex-row gap-x-6 gap-y-4 items-start lg:items-end">
                        <h3 class="text-xl font-extrabold tracking-tight text-current lg:text-3xl">
                            Présentation
                        </h3>
                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Présentation de l'espace.
                        </p>
                    </hgroup>
                    <div>
                        <form method="POST"
                              action="{{ route('partner.space-groups.update-description', $space_group) }}">
                            <textarea id="presentation" name="presentation" class="w-full"
                                      rows="8">{{ $space_group->presentation }}</textarea>
                            @csrf
                            <button type="submit" class="btn info h-in my-2">
                                Mettre à jour
                            </button>
                        </form>
                    </div>
                </li>

                <li class="bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">
                    <hgroup class="flex flex-col lg:flex-row gap-x-6 gap-y-4 items-start lg:items-end">
                        <h3 class="text-xl font-extrabold tracking-tight text-current lg:text-3xl">
                            Salles
                        </h3>
                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Salles présentes dans cet espace.
                        </p>
                        <a href="{{ route('partner.space-groups.space.create', $space_group) }}"
                           class="btn info h-in">
                            Ajouter une salle
                        </a>
                    </hgroup>
                    <div>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach($space_group->spaces as $space)
                                <li class="relative bg-white py-5 px-4 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                                    <div class="flex justify-between space-x-3">
                                        <div class="min-w-0 flex-1">
                                            <a href="{{ route('partner.spaces.show', ['space' => $space]) }}"
                                               class="block focus:outline-none">
                                                <p class="font-medium text-gray-900 truncate">{{ $space->name }}</p>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

            </ul>
        </section>
    </main>

@endsection
@push('end-body')
    @include('_partials.components.tinymce', ['selector' => '#presentation'])
    <script>

        let form = document.querySelector('form[name="form-order"]');
        let reorderUrl = "{{ route('partner.media.reorder') }}";

        let messageDiv = document.getElementById('messageError');
        let validMessage = document.getElementById('messageValide');

        function uuidv4() {
            return ([1e7] + -1e3 + -4e3 + -8e3 + -1e11).replace(/[018]/g, c =>
                (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
            );
        }
        const _index_timeouts = uuidv4();
        window[_index_timeouts] = {};
        function onChangeVideo(event) {
            event.preventDefault();
            const aside = event.target.closest('form').querySelector('aside.preview');
            aside.removeAttribute('style');
            const url = event.target.value;
            const url_separator = url.indexOf('https://www.youtube.com/embed/') === -1 ? 'v=' : '/embed/';
            const id = url.split(url_separator)[1];
            const urlEmbed = `https://www.youtube.com/embed/${id}`;
            const iframe = aside.querySelector('iframe');
            iframe.src = urlEmbed;
            iframe.hidden = false;
            const img = aside.querySelector('img');
            img.hidden = true;
            img.src = null;
        }
        function onChangeImage(event) {
            event.preventDefault();
            const {target} = event;
            const aside = target.closest('form').querySelector('aside.preview');
            aside.removeAttribute('style');
            const {files} = target;
            const file = files[0];
            const reader = new FileReader();
            const fname = file.name;

            var rg1=/^[^\\/:\*\?"<>()\|]+$/;
            var majRegex = /^\S+$/;
            if (rg1.test(fname) && majRegex.test(fname)){
            }else{
                alert(`Nom de fichier invalide ! Ne doit pas contenir de caractère spécial ex : \ / : * ? " < > .`);
                location.reload()
            };

            reader.onload = function (event) {
                const {result} = event.target;
                const img = aside.querySelector('img');
                img.src = result;
                img.hidden = false;
                const iframe = aside.querySelector('iframe');
                iframe.hidden = true;
                iframe.src = null;

            };
            reader.readAsDataURL(file);
        }

        const changeOrder = (element) => {

            let direction = element.dataset.direction;
            let currentId = parseInt(element.dataset.orderid);
            let currentArticle = document.querySelector('article[data-orderid="' + currentId + '"]');

            let new_position = 0;

            if(direction == "before") {
                new_position = currentId-1;
            } else {
                new_position = currentId+1;
            }

            // position on new position
            let targetArticle = document.querySelector('article[data-orderid="' + new_position + '"]');
            if (direction == "before") {
                form.insertBefore(currentArticle, targetArticle);
            } else {
                form.insertBefore(currentArticle, targetArticle.nextSibling);
            }

            // reorder all
            let articleMedias = document.querySelectorAll('.articlemedia');

            let mediaOrderArray = [];

            for(let i = 0; i < articleMedias.length; i++) {

                articleMedias[i].dataset.orderid = i+1;

                let svg1 = articleMedias[i].querySelector('svg[data-direction="before"]');
                if (svg1) {
                    svg1.dataset.orderid = i+1;
                }

                let svg2 = articleMedias[i].querySelector('svg[data-direction="after"]');
                if (svg2) {
                    svg2.dataset.orderid = i+1;
                }

                articleMedias[i].querySelector('.showOrderValue').innerHTML = i+1;
                mediaOrderArray.push((i+1)+':'+articleMedias[i].dataset.mediaid);
            }


            console.log(mediaOrderArray);

            // save
            let queryString = mediaOrderArray.join(',');

            fetch(reorderUrl, {
                method: 'POST',
                body: queryString,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then((res) => {
                console.log(res);
            });
        }



        function onClickRemoveMedia(event) {
            event.preventDefault();

            let {target} = event;
            target = 'a' === target.tagName.toLowerCase() ? target : target.closest('a');
            const {href} = target;

            if (!confirm('Voulez-vous vraiment supprimer ce media ?')) {
                return;
            }

            target.disabled = true;
            target.dataset.content = target.innerHTML;
            target.innerHTML = `<svg class="spinner w-5 h-5 mx-auto" viewBox="0 0 50 50"><circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle></svg>`;

            const form = target.closest('form');
            const headers = {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
            };
            const options = {method: 'DELETE', headers};

            fetch(href, options)
                .then((response) => {
                    const article = target.closest('article');
                    article.remove();
                    const inputs = form.querySelectorAll('input[name^="order"]');
                    for (let i = 0; i < inputs.length; i++) {
                        inputs[i].value = i + 1;
                    }
                })
                .catch(error => {
                    console.error(error);
                }).finally(()=>{
                    if (button) {
                        target.disabled = false;
                        target.innerHTML = target.dataset.content;
                        target.removeAttribute('data-content');
                    }
                });

            return false;
        }

        document.getElementById('brochure').addEventListener('change', function() {
            messageDiv.style.display = "none";
            validMessage.style.display = "block";
        })


        // listener on submit
        document.getElementById('formSpaceData').addEventListener('submit', function(e) {
            let brochure = document.getElementById('brochure');
            if(brochure.value.length > 1) {
                    if( brochure.files[0].type != "application/pdf") {
                        e.preventDefault();
                        messageDiv.style.display = "block";
                        return false;
                    }
            }
            return true;
        })



        // CREATE MAP AND GEOLOC
        const updateCoord = () => {

            let address = document.getElementById('address').value;
            let city = document.getElementById('city').value;
            let zip_code = document.getElementById('zip_code').value;
            let currentAddress = address+', '+zip_code+' '+city;

            let url = "https://nominatim.openstreetmap.org/search?format=json&q=" + currentAddress;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    let lat = data[0].lat;
                    let lon = data[0].lon;

                    document.getElementById('inputLat').value = lat;
                    document.getElementById('inputLon').value = lon;

                })
                .catch(error => console.log(error));
        }


        window.onload = function(){


            let currentLat = document.getElementById('inputLat').value;
            let currentLon = document.getElementById('inputLon').value;

            if(currentLat == "" || currentLon == "") {
                updateCoord();
            }

            let addressInput = document.querySelector('input[name="address"]');
            let zipCodeInput = document.querySelector('input[name="zip_code"]');
            let cityInput = document.querySelector('input[name="city"]');

            [addressInput, zipCodeInput, cityInput].forEach(function(input) {
                input.addEventListener('blur', function() {
                    updateCoord();
                });
            });


        }



    </script>
@endpush
