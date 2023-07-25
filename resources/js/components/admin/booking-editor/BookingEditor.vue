<template>
    <div class="px-2 pt-6 pb-24 sm:px-2 sm:pt-12 lg:px-2 lg:py-4">
        <a class="mb-3 mr-3 md:my-0 float-left btn info text-sm h-in" href="/calendar">
        <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        Retour à l'agenda
        </a>
        <div class="w-full xl:w-5/6 2xl:w-2/3 mx-auto">
            <p class="mt-2 text-xl font-medium tracking-tight sm:text-3xl">Réservation {{ organization?.name }} -
                #{{
                    id
                }}</p>

            <div v-if="organization && organization.sellsy_url" class="float-right">
                <a :href="organization.sellsy_url" class="btn success h-in" target="_blank">Fiche sellsy client</a>
            </div>
            <div>
                <div>
                    <div class="sm:hidden">
                        <label class="sr-only" for="tabs">Choisir une section</label>
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select id="tabs" v-model="activeTab"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                name="tabs">
                            <option v-for="tab in tabs.filter(e => !e.notStatus.includes(status))" :key="tab.name"
                                    :selected="tab.current">{{ tab.name }}
                            </option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="border-b border-gray-200">
                            <nav aria-label="Tabs" class="-mb-px flex space-x-8">
                                <a v-for="tab in tabs.filter(e => !e.notStatus.includes(status))" :key="tab.name"
                                   :aria-current="tab.name === activeTab ? 'page' : undefined"
                                   :class="[tab.name === activeTab ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300', 'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm']"
                                   href="#"
                                   @click="activeTab = tab.name">
                                    {{ tab.name }}
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>

                <div v-show="activeTab === 'Contenu'">
                    Offre choisie
                    <EstimateContentEditor :booking-id="id" :estimate-id="estimateId" :lines="lines"
                                           :partners="partners"></EstimateContentEditor>

                </div>
                <div v-show="activeTab === 'Général'">
                    <h3 class="sr-only">Informations commande</h3>
                    <h4 class="sr-only">Général</h4>
                    <dl class="grid grid-cols-2 gap-x-6 text-sm py-10">
                        <div>
                            <dt class="font-medium text-gray-900">Client</dt>
                            <dd class="mt-2 text-gray-700">
                                <address class="not-italic">
                                    <span class="block"> <span
                                        class="font-bold">Entreprise : </span> {{ organization?.name }}</span>
                                    <span class="block"><span class="font-bold">Nom : </span>{{
                                            user.first_name + ' ' + user.last_name
                                        }}</span>
                                    <span class="block"> <span class="font-bold">Email : </span> {{ user.email }}</span>
                                    <span class="block"><span
                                        class="font-bold">Numéro de téléphone : </span> {{ user.phone }}</span>
                                </address>
                            </dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-900">Info commande</dt>
                            <dd class="mt-2 text-gray-700">
                                <span
                                    class="block">Commande passée le  {{ createdAt }}</span>
                                <span
                                    class="block">Dates : {{ startsAt }} - {{ endsAt }}</span>
                                <span
                                    class="block">État : <span :class="'font-bold text-' + bookingColors[status]">{{
                                        bookingStatuses[status]
                                    }}</span>
                                </span>
                                <span v-if="status === 'cancelled'">Motif :
                                        {{
                                        this.cancellationReasonSelect === 'other' ? this.cancellationReason : this.cancellationReasonSelect
                                    }}
                                    </span>
                                <span v-if="referent"
                                      class="block">Référent : {{
                                        referent.first_name + ' ' + referent.last_name
                                    }} - <a class="text-xs underline" href="#"
                                            @click="editReferentModalDisplay = true">Modifier</a></span>

                            </dd>
                        </div>
                        <div v-show="status !== 'cancelled'" class="w-full col-span-2 my-3">
                            <AgendaBookingEditor :agenda_elements="agendaElements" :available_spaces='availableSpaces'
                                                 :booking_id="id"
                                                 @addElement="addElement"
                                                 @removeElement="removeElement"/>
                        </div>
                        <div class="mt-2 col-span-2 md:col-auto">
                            <dt class="font-medium text-gray-900">Note interne</dt>
                            <textarea v-model="internalNote" class="w-full h-36 resize-none"
                                      @change="updateNote"></textarea>
                        </div>
                        <div>
                            <FilesManager :booking_id="id" :estimate_id="estimateId" :files="files"
                                          @updateFiles="(e) => {files = e}"></FilesManager>
                        </div>

                    </dl>
                    <div v-if="request">
                        <p><span class="italic">Message d'origine :</span> {{ request.message }}</p>
                        <p class="text-xs"><a :href="'/admin/estimate-requests/'+request.id">Cliquez ici pour accéder à
                            la demande de départ</a></p>
                    </div>
                </div>


                <div v-show="activeTab === 'Options'">
                    <div class="form-group">
                        <label>Raison d'annulation</label>
                        <select v-model="cancellationReasonSelect">
                            <option v-for="reason in cancellationReasons" :value="reason">{{ reason }}</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <div v-show="cancellationReasonSelect === 'other'" class="form-group">
                        <label>Spécifier</label>
                        <input v-model="cancellationReason" maxlength="150"
                               type="text"/>
                    </div>
                    <div class="my-4">
                        <button class="btn danger" @click="displayCancelBookingModal = true">Annuler la réservation
                        </button>
                    </div>

                </div>
                <ConfirmModal :show-modal="displayCancelBookingModal"
                              message="Voulez-vous vraiment annuler la réservation ?"
                              type="danger" @closeModal="displayCancelBookingModal = false" @submit="cancelBooking"
                />


            </div>

        </div>
    </div>

    <EditReferentModal :booking-id="id" :current-referent="referent" :estimate-id="estimateId"
                       :show-modal="editReferentModalDisplay" @closeModal="updateReferent"/>

