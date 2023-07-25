<template>
    <div>
        <p v-show="agenda_elements.length === 0" class="my-4">Aucun blocage dans le calendrier pour cette réservation
            actuellement</p>
        <table v-show="agenda_elements.length > 0" class="my-4">
            <tr>
                <th>Salle</th>
                <th>De</th>
                <th>À</th>
                <th>Action</th>
            </tr>
            <tr v-for="element in agenda_elements">
                <td>{{ element.space.name }} <span v-show="element.has_conflicts" class="text-red">
                    - <a :href="'/calendar/'+element.agenda_id+'/date/'+element.date"
                         class="underline">CONFLIT</a> </span>
                </td>
                <td>{{ element.start }}</td>
                <td>{{ element.end }}</td>
                <td class="flex"><a class="btn neutral h-in" @click="editElement(element)">Modifier</a>
                    <a class="mx-2 btn neutral h-in" @click="openDeleteModal(element.id)">Supprimer</a>
                </td>
            </tr>
        </table>
    </div>
    <ConfirmModal :show-modal="confirmDeleteModal" message="Voulez-vous vraiment supprimer cet élément de l'agenda ?"
                  type="danger"
                  @closeModal="confirmDeleteModal = !confirmDeleteModal" @submit="deleteAgendaElement"/>

    <button class="btn info h-in" @click="addElement">Ajouter un élément</button>

    <UpdateAgendaElementModal :agenda-element="selectedAgendaElement" :show-modal="displayEditElementModal"
                              :available_spaces="available_spaces"
                              :booking_id="booking_id" :estimate_id="estimate_id"
                              :is-create="addElementFormDisplay" @addElement="parentAddElement"
                              @closeModal="displayEditElementModal = false"/>
</template>
<script>
import ConfirmModal from "../../ConfirmModal";
import UpdateAgendaElementModal from "../../calendar/agenda-elements-editor/UpdateAgendaElementModal";

export default {
    name: "AgendaBookingEditor",
    components: {UpdateAgendaElementModal, ConfirmModal},
    props: ['estimate_id', 'booking_id', 'agenda_elements', 'available_spaces'],
    emits: ['remove-element', 'add-element'],
    data() {
        return {
            newElementSpaceId: null,

            start: null,
            end: null,

            agendaId: 0,

            // Modal display
            confirmDeleteModal: false,
            deleteElementId: 0,

            // Add element
            addElementFormDisplay: false,

            // Edit modal
            displayEditElementModal: false,
            selectedAgendaElement: {},
        }
    },
    methods: {
        addElement() {
            this.selectedAgendaElement = {
                name: this.agenda_elements[0].name,
                agenda_id: this.agenda_elements[0].agenda_id,
                start: this.agenda_elements[0].start,
                end: this.agenda_elements[0].end,
                status: "",
            }
            this.addElementFormDisplay = true;
            this.displayEditElementModal = true;
        },

        openDeleteModal(id) {
            this.deleteElementId = id;
            this.confirmDeleteModal = true;
        },
        deleteAgendaElement() {
            axios.post(`/partner/api/agendas/remove-element/${this.deleteElementId}`, {
                _method: "delete"
            }).then(res => {
                this.$emit('remove-element', this.deleteElementId)
                this.confirmDeleteModal = false
            })
        },
        editElement(el) {
            this.selectedAgendaElement = el;
            this.displayEditElementModal = true;
        },
        parentAddElement(el) {
            this.$emit('add-element', el)
        },


    }
}
</script>
