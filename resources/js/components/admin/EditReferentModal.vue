<template>
    <Modal
        :onClose="closeModal"
        :showModal="showModal"
    >
        <h3>Changer le référent</h3>
        <div class="form-group">
            <label>Référent</label>
            <select v-model="currentAdmin">
                <option v-for="admin in adminList" :value="admin.id">{{ admin.first_name + ' ' + admin.last_name }}</option>
            </select>
        </div>

        <input class="btn success h-in" @click="update" value="Modifier" />
    </Modal>
</template>

<script>
import Modal from '../Modal';

export default {
    props: ['showModal', 'estimateId', 'bookingId', 'currentReferent'],
    components: {Modal},
    emits: ['closeModal'],
    data() {
        return {
            adminList: [],
            currentAdmin: 0,
        }
    },
    mounted() {
        axios.get('/admin/api/admin-list').then(res => {
            this.adminList = res.data.data;
        })
    },
    methods: {
        closeModal() {
            this.$emit('closeModal', this.adminList.filter(e => e.id === this.currentAdmin)[0]);
        },
        update() {
            axios.post('/admin/api/update-referent', {
                referent: this.currentAdmin,
                estimate_id: parseInt(this.estimateId),
                booking_id: this.bookingId,
            }).then(res => {
                this.closeModal();
            })
        }
    },
    watch: {
        currentReferent: function (newVal, oldVal) {
            this.currentAdmin = newVal.id;
        }
    }
}
</script>
