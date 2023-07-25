<template>
    <Modal
        :onClose="closeModal"
        :showModal="showModal"
    >
        <h3>Ajouter un élément</h3>
        <hr/>

        <div class="text-left">
            <p>Ajouter un élément à l'agenda</p>
            <p class="text-red">{{ error }}</p>
            <div class="form-group">
                <label>Description</label>
                <input v-model="text" type="text"/>
            </div>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="form-group pt-5">
                    <label>Début</label>
                    <input v-model="startDate" type="date"/>
                </div>
                <div class="form-group">
                    <label>Heure</label>
                    <select v-model="startHour">
                        <option v-for="index in 24" :value="index - 1">{{ index - 1 }}</option>
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
                        <option v-for="index in 24" :value="index - 1">{{ index - 1 }}</option>
                    </select>
                    <select v-model="endMinute" class="mx-1">
                        <option value="00">00</option>
                        <option value="30">30</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label>Type</label>
                <select v-model="type" name="type">
                    <option value="partner_option">Option partenaire</option>
                    <option value="partner_confirmation">Confirmation partenaire</option>
                </select>
            </div>


        </div>

        <div class="flex items-center justify-center">
            <button class="btn dark mx-4 h-in" @click="closeModal">Annuler</button>
            <button class="btn success mx-4 h-in" @click="addElement">Envoyer</button>
        </div>
    </Modal>
</template>
<script>
import Modal from '../Modal';

export default {
    props: ['showModal', 'agendaId', 'startDate', 'endDate', 'time'],
    emits: ['closeModal'],
    components: {Modal},
    data() {
        return {
            text: '',
            type: '',
            error: '',

            startHour: '8',
            startMinute: '30',
            endHour: '12',
            endMinute: '30',
        }
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        addElement() {
            axios.post('/partner/api/agendas/add-element', {
                agenda_id: this.agendaId,
                start: this.start,
                end: this.end,
                name: this.text,
                type: this.type,
            })
                .then(res => {
                    this.closeModal();
                }).catch((error) => {
                this.error = error.response.data.message;
            })
        },
        time2Digits(time) {
            return (time < 10 ? '0' : '') + time;
        },
    },
    computed: {
        start: function () {
            return this.startDate + 'T' + this.time2Digits(this.startHour) + ':' + this.startMinute + ':00';
        },
        end: function () {
            return this.startDate + 'T' + this.time2Digits(this.endHour) + ':' + this.endMinute + ':00';
        },
    },
    watch: {
        time: function (newVal, oldVal) {
            if (newVal === "am") {
                this.startHour = '8';
                this.startMinute = '30';
                this.endHour = '12';
                this.endMinute = '30';
            } else if (newVal === "pm") {
                this.startHour = '13';
                this.startMinute = '30';
                this.endHour = '18';
                this.endMinute = '00';
            } else {
                this.startHour = '18';
                this.startMinute = '30';
                this.endHour = '22';
                this.endMinute = '30';
            }
        }
    },
}
</script>
