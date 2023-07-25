<template>
    <div class="col-span-2">
        <p class="font-bold">Fichiers</p>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    scope="col">Nom
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                    scope="col">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="file in files" class="bg-white cursor-pointer">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ file.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <a :href="file.url_view" class="mx-2">Voir</a>
                    <a @click="deleteFileModalOpen(file.id)">Supprimer</a>
                </td>
            </tr>
            </tbody>
        </table>
        <p><a class="underline text-sm cursor-pointer" @click="addNewFile = !addNewFile">Cliquez ici pour ajouter un
            fichier</a></p>
        <div v-show="addNewFile" class="w-full">
            <div class="form-group">
                <label>Fichier</label>
                <input type="file" @change="uploadFile" ref="file"/>
            </div>
            <a class="btn success h-in" @click="submitFile">Ajouter</a>
        </div>
    </div>

    <ConfirmModal :show-modal="confirmDeleteModal" message="Voulez-vous vraiment supprimer ce fichier ?"
                  type="danger"
                  @closeModal="confirmDeleteModal = !confirmDeleteModal" @submit="deleteFile"/>
</template>

<script>
import ConfirmModal from "../ConfirmModal";

export default {
    components: {ConfirmModal},
    props: ['files', 'estimate_id', 'booking_id'],
    emit: ['updateFiles'],
    data() {
        return {
            addNewFile: false,
            file: null,

            confirmDeleteModal: false,
            deleteFileId: 0,
        }
    },
    methods: {
        uploadFile() {
            this.file = this.$refs.file.files[0];
        },
        submitFile() {
            const formData = new FormData();
            formData.append('file', this.file);
            formData.append('type', 'File');
            if (this.estimate_id)
                formData.append('estimate_id', this.estimate_id);
            if (this.booking_id)
                formData.append('booking_id', this.booking_id);
            const headers = {'Content-Type': 'multipart/form-data'};
            axios.post('/admin/api/files', formData, {headers}).then((res) => {
                this.files.push(res.data.data);
                this.addNewFile = false;
            });
        },
        deleteFileModalOpen(fileId) {
            this.deleteFileId = fileId;
            this.confirmDeleteModal = true;
        },
        deleteFile() {
            axios.get(`/admin/api/files/delete/${this.deleteFileId}`).then((res) => {
                this.confirmDeleteModal = false;
                this.$emit('updateFiles',this.files.filter(e => e.id !== this.deleteFileId));
            });
        },
    }
}
</script>
