  <div
    class="hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
    id="confirm-delete-modal">
    <div class="relative w-auto my-6 mx-auto max-w-6xl">
        <div
            class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
            <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                <h3 class="text-3xl font-semibold">
                    Confirmation de suppression
                </h3>
                <button
                    class="p-1 ml-auto bg-transparent border-0 text-black float-right text-3xl leading-none outline-none focus:outline-none"
                    onclick="toggleModal(this)">
                    ×
                </button>
            </div>
            <div class="relative p-6 flex-auto">
                <p class="my-4 text-blueGray-500 text-lg leading-relaxed">
                    Êtes-vous vraiment sûr(e) ?
                </p>
            </div>
            <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                <button
                    class="text-red-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150 "
                    type="button" onclick="toggleModal(this)">
                    Annuler
                </button>
                <a href="#" id="validate-go"
                   class="btn-ok bg-emerald-500 text-gray-500 active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                   type="button">
                    Valider
                </a>
            </div>
        </div>
    </div>
</div>
<div class="hidden opacity-25 fixed inset-x-0 inset-y-0 top-9 bg-black" id="confirm-delete-modal-backdrop"></div>

@push('end-body')
     
     <script>
            function toggleModal(el) {
        modalID = "confirm-delete-modal"
        document.getElementById(modalID).classList.toggle("hidden");
        document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
        document.getElementById(modalID).classList.toggle("flex");
        document.getElementById(modalID + "-backdrop").classList.toggle("flex");

        document.getElementById("validate-go").setAttribute("href", el.dataset.href);
        }
     </script>
@endpush