</template>


<script>

import EstimateContentEditor from "../estimate-editor/EstimateContentEditor";
import AgendaBookingEditor from "../estimate-editor/AgendaBookingEditor";
import ConfirmModal from "../../ConfirmModal";
import FilesManager from "../FilesManager";
import EditReferentModal from "../EditReferentModal";

export default {
    name: "BookingEditor",
    components: {EditReferentModal, FilesManager, EstimateContentEditor, AgendaBookingEditor, ConfirmModal},
    data() {
        return {
            id: 0,
            estimateId: 0,
            date: '',
            partners: [],
            user: {},
            createdAt: '',
            startsAt: '',
            endsAt: '',
            lines: [],
            agendaElements: [],
            availableSpaces: [],
            invoices: [],
            numGuests: 0,
            request: {},
            status: '',
            internalNote: '',
            files: [],
            organization: {},
            referent: {},

            editReferentModalDisplay: false,

            cancellationReasonSelect: '',
            cancellationReason: '',
            cancellationReasons: ['Pas de disponibilité', "Date reportée", "Demande non qualifiée", "Événement client annulé", "Lieu non adapté à l'événement", "Injoignable", "Budget Insuffisant", "A trouvé une autre salle"],


            activeTab: 'Général',
            tabs: [
                {name: 'Général', notStatus: []},
                {name: 'Facturation', notStatus: []},
                {name: 'Options', notStatus: ['cancelled']},
                {name: 'Contenu', notStatus: []},
            ],

            displayCancelBookingModal: false,

            bookingColors: {
                option_request: 'blue',
                option: 'green',
                confirmation: 'red',
                partner_option: 'orange',
                partner_confirmation: 'black',
                cancelled: 'pink',
            },
            bookingStatuses: {
                option_request: "Demande d'option",
                option: 'Option',
                confirmation: 'Confirmation',
                partner_option: 'Option partenaire',
                partner_confirmation: 'Confirmation partenaire',
                cancelled: 'Annulation',
            },
        };
    },

    mounted() {
        this.id = document.getElementById('bookingId').value;
        axios.get('/admin/bookings/' + this.id + '/json').then(res => {
            this.status = res.data.status;
            this.date = res.data.booking_date;
            this.user = res.data.user
            this.createdAt = res.data.created_at
            this.startsAt = res.data.starts_at
            this.endsAt = res.data.ends_at
            this.lines = res.data.estimate?.lines
            this.estimateId = res.data.estimate?.id
            this.partners = res.data.partners
            this.agendaElements = res.data.agenda_elements
            this.request = res.data.request
            this.internalNote = res.data.internal_note
            this.files = res.data.files
            this.organization = res.data.organization
            this.referent = res.data.referent
            this.availableSpaces = res.data.available_spaces;

            if (this.status === 'cancelled') {
                if (this.cancellationReasons.includes(res.data.cancellation_reason)) {
                    this.cancellationReasonSelect = res.data.cancellation_reason;
                } else {
                    this.cancellationReasonSelect = "other";
                    this.cancellationReason = res.data.cancellation_reason;
                }
            }
        });
    },

    methods: {
        removeElement(id) {
            this.agendaElements = this.agendaElements.filter(e => e.id !== id);
        },
        addElement(el) {
            this.agendaElements.push(el);
        },
        updateReferent(ref) {
            this.referent = ref;
            this.editReferentModalDisplay = false;
        },
        cancelBooking() {
            axios.post(`/admin/api/bookings/${this.id}/cancel`, {
                cancellation_reason: this.cancellationReasonSelect === 'other' ? this.cancellationReason : this.cancellationReasonSelect
            }).then(res => {
                window.location.reload()
            });
        },


        updateNote() {
            axios.post(`/admin/api/bookings/${this.id}/update-note`, {
                note: this.internalNote
            })
        },
    }
}
</script>
