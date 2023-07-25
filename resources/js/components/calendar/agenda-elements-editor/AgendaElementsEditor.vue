<template>
    <a class="mb-3 md:my-0 float-left btn info text-sm h-in" href="/calendar">
        <svg class="h-6 w-6 mr-3" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" stroke-linecap="round"
                  stroke-linejoin="round"/>
        </svg>
        Retour à l'agenda
    </a>
    <a v-if="isAdmin" class="float-right btn success h-in" @click="displayAddElementModal = true;">Ajouter</a>
    <div>
        <h2 class="text-center w-full">Réservations pour le {{ displayDate }}</h2>

        <table>
            <thead>
            <tr>
                <th>Nom</th>
                <th>Statut</th>
                <th>Référent</th>
                <th>Horaires</th>
                <th>Action</th>
                <th>Création</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="element in elements">
                <td>{{ element.name }}
                    <br/>
                    {{ element.status}}

                    <span v-if="isAdmin">
                        <a v-if="element.booking_id && element.status === 'confirmation'"
                           :href="'/admin/bookings/' + element.booking_id"
                           class="mx-2 btn neutral h-in">Consulter</a>

                        <a v-else-if="element.booking_id && element.status === 'option'"
                           :href="'/admin/bookings/' + element.booking_id"
                           class="mx-2 btn neutral h-in">Consulter</a>

                        <a v-else-if="element.booking_id && element.status === 'cancelled'"
                           :href="'/admin/bookings/' + element.booking_id"
                           class="mx-2 btn neutral h-in">Consulter</a>

                        <a v-else-if="element.estimate_request_id && element.status === 'option_request'"
                           :href="'/admin/estimate-requests/' + element.estimate_request_id"
                           class="mx-2 btn neutral h-in">Consulter</a>

                        <a v-else-if="element.estimate_id" :href="'/admin/estimates/' + element.estimate_id"
                           class="mx-2 btn neutral h-in">Consulter</a>

                    </span>
                </td>
                <td>
                    <span :class="'font-bold text-'+ colors[element.status]"> {{ status[element.status] }}</span>
                </td>
                <td>
                    {{ element.referent ? element.referent.first_name + ' ' + element.referent.last_name : '' }}
                </td>
                <td>du {{ element.start }}<br/>au {{ element.end }}</td>
                <td>
                    <a v-if="(isAdmin && !['partner_option', 'partner_confirmation'].includes(element.status) )|| (['partner_option', 'partner_confirmation'].includes(element.status) && !isAdmin)"
                       class="btn neutral mx-3 h-in" @click="editElement(element)">Modifier</a>
                    <a v-if="(isAdmin && !['partner_option', 'partner_confirmation'].includes(element.status) )|| (['partner_option', 'partner_confirmation'].includes(element.status) && !isAdmin)"
                       class="btn neutral h-in"
                       @click="openDeleteElementModal(element)">
                        Supprimer
                    </a>
                </td>
                <td>
                    {{ element.created_at }}
                    {{ element.created_by }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <UpdateAgendaElementModal :agenda-element="selectedAgendaElement" :available_spaces="availableSpaces"
                              :show-modal="displayEditElementModal"
                              @closeModal="displayEditElementModal = false"/>

    <ConfirmModal :show-modal="displayDeleteElementModal"
                  message="Voulez-vous vraiment supprimer cet élément ?"
                  type="danger" @closeModal="displayDeleteElementModal = false" @submit="deleteElement"
    />

    <CreateOptionModal v-if="isAdmin" :end-date="'20' + date" :show-modal="displayAddElementModal"
                       :space-id="spaceId" :start-date="'20' + date" :agenda-id="agendaId"
                       @closeModal="closeAgendaElementsModal"/>
</template>

<script>

import UpdateAgendaElementModal from "./UpdateAgendaElementModal";
import ConfirmModal from "../../ConfirmModal";
import CreateOptionModal from "../../admin/CreateOptionModal";

export default {
    name: "AgendaElementEditor",
    components: {CreateOptionModal, ConfirmModal, UpdateAgendaElementModal},
    data() {
        return {
            agendaId: document.querySelector('meta[property="agendaId"]').content,
            date: document.querySelector('meta[property="date"]').content,
            displayDate: '',

            isAdmin: document.getElementById('baseURL'),
            elements: [],

            availableSpaces: [],

            displayAddElementModal: false,

            displayEditElementModal: false,
            selectedAgendaElement: {},

            displayDeleteElementModal: false,
            elementToDeleteId: 0,

            spaceId: null,

            colors: {
                option_request: 'blue',
                option: 'green',
                confirmation: 'red',
                partner_option: 'orange',
                partner_confirmation: 'black',
                cancelled: 'pink',
            },
            status: {
                option_request: "Demande d'option",
                option: 'Option',
                confirmation: 'Confirmation',
                partner_option: 'Option partenaire',
                partner_confirmation: 'Confirmation partenaire',
                cancelled: 'Annulation',
            },
        }
    },

    mounted() {
        axios.get(`/api/calendar/${this.agendaId}/date/${this.date}`).then(res => {
            this.elements = res.data.data.elements;
            console.log(this.elements);
            this.availableSpaces = res.data.data.available_spaces;
            this.displayDate = res.data.data.date;
            this.spaceId = res.data.data.space_id;
        })
    },
    methods: {
        editElement(el) {
            this.selectedAgendaElement = el;
            this.displayEditElementModal = true;
        },
        openDeleteElementModal(el) {
            this.elementToDeleteId = el.id;
            this.displayDeleteElementModal = true;
        },
        deleteElement() {
            axios.get(`/api/calendar-elements/${this.elementToDeleteId}/delete`).then(res => {
                this.elements = this.elements.filter(e => e.id !== this.elementToDeleteId);
            })
            this.displayDeleteElementModal = false;
        },
        closeAgendaElementsModal() {
            this.displayAddElementModal = !this.displayAddElementModal;
            window.location.reload()
        },
    },

    computed: {
        countConfirmed() {
            return this.elements.filter(
                element => element.status === 'confirmation'
                || element.status === 'option'
                || element.status === 'partner_confirmation'
            ).length;
        },
        isAuth() {
            return this.countConfirmed === 0;
        }
    }
}


</script>
