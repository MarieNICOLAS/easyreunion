<template>
    <Modal
        :onClose="closeModal"
        :showModal="showModal"
    >
        <h3>Lien YouSign</h3>
        <hr/>

        <div class="text-left">
            <p>Renseignez à qui vous souhaitez envoyer le devis. Attention ! Le numéro de téléphone sert à valider le
                devis, il est donc impératif de renseigner un numéro correct et valide</p>

            <div class="grid md:grid-cols-2">
                <div class="form-group">
                    <label>Prénom</label>
                    <input v-model="firstName" type="text"/>
                </div>
                <div class="form-group">
                    <label>Nom</label>
                    <input v-model="lastName" type="text"/>
                </div>
            </div>

            <div class="grid md:grid-cols-2">
                <div class="form-group">
                    <label>Email</label>
                    <input v-model="email" type="email"/>
                </div>
                <div class="form-group">
                    <label>Numéro de téléphone</label>
                    <input v-model="phone" type="text"/>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-center">
            <button class="btn dark mx-4 h-in" @click="closeModal">Annuler</button>
            <button class="btn success mx-4 h-in" @click="sendYouSignLink">Envoyer</button>
        </div>
    </Modal>
</template>
<script>
import Modal from '../../Modal';

export default {
    props: ['showModal', 'id', 'user'],
    emits: ['closeModal'],
    components: {Modal},
    data() {
        return {
            firstName: '',
            lastName: '',
            email: '',
            phone: '',
        }
    },
    created() {
        setTimeout(() => {
            this.email = this.user.email;
            this.phone = this.user.phone;
            this.firstName = this.user.first_name;
            this.lastName = this.user.last_name;
        }, 1000);
    },
    methods: {
        closeModal() {
            this.$emit('closeModal')
        },
        sendYouSignLink() {
            axios.post(`/admin/api/estimates/${this.id}/send-yousign-link`, {
                first_name: this.firstName,
                last_name: this.lastName,
                email: this.email,
                phone: this.phone,
            }).then(res => {
                this.closeModal()
            })
        }
    }
}
</script>
