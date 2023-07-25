<template>
    <h2>Liste des partenaires
        <button class="btn info float-right text-sm h-in" @click="displayAddPartner = !displayAddPartner">Ajouter</button>
    </h2>
    <table>
        <thead>
        <tr>
            <th>Nom du partenaire</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="partner in partners">
            <td><a :href="'/admin/partners/show/'+partner.id">{{ partner.company }}</a></td>
        </tr>

        </tbody>
    </table>
    <div class="mt-3.5" v-show="totalPages > 1">
        <button class="btn info text-sm h-in" v-show="currentPage > 1" @click="previousPage">Précédent</button>
        Page {{ currentPage }} / {{ totalPages }}
        <button class="btn info text-sm h-in" v-show="currentPage < totalPages" @click="nextPage">Suivant</button>
    </div>

    <div v-show="displayAddPartner">
        <div class="form-group">
            <label>Nom du partenaire</label>
            <input v-model="newPartnerName" type="text"/>
        </div>
        <button class="btn success h-in" @click="addPartner">Ajouter</button>
    </div>
</template>


<script>

export default {
    name: "PartnersIndex",
    data() {
        return {
            partners: [],
            currentPage: 1,
            totalPages: 1,

            displayAddPartner: false,
            newPartnerName: '',
        };
    },

    mounted() {
        this.loadPartners();
    },
    methods: {
        loadPartners: function () {
            axios.get('/admin/api/partners?page=' + this.currentPage).then(res => {
                this.partners = res.data.data
                this.totalPages = res.data.last_page
            });
        },
        addPartner: function () {
            axios.post('/admin/api/partners', {
                name: this.newPartnerName,
            }).then(res => {
                window.location = res.data.data.url;
            })
        },
        nextPage() {
            this.currentPage++;
            this.loadPartners();
        },
        previousPage() {
            this.currentPage--;
            this.loadPartners();
        },
    }

}
</script>
