<template>
    <Modal :showModal="showModal" @onClose="closeModal">
        <h3>Confirmation</h3>
        <hr/>

        <p class="my-8">{{ message }}</p>

        <div class="flex items-center justify-center">
            <button class="btn dark mx-8 h-in" @click="close">Annuler</button>
            <button :class="'btn mx-8 h-in' + type " @click="onSubmit">Confirmer</button>
        </div>
    </Modal>
</template>
<script>
import Modal from "./Modal";

export default {
    name: "ConfirmModal",
    components: {Modal},
    props: ['showModal', 'closeModal', 'message', 'onSubmit', 'type'],
    emits: ['closeModal'],
    methods: {
        close() {
            this.$emit('closeModal');
        }
    }
}
</script>
