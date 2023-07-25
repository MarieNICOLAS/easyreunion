<template>
    <Modal
        :onClose="closeModal"
        :showModal="showModal"
    >
        <h3>{{ isCreate ? "Ajouter" : "Modifier" }} un élément</h3>
        <hr/>

        <div class="text-left">
            <p class="text-red">{{ error }}</p>
            <div class="form-group">
                <label>Description</label>
                <input v-model="agendaElement.name" type="text"/>
            </div>

            <div class="grid md:grid-cols-2">
                <div class="form-group pt-5">
                    <label>Début</label>
                    <input v-model="startDate" type="date"/>
                </div>
                <div class="form-group">
                    <label>Heure</label>
                    <select v-model="startHour">
                        <option v-for="index in 24" :value="time2Digits(index - 1)">{{ index - 1 }}</option>
                    </select>
                    <select v-model="startMinute" class="mx-1">
                        <option value="00">00</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div class="form-group pt-5">
                    <label>Fin</label>
                    <input v-model="endDate" type="date"/>
                </div>
                <div class="form-group">
                    <label>Heure</label>
                    <select v-model="endHour">
                        <option v-for="index in 24" :value="time2Digits(index - 1)">{{ index - 1 }}</option>
                    </select>
                    <select v-model="endMinute" class="mx-1">
                        <option value="00">00</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>
            <div v-show="!isCreate" class="form-group">
                <label>Type</label>
                <p v-show="agendaElement.has_conflicts" class="text-red">Un évènement confirmé est en conflit avec cette
                    élément, qui ne peut donc pas être confirmé</p>
                <select v-model="agendaElement.status" name="type">
                    <option v-if="!isAdmin" value="partner_option">Option partenaire</option>
                    <option v-if="!isAdmin && !agendaElement.has_conflicts" value="partner_confirmation">Confirmation
                        partenaire
                    </option>
                    <option v-if="isAdmin && agendaElement.estimate_request_id" value="option_request">Demande
                        d'option
                    </option>
                    <option v-if="isAdmin" value="option">Option</option>
                    <option v-if="isAdmin && !agendaElement.has_conflicts" value="confirmation">Confirmation</option>
                    <option v-if="isAdmin" value="cancelled">Annulation</option>
                </select>
            </div>

            <div v-if="isAdmin" v-show="agendaElement.status === 'cancelled' && !isCreate" class="form-group">
                <label>Raison d'annulation</label>
                <select v-model="cancellationReasonSelect">
                    <option v-for="reason in cancellationReasons" :value="reason">{{ reason }}</option>
                    <option value="other">Autre</option>
                </select>
            </div>

            <div v-if="isAdmin" v-show="agendaElement.status === 'cancelled' && cancellationReasonSelect === 'other'"
                 class="form-group">
                <label>Spécifier</label>
                <input v-model="cancellationReason" maxlength="150"
                       type="text"/>
            </div>

            <div class="form-group">
                <label>Salle</label>
                <select v-model="agendaElement.agenda_id">
                    <option v-for="space in available_spaces" :value="space.agenda.id">{{ space.name }}</option>
                </select>
            </div>


        </div>

        <div class="flex items-center justify-center">
            <button class="btn dark mx-4 h-in" @click="closeModal">Annuler</button>
            <button class="btn success h-in mx-4" @click="addElement">{{ isCreate ? "Ajouter" : "Mettre à jour" }}</button>
        </div>
    </Modal>
</template>

<script>
import Modal from '../../Modal';

export default {
    props: ['showModal', 'agendaElement', 'available_spaces', 'estimate_id', 'booking_id', 'isCreate'],
    emits: ['closeModal', 'addElement'],
    components: {Modal},
    data() {
        return {
            isAdmin: document.getElementById('baseURL'),

            availableSpaces: [],
            error: '',

            // Agenda element
            startDate: '',
            endDate: '',
            startHour: '12',
            startMinute: '00',
            endHour: '16',
            endMinute: '30',

            cancellationReasonSelect: '',
            cancellationReason: '',
            cancellationReasons: ['Pas de disponibilité', "Date reportée", "Demande non qualifiée", "Événement client annulé", "Lieu non adapté à l'événement", "Injoignable", "Budget Insuffisant", "A trouvé une autre salle"],

        }
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        addElement() {
            if (!this.isCreate)
                return this.updateElement();

            let start = this.startDate + 'T' + this.startHour + ':' + this.startMinute;
            let end = this.endDate + 'T' + this.endHour + ':' + this.endMinute;
            axios.post('/partner/api/agendas/add-element', {
                name: this.agendaElement.name,
                agenda_id: this.agendaElement.agenda_id,
                start: start,
                end: end,
                estimate_id: this.estimate_id,
                booking_id: this.booking_id
            }).then(res => {
                this.$emit('add-element', res.data.data)
                this.closeModal();
            })

        },
        updateElement() {
            let start = this.startDate + 'T' + this.startHour + ':' + this.startMinute;
            let end = this.endDate + 'T' + this.endHour + ':' + this.endMinute;

            axios.post(`/api/calendar-elements/${this.agendaElement.id}/update`, {
                start: start,
                end: end,
                status: this.agendaElement.status,
                name: this.agendaElement.name,
                agenda_id: this.agendaElement.agenda_id,
                cancellation_reason: this.cancellationReasonSelect === 'other' ? this.cancellationReason : this.cancellationReasonSelect,
            }).then(res => {
                this.closeModal();
            })
        },
        time2Digits(time) {
            return (time < 10 ? '0' : '') + time;
        },
    },
    watch: {
        agendaElement: function (newVal, oldVal) { // watch it
            this.startDate = newVal.start.substring(6, 10) + '-' + newVal.start.substring(3, 5) + '-' + newVal.start.substring(0, 2);
            this.endDate = newVal.end.substring(6, 10) + '-' + newVal.end.substring(3, 5) + '-' + newVal.end.substring(0, 2);

            this.startHour = newVal.start.substring(13, 15);
            this.endHour = newVal.end.substring(13, 15);

            this.startMinute = newVal.start.substring(16, 18);
            this.endMinute = newVal.end.substring(16, 18);

            if (newVal.status === 'cancelled') {
                if (this.cancellationReasons.includes(newVal.booking?.cancellation_reason)) {
                    this.cancellationReasonSelect = newVal.booking.cancellation_reason;
                } else {
                    this.cancellationReasonSelect = "other";
                    this.cancellationReason = newVal.booking?.cancellation_reason;
                }
            }
        },
    },
}
</script>
