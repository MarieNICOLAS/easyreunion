<template>
    <Modal
        :onClose="closeModal"
        :showModal="showModal"
    >
        <h3>Créer une option</h3>
        <hr/>

        <div class="text-left">
            <p class="text-red">{{ error }}</p>
            <div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="form-group pt-5">
                        <label>Début</label>
                        <input v-model="startDate" type="date"/>
                    </div>
                    <div class="form-group pt-5">
                        <label>Fin</label>
                        <input v-model="endDate" type="date"/>
                    </div>

                    <div class="form-group">
                        <label>Forfait</label>
                        <select v-model="timeType">
                            <option value="am">Matinée (8h30-12h30)</option>
                            <option value="pm">Après-midi (13h30-18h00)</option>
                            <option value="evening">Soirée (18h30-22h30)</option>
                            <option value="day">Journée (8h30-18h00)</option>
                            <option value="custom">Personnalisé</option>
                        </select>
                    </div>

                    <div v-show="timeType === 'custom'">
                        <div class="form-group">
                            <label>Heure de début</label>
                            <select v-model="startHour">
                                <option v-for="index in 24" :value="index - 1">{{ index - 1 }}</option>
                            </select>
                            <select v-model="startMinute" class="mx-1">
                                <option value="00">00</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Heure de fin</label>
                            <select v-model="endHour">
                                <option v-for="index in 24" :value="index - 1">{{ index - 1 }}</option>
                            </select>
                            <select v-model="endMinute" class="mx-1">
                                <option value="00">00</option>
                                <option value="30">30</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Merci de renseigner l'adresse email du client</label>
                    <input v-model="email" type="email"/>
                </div>

                <div v-show="emailConfirmed && user_id === null">
                    <div class="form-group">
                        <label>Prénom</label>
                        <input v-model="first_name" type="text"/>
                    </div>

                    <div class="form-group">
                        <label>Nom</label>
                        <input v-model="last_name" type="text"/>
                    </div>

                    <div class="form-group">
                        <label>Entreprise</label>
                        <input v-model="company_name" type="text"/>
                    </div>

                    <a class="btn info h-in" @click="createUser">Suivant</a>

                </div>

                <div class="flex items-center justify-center">
                    <button class="btn dark mx-4 h-in" @click="closeModal">Annuler</button>
                    <a v-show="!emailConfirmed" class="btn info h-in" @click="searchUser">Suivant</a>
                    <button v-show="canSubmit" class="btn success mx-4 h-in" @click="addElement">Envoyer</button>
                </div>
            </div>

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

            email: '',
            emailConfirmed: false,

            // Estimate
            user_id: null,
            first_name: '',
            last_name: '',
            company_name: '',

            text: '',
            error: '',

            // Agenda element
            timeType: 'am',
            startHour: '12',
            startMinute: '00',
            endHour: '16',
            endMinute: '30',
        }
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        addElement() {
            axios.post('/admin/api/estimates', {
                user_id: this.user_id,
            }).then(res => {
                let estimateId = res.data.id;

                const start = new Date(this.startDate);
                const end = new Date(this.endDate);

                let loop = new Date(start);
                while (loop <= end) {
                    let startDatetime = loop.toISOString().split('T')[0] + 'T' + this.startTime;
                    let endDatetime = loop.toISOString().split('T')[0] + 'T' + this.endTime;

                    axios.post('/partner/api/agendas/add-element', {
                        estimate_id: estimateId,
                        agenda_id: this.agendaId,
                        start: startDatetime,
                        end: endDatetime,
                        name: this.company_name,
                        type: 'option',
                    })
                        .then(res => {
                            if (new Date(loop.valueOf()).setDate(loop.getDate() + 1) >= end)
                                window.location = '/admin/estimates/' + estimateId;
                        }).catch((error) => {
                        if (error.response)
                            this.error = error.response.data.message;
                    })


                    let newDate = loop.setDate(loop.getDate() + 1);
                    loop = new Date(newDate);
                }


            });

        },
        searchUser() {
            this.user_id = null;
            axios.get('/admin/api/users/search?email=' + this.email.replace(/ /g, '')).then(res => {
                if (res.data.id) {
                    this.user_id = res.data.id;
                    this.company_name = res.data.organization?.name ?? (res.data.first_name + ' ' + res.data.last_name);
                }
                this.emailConfirmed = true;
            })
        },
        createUser() {
            axios.post('/admin/api/users/store', {
                email: this.email,
                first_name: this.first_name,
                last_name: this.last_name,
                company_name: this.company_name,
            }).then(res => {
                this.user_id = res.data.id;
            });
        },
        time2Digits(time) {
            return (time < 10 ? '0' : '') + time;
        },
    },
    computed: {
        canSubmit: function () {
            return this.user_id !== null;
        },

        startTime: function () {
            switch (this.timeType) {
                case 'custom':
                    return this.time2Digits(this.startHour) + ':' + this.startMinute + ':00'
                case 'am':
                    return '08:30:00'
                case 'pm':
                    return '13:30:00';
                case 'day':
                    return '08:30:00';
                case 'evening':
                    return '18:30:00';
            }
        },

        endTime: function () {
            switch (this.timeType) {
                case 'custom':
                    return this.time2Digits(this.endHour) + ':' + this.endMinute + ':00'
                case 'am':
                    return '12:30:00'
                case 'pm':
                    return '18:00:00';
                case 'day':
                    return '18:00:00';
                case 'evening':
                    return '22:30:00';
            }
        },
    },
    watch: {
        time: function (newVal, oldVal) {
            this.timeType = newVal;
        }
    },
}
</script>
