<template>
    <select name="address_id" @change="changeSelectedAddress">
        <option v-for="address in addresses" v-bind:value="address.id">{{ address.address_name }}</option>
    </select>
    <div>
        <label>Nom de l'adresse</label>
        <input v-model="selectedAddress.address_name" type="text" @change="update"/>
    </div>
    <div>
        <label>Nom de l'entreprise / personne à facturer</label>
        <input v-model="selectedAddress.customer_name" type="text" @change="update"/>
    </div>
    <div>
        <label>Adresse</label>
        <input v-model="selectedAddress.address" type="text" @change="update"/>
    </div>
    <div>
        <label>Code postal</label>
        <input v-model="selectedAddress.zipcode" type="text" @change="update"/>
    </div>
    <div>
        <label>Ville</label>
        <input v-model="selectedAddress.city" type="text" @change="update"/>
    </div>
    <div>
        <label>Pays</label>
        <input v-model="selectedAddress.country" type="text" @change="update"/>
    </div>
    <a v-show="selectedAddress.id === 0" @click="store">Créer l'adresse</a>
</template>


<script>

export default {
    name: "Addresses",

    data() {
        return {
            addresses: [],
            selectedAddress: {
                id: 0,
                address_name: 'Nouvelle adresse',
                customer_name: '',
                address: '',
                city: '',
                zipcode: '',
                country: ''
            }
        }
    },

    mounted() {
        axios.get('/user/api/addresses').then(res => {
            this.addresses.push(this.selectedAddress)
            this.addresses.push(...res.data);
        });
    },
    methods: {
        store() {
            axios.post('/user/api/addresses', this.selectedAddress).then(res => {
                this.addresses.push(this.selectedAddress)
                this.selectedAddress.id = res.data.id;
            })
        },
        update() {
            // Checking we're not creating an address
            if (this.selectedAddress.id !== 0) {
                axios.post('/user/api/addresses/' + this.selectedAddress.id, {...this.selectedAddress, ...{_method: 'PUT'}});
            }
        },

        delete() {

        },

        changeSelectedAddress(event) {
            this.selectedAddress = this.addresses.filter(add => add.id === parseInt(event.target.value))[0]

        }

    }
}
</script>
