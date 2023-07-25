<template>
    <Modal :showModal="showModal" @onClose="close">
        <h3>Nouveau message</h3>
        <hr/>

        <div class="md:w-2/3 mx-auto mb-4">
            <div class="form-group">
                <label>Sujet</label>
                <input v-model="topic" type="text"/>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea v-model="content"></textarea>
            </div>
        </div>

        <div class="flex items-center justify-center">
            <button class="btn dark mx-8 h-in" @click="close">Annuler</button>
            <button :class="'btn success mx-8 h-in'" @click="sendMessage">Envoyer</button>
        </div>
    </Modal>
</template>

<script>
import Modal from "../../Modal";

export default {
    name: "NewMessageModal",
    components: {Modal},
    props: ['showModal'],
    emits: ['closeModal'],
    data() {
        return {
            content: '',
            topic: '',
        }
    },
    methods: {
        sendMessage() {
            axios.post('/api/messages', {
                topic: this.topic,
                message: this.content,
                type: 'support',
            }).then(res => {
                window.location.reload()
            })
        },
        close() {
            this.$emit('closeModal');
        }
    },
}
</script>

<style scoped>

</style>
