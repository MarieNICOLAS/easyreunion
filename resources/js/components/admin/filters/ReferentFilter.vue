<template>
    <select v-model="selectedAdminId" @change="updateParent">
        <option v-for="admin in adminList" :value="admin.id">{{ admin.first_name + ' ' + admin.last_name }}</option>
    </select>
</template>
<script>
export default {
    name: "ReferentFilter",
    emits: ['update-parent'],
    props: ['currentAdmin'],
    data() {
        return {
            selectedAdminId: null,
            adminList: [],
        }
    },
    mounted() {
        axios.get('/admin/api/admin-list').then(res => {
            this.adminList = res.data.data;
        }).then(res => {
            this.selectedAdminId = this.currentAdmin;
        })
    },
    methods: {
        updateParent() {
            this.$emit('update-parent', this.selectedAdminId);
        },
    },
    watch: {
        currentAdmin: function (newVal, oldVal) {
            this.selectedAdminId = (newVal);
        }
    }

}
</script>
