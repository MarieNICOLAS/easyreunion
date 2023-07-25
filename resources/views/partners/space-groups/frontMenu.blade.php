@extends('layouts.app')

@section('content')

    <section class="grid place-content-center">

        <div class="container grid gap-y-12 place-content-center w-full">

            <h1>Affichage Espaces - Menu client</h1>


            <div class="relative">
                <input type="text" id="searchSpace" placeholder="Ajouter un espace" />
                @csrf
                <div id="resultFastSearch" class="absolute z-50 bg-white border-gray-300 p-4 border" style="display: none">

                </div>
            </div>



            <div>

                <h2>Liste des espaces actuels</h2>


                <ul id="listSpacesGroup" class="bg-white" >

                    @foreach($spaceGroups as $count => $spaceGroup)

                        <li class="p-2 border-b-2 flex justify-between itemSpace" data-order="{{ $count }}" data-id="{{ $spaceGroup->id }}">
                            <div>
                                {{ $spaceGroup->name }}
                            </div>
                            <div class="flex">
                                <span class="cursor-pointer" onclick="changeOrder(this, 'up')">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 19V5M5 12l7-7 7 7"/>
                                    </svg>
                                </span>

                                <span class="cursor-pointer" onclick="changeOrder(this, 'down')">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                      <path d="M12 5v14M5 12l7 7 7-7"/>
                                    </svg>
                                </span>
                            </div>

                        </li>

                    @endforeach


                </ul>

            </div>




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
        let ulList = document.getElementById('listSpacesGroup');
        let frontMenuUpdate = "{{ route('partner.space-groups.front.menu.update') }}";


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
                        html += `<li onclick="addSpace('${res[i].id}', '${res[i].name}')" class="cursor-pointer">${res[i].name}</></li>`;
                    }

                    html += "</ul>";
                    divResult.style.display = "block";
                    divResult.innerHTML = html;


                    setTimeout(function() {
                        divResult.style.display = 'none';
                    }, 3000);



                });

        })


        const changeOrder = (element, direction)  => {
            let listItem = element.parentNode.parentNode;

            if (direction === 'up') {
                let previousItem = listItem.previousElementSibling;
                if (previousItem) {
                    listItem.parentNode.insertBefore(listItem, previousItem);
                }
            } else if (direction === 'down') {
                let nextItem = listItem.nextElementSibling;
                if (nextItem) {
                    listItem.parentNode.insertBefore(nextItem, listItem);
                }
            }

            let spaces = document.querySelectorAll('.itemSpace');

            for(let i=0; i < spaces.length; i++) {
                let space = spaces[i];
                updateOrder(space.dataset.id, i);

            }

        }


        const updateOrder = (id, order) => {
            fetch(frontMenuUpdate+"/"+id+"-"+order, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': token
                }
            })
                .then(response => response.json())
                .then((res) => {
                    console.log(res);
                });

        }



        const addSpace = (id, name) => {

            // count all space group
            let order = parseInt(document.querySelectorAll('.itemSpace').length+1);

            console.log(frontMenuUpdate+"/"+id+"-"+order);


            // update space in bdd
            fetch(frontMenuUpdate+"/"+id+"-"+order, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => response.json())
            .then((res) => {

                console.log(res);


                // add li in dom
                let line = ` <li class="p-2 border-b-2 flex justify-between itemSpace" data-order="${order}" data-id="${id}">
                        <div>
                            ${name}
                        </div>
                        <div class="flex">
                            <span class="cursor-pointer" onclick="changeOrder(this, 'up')">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M12 19V5M5 12l7-7 7 7"/>
                                </svg>
                            </span>

                            <span class="cursor-pointer" onclick="changeOrder(this, 'down')">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                  <path d="M12 5v14M5 12l7 7 7-7"/>
                                </svg>
                            </span>
                        </div>

                    </li>
                    `;
                ulList.innerHTML += line;

            });

        }

    </script>

@endpush
