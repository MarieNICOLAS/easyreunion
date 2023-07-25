<template>
    <div class="px-2 pt-6 pb-24 sm:px-2 sm:pt-12 lg:px-4 lg:py-6">
        <div class="w-full xl:w-5/6 2xl:w-2/3 mx-auto">
            <div class="float-right">
                <a class="btn success h-in invisible" href="#" @click="yousignModalDisplay = !yousignModalDisplay">Envoyer lien
                    YouSign</a>
            </div>

            <div v-if="organization && organization.sellsy_url" class="float-right">
                <a :href="organization.sellsy_url" class="btn info h-in" target="_blank">Fiche sellsy client</a>
            </div>
            <div class="float-right mx-2">
                <a v-show="!hasConflicts" class="btn success h-in" @click="markEstimateAsSignedModalDisplay = true;">Confirmer</a>
            </div>

            <p class="mt-2 mb-5 text-4xl font-medium tracking-tight sm:text-4xl">Devis {{ organization?.name }} - #{{
                    id
                }}</p>

            <div>
                <div>
                    <div>
                        <label class="sr-only" for="tabs">Choisir une section</label>
                        <select id="tabs" v-model="activeTab"
                                class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                name="tabs">
                            <option v-for="tab in tabs" :key="tab.name" :selected="tab.current">{{ tab.name }}</option>
                        </select>
                    </div>
                    <div class="sm:block">
                        <div class="border-b border-gray-200">
                            <nav aria-label="Tabs" class="-mb-px flex space-x-8">
                                <a v-for="tab in tabs" :key="tab.name"
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

                <h3 class="sr-only">Informations commande</h3>

                <div v-show="activeTab === 'Général'">
                    <h4 class="sr-only">Client</h4>
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
                                <address class="not-italic">
                                <span
                                    class="block">Devis créé le  {{ createdAt }}</span>
                                    <span
                                        class="block">Dates : {{ startsAt }} - {{ endsAt }}</span>
                                    <span
                                        class="block">Statut : <span :class="'font-bold text-'+ colors[status]"> {{
                                            statusList[status]
                                        }}</span> </span>
                                    <span v-if="referent"
                                          class="block">Référent : {{
                                            referent.first_name + ' ' + referent.last_name
                                        }} - <a class="text-xs underline" href="#"
                                                @click="editReferentModalDisplay = true">Modifier</a></span>

                                </address>
                            </dd>
                        </div>
                        <div class="w-full col-span-2 my-3">
                            <AgendaBookingEditor :agenda_elements="agendaElements" :available_spaces="availableSpaces"
                                                 :estimate_id="id"
                                                 @addElement="addElement"
                                                 @removeElement="removeElement"/>
                        </div>
                        <div class="mt-2 col-span-2 md:col-auto">
                            <dt class="font-medium text-gray-900">Note interne</dt>
                            <textarea v-model="internalNote" class="w-full h-36 resize-none"
                                      @change="updateNote"></textarea>
                        </div>
                        <div>
                            <FilesManager :estimate_id="id" :files="files"
                                          @updateFiles="(e) => {files = e}"></FilesManager>
                        </div>
                    </dl>
                    <div v-if="request">
                        <p><span class="italic">Message d'origine :</span> {{ request.message }}</p>
                        <p class="text-xs"><a :href="'/admin/estimate-requests/'+request.id">Cliquez ici pour accéder à
                            la demande de départ</a></p>
                    </div>
                </div>

                <div v-show="activeTab === 'Devis'" class="py-4">
                    <p>Devis</p>

                    <EstimateContentEditor :booking-id="null" :estimate-id="id" :lines="lines"
                                           :partners="partners"></EstimateContentEditor>

                </div>


                <div v-show="activeTab === 'Options'">
                    <p v-show="hasConflicts" class="text-red">Un évènement confirmé est en conflit avec cette
                        réservation,
                        qui ne peut donc pas être confirmé</p>
                    <p class="my-1"><a class="btn info text-sm h-in" href="#" v-show="!hasConflicts"
                                       @click="markEstimateAsSignedModalDisplay = true;">Marquer le devis comme signé
                        manuellement</a></p>

                    <p class="my-1">
                        <input type="checkbox" id="checkbox" v-model="auto_deposit" @change="updateOptions">
                        <label class="mx-2" for="checkbox">Envoyer une facture d'acompte de 50% à la signature</label>
                    </p>
                </div>
                <ConfirmModal
                    :show-modal="markEstimateAsSignedModalDisplay"
                    message="Voulez-vous vraiment convertir ce devis en réservation ? Cette action est irréversible"
                    type="success"
                    @closeModal="markEstimateAsSignedModalDisplay = !markEstimateAsSignedModalDisplay"
                    @submit="markAsSigned"/>

            </div>

        </div>
    </div>

    <SendYouSignLinkModal :id="id" :show-modal="yousignModalDisplay" :user="user"
                          @closeModal="yousignModalDisplay = !yousignModalDisplay"/>

    <EditReferentModal :current-referent="referent" :estimate-id="id" :show-modal="editReferentModalDisplay"
                       @closeModal="updateReferent"/>
