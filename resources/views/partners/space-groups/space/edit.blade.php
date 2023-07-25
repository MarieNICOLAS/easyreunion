@extends('layouts.app')

@section('content')
    <main>
        <section class="container">

            <h2>Modifier l'espace <strong>{{ $space->name }}</strong></h2>


            <div
                class="mt-4 bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">

                <form class="flex-shrink"
                      action="{{ route('partner.spaces.delete',$space) }}"
                      method="post" class="text-right">
                    @csrf
                    <button type="submit"
                            class="btn danger h-in"
                            aria-expanded="false"
                            style="float: right"
                    >
                        Supprimer la salle
                    </button>
                </form>


                <div style="display: flex; flex-wrap: wrap;">
                    <form class="flex-grow"
                          action="{{ route('partner.spaces.edit',$space) }}"
                          method="post"
                          style="margin-right: 30px; width: 20%; min-width: 300px;"
                    >
                        @csrf

                        <div style="background-color: lightyellow;  padding: 20px; border: 1px solid black; border-radius: 20px">
                            <div class="">
                                <label for="name">Nom de l'espace</label>
                                <input type="text" id="name" name="name" value="{{ $space->name }}"/>
                            </div>
                            <br/>
                            <div class="flex items-center">
                                <label class="w-36" for="capacity_max">Capacité</label>
                                <input class="w-48" type="number" id="capacity_max" name="capacity_max" min="1"
                                       value="{{ $space->capacity_max }}"/>
                            </div>
                            <div class="flex items-center">
                                <label class="w-36" for="area">Surface (m²)</label>
                                <input class="w-48" type="number" id="area" name="area" value="{{ $space->area }}"/>
                            </div>
                            <br/>
                            <button type="submit"
                                    class="btn success mt-2 h-in"
                                    aria-expanded="false"
                                    style="width: 100%"
                            >
                                Enregistrer
                            </button>
                        </div>
                    </form>

                    <div style="width: 70%;">
                        Photos

                        <div style="display: inline-block">

                            <form action="#" method="POST" name="form-order" >
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


                                    @foreach($space->media as $i => $media)
                                        <article
                                            class="h-max max-w-[200px] inline-block grid place-content-center float-left articlemedia"
                                            style="flex: 0 0 auto; margin: 10px;"
                                            data-orderid = "{{ $i+1 }}"
                                            data-mediaid = "{{ $media->id }}"

                                        >

                                            @if ('youtube-video' !== $media->type)
                                                <img src="{{ $media->url }}"
                                                     alt="{{ $media->name }}" class="object-contain h-28 w-auto block">
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
                                                </a>

                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" data-orderid="{{ $i+1 }}" data-direction="before" style="cursor:pointer" onclick="changeOrder(this)" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                                                </svg>

                                                <span class="showOrderValue">{{ $i+1 }}</span>

                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" data-orderid="{{ $i+1 }}" data-direction="after" style="cursor:pointer" onclick="changeOrder(this)"  fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                                </svg>


                                                <input type="hidden" min="1" data-mediaid = "{{ $media->id }}" name="order[{{ $media->id }}]"
                                                       class="px-4 py-2 w-20 mediaOrder" onchange="onChangeOrder(event)" value="{{ $i+1 }}">
                                            </div>
                                        </article>
                                    @endforeach
                            </form>

                        </div>

                        <div>
                            <br/>

                            <form enctype="multipart/form-data" method="POST" action="{{ route('partner.media.store') }}">

                                <input type="hidden" name="space" value="{{ $space->id }}"/>

                                <input type="file" name="file"/>
                                @csrf
                                <button type="submit" class="btn info h-in mt-2">
                                    Ajouter
                                </button>
                            </form>
                            <br/>

                        </div>


                    </div>


                </div>


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
                          action="{{ route('partner.spaces.update-description',$space) }}">
                        <textarea id="presentation" name="presentation" class="w-full"
                                  rows="8">{{ $space->presentation }}</textarea>
                        @csrf

                        <div
                            class="form-group" class="mt-3">
                            <label for="meta">
                                Méta description
                            </label>
                            <input type="text" name="meta" id="meta"
                                   value="{{ old('meta') ?? $space->meta }}"
                                   placeholder="Méta description (150 car. environ)">
                        </div>
                        <div class="form-group">
                            <label for="meta_title">Meta titre</label>
                            <input type="text" id="meta_title" name="meta_title"
                                   value="{{ old('meta_title') ?? $space->meta_title }}" placeholder="Meta title"/>
                        </div>
                        <button type="submit" class="btn info h-in mt-2">
                            Mettre à jour
                        </button>
                    </form>
                </div>
            </div>


            <div class="bg-white shadow overflow-hidden px-4 py-4 sm:px-6 sm:rounded-md grid grid-cols-1 space-y-3">
                <hgroup class="flex flex-col lg:flex-row gap-x-6 gap-y-4 items-start lg:items-end">
                    <h3 class="text-xl font-extrabold tracking-tight text-current lg:text-3xl">
                        Caractéristiques
                    </h3>
                    <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                        Matériel présent dans l'espace
                    </p>
                </hgroup>
                <div>
                    <form method="POST"
                          action="{{ route('partner.spaces.update-tags', $space) }}">

                        @csrf

                        <div class="grid border-2 px-10 py-10 sm:grid-cols-2 md:grid-cols-4">
                            <p>techniques :</p>
                            @foreach(\App\Models\Tag::materials()->get() as $tag)
                                <div>
                                    <input id="{{ $tag->id }}" type="checkbox"
                                           name="materials[{{ $tag->id }}]" {{ $space->tags->contains($tag->id) ? 'checked="checked"' :'' }} />
                                    <label for="{{ $tag->id }}" class="ml-3">{{ __('tags.'.$tag->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="grid border-2 px-10 py-10 sm:grid-cols-2 md:grid-cols-4">
                            <p>mobilier :</p>
                            @foreach(\App\Models\Tag::searchType('mobilier')->get() as $tag)
                                <div>
                                    <input id="{{ $tag->id }}" type="checkbox"
                                           name="mobilier[{{ $tag->id }}]" {{ $space->tags->contains($tag->id) ? 'checked="checked"' :'' }} />
                                    <label for="{{ $tag->id }}" class="ml-3">{{ __('tags.'.$tag->name) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="grid border-2 px-10 py-10 sm:grid-cols-2 md:grid-cols-4">
                            <p>services proposés :</p>
                            @foreach(\App\Models\Tag::searchType('services')->get() as $tag)
                                <div>
                                    <input id="{{ $tag->id }}" type="checkbox"
                                           name="services[{{ $tag->id }}]" {{ $space->tags->contains($tag->id) ? 'checked="checked"' :'' }} />
                                    <label for="{{ $tag->id }}" class="ml-3">{{ __('tags.'.$tag->name) }}</label>
                                </div>
                            @endforeach
                        </div>                  
                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Salle adaptée pour
                        </p>
                        <div class="grid sm:grid-cols-2 md:grid-cols-4">
                            @foreach(\App\Models\Tag::type()->get() as $tag)
                                <div>
                                    <input id="{{ $tag->id }}" type="checkbox"
                                           name="materials[{{ $tag->id }}]" {{ $space->tags->contains($tag->id) ? 'checked="checked"' :'' }} />
                                    <label for="{{ $tag->id }}" class="ml-3">{{ __('forms.types.'.$tag->name) }}</label>
                                </div>
                            @endforeach
                        </div>


                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Configurations de la salle
                        </p>
                        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-y-2">
                            @foreach(\App\Models\Tag::searchType('arrangement')->get() as $tag)
                                <div class="flex">
                                    <div class="mr-4">
                                        <input id="{{ $tag->id }}" type="checkbox"
                                               name="arrangement[{{ $tag->id }}]" {{ $space->tags->contains($tag->id) ? 'checked="checked"' :'' }} />
                                        <label for="{{ $tag->id }}"
                                               class="ml-3">{{ __('forms.arrangement.'.$tag->name) }}</label>
                                    </div>
                                    <div>
                                        <input name="num[{{ $tag->id }}]" type="number" min="0"
                                               value="{{  $space->tags->where('id', $tag->id)->first()?->pivot->details ?
                                                        json_decode( $space->tags->where('id', $tag->id)->first()?->pivot->details)?->capacity
                                                    :0 }}"
                                               class="w-24"/>
                                        <label class="ml-3">Places</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        <p class="text-lg lg:text-xl font-normal text-gray-500 tracking-tight">
                            Accès
                        </p>
                        <div class="grid sm:grid-cols-2 md:grid-cols-4">
                            @foreach(\App\Models\Tag::searchType('access')->get() as $tag)
                                <div>
                                    <input id="{{ $tag->id }}" type="checkbox"
                                           name="access[{{ $tag->id }}]" {{ $space->tags->contains($tag->id) ? 'checked="checked"' :'' }} />
                                    <label for="{{ $tag->id }}" class="ml-3">{{ __('tags.'.$tag->name) }}</label>
                                </div>
                            @endforeach
                        </div>


                        <button type="submit" class="btn info mt-2 h-in">
                            Mettre à jour
                        </button>
                    </form>
                </div>
            </div>


        </section>
    </main>

@endsection
@push('end-body')
    @include('_partials.components.tinymce', ['selector' => '#presentation'])
    <script>


        let reorderUrl = "{{ route('partner.media.reorder') }}";

        let form = document.querySelector('form[name="form-order"]');

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


        const onClickRemoveMedia = (event) => {
            event.preventDefault();

            let {target} = event;
            target = 'a' === target.tagName.toLowerCase() ? target : target.closest('a');
            const {href} = target;


            console.log(href);

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
            });

            return false;
        }


    </script>
@endpush
