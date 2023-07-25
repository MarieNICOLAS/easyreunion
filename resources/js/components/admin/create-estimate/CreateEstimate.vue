<template>


    <div class="bg-white md:w-1/2 mx-auto px-6 py-6">
        <h2>Créer un devis</h2>
        <div class="form-group">
            <label>Merci de commencer par renseigner l'email</label>
            <input v-model="email" type="email" @change="searchUser"/>
        </div>

        <div v-show="user_id === null">
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

            <a class="btn info" @click="createUser">Créer l'utilisateur</a>

        </div>

        <a v-show="user_id !== null" class="btn info" @click="createEstimate">Créer le devis</a>

    </div>
</template>


<script>

export default {
    name: "CreateEstimate",
    data() {
        return {
            email: '',

            // Estimate
            user_id: null,
            first_name: '',
            last_name: '',
            company_name: '',
        };
    },
    methods: {
        searchUser() {
            this.user_id = null;
            axios.get('/admin/api/users/search?email=' + this.email.replace(/ /g, '')).then(res => {
                if (res.data.id) {
                    this.user_id = res.data.id;
                }
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

        createEstimate() {
            axios.post('/admin/api/estimates', {
                user_id: this.user_id
            }).then(res => {
                window.location = '/admin/estimates/' + res.data.id;
            });
        },
    }

}
</script>