</template>


<script>

import EstimateContentEditor from "./EstimateContentEditor";
import AgendaBookingEditor from "./AgendaBookingEditor";
import SendYouSignLinkModal from "./SendYouSignLinkModal";
import ConfirmModal from "../../ConfirmModal";
import FilesManager from "../FilesManager";
import EditReferentModal from "../EditReferentModal";

export default {
    name: "EstimateEditor",
    components: {
        EditReferentModal,
        FilesManager, ConfirmModal, EstimateContentEditor, AgendaBookingEditor, SendYouSignLinkModal
    },
    data() {
        return {
            id: 0,
            date: '',
            partners: [],
            user: {},
            createdAt: '',
            startsAt: '',
            endsAt: '',
            lines: [],
            agendaElements: [],
            availableSpaces: [],
            auto_deposit: true,
            request: {},
            internalNote: '',
            files: [],
            referent: {},
            hasConflicts: false,

            organization: {},

            yousignModalDisplay: false,
            markEstimateAsSignedModalDisplay: false,

            editReferentModalDisplay: false,

            activeTab: 'Général',
            tabs: [
                {name: 'Général'},
                {name: 'Activité'},
                {name: 'Options'},
                {name: 'Devis'},
            ],

            colors: {
                option_request: 'blue',
                option: 'green',
                confirmation: 'red',
                partner_option: 'orange',
                partner_confirmation: 'black',
                cancelled: 'pink',
            },
            statusList: {
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
        this.id = document.getElementById('estimateId').value;
        axios.get('/admin/api/estimates/' + this.id).then(res => {
            this.lines = res.data.data.lines;
            this.partners = res.data.data.partners;
            this.user = res.data.data.user;
            this.agendaElements = res.data.data.agenda_elements;
            this.createdAt = res.data.data.created_at;
            this.startsAt = res.data.data.starts_at;
            this.endsAt = res.data.data.ends_at;
            this.auto_deposit = res.data.data.auto_deposit === 1;
            this.request = res.data.data.request;
            this.internalNote = res.data.data.internalNote;
            this.files = res.data.data.files;
            this.organization = res.data.data.organization;
            this.referent = res.data.data.referent;
            this.status = res.data.data.status;
            this.availableSpaces = res.data.data.available_spaces;

            this.hasConflicts = this.agendaElements.filter(e => e.has_conflicts).length > 0
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

        updateOptions() {
            axios.post(`/admin/api/estimates/${this.id}/update-options`, {
                auto_deposit: this.auto_deposit
            })
        },

        updateNote() {
            axios.post(`/admin/api/estimates/${this.id}/update-note`, {
                note: this.internalNote
            })
        },

        markAsSigned() {
            axios.post(`/admin/api/estimates/${this.id}/mark-as-signed`, {}).then(res => {
                window.location = res.data.data.url;
            })
        },
    }


}
</script>
