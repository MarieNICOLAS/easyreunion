<template>
    <div v-for="element in lines" class="py-4 border-b border-gray-200 flex space-x-6">
        <div class="flex-auto flex flex-col">
            <div>
                <p class="mt-2 text-sm text-gray-600">
                    {{ element.description }}
                </p>
            </div>
            <div class="mt-4 flex-1 flex items-end">
                <dl class="flex text-sm divide-x divide-gray-200 space-x-4 sm:space-x-6">
                    <div class="flex">
                        <dt class="font-medium text-gray-900">Quantité</dt>
                        <dd class="ml-2 text-gray-700">
                            {{ element.quantity }}
                        </dd>
                    </div>
                    <div class="pl-4 flex sm:pl-6">
                        <dt class="font-medium text-gray-900">Prix unitaire</dt>
                        <dd class="ml-2 text-gray-700">
                            {{ element.unit_price }} euros H.T.
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
    <a class="btn info h-in my-4" @click="addElement = !addElement">Ajouter un élément</a>
    <div v-show="addElement" class="my-4">
        <h4>Ajouter un élément</h4>

        <div>
            <div class="form-group">
                <label>Description</label>
                <input v-model="newElementDescription" type="text"/>
            </div>
            <div class="grid md:grid-cols-3">
                <div class="form-group">
                    <label>Coût unitaire H.T. de l'offre (euros)</label>
                    <div class="w-16">
                        <input v-model="newElementUnitPrice" min="1" type="number"/>
                    </div>
                </div>
                <div class="form-group">
                    <label>Taux de TVA (%)</label>
                    <div class="w-16">
                        <input v-model="newElementTaxRate" max="50" min="0" type="number"/>
                    </div>
                </div>
                <div class="form-group">
                    <label>Quantité</label>
                    <div class="w-16">
                        <input v-model="newElementQuantity" min="1" type="number"/>
                    </div>
                </div>
            </div>

        </div>

        <a class="btn success h-in" @click="addOffer">Ajouter</a>
    </div>
</template>
<script>
export default {
    name: "EstimateContentEditor",
    props: {
        partners: {
            type: Array,
            default: () => []
        },
        estimateId: 0,
        lines: [],
        bookingId: 0,
    },
    data() {
        return {
            date: '',
            user: {},
            createdAt: '',
            startsAt: '2021-02-02',
            endsAt: '2021-02-02',

            // Add an offer
            addElement: false,
            newElementDescription: '',
            newElementUnitPrice: 1,
            newElementQuantity: 1,
            newElementTaxRate: 20,
            newElementSpaceId: null,



        };
    },
    methods: {
        addOffer() {
            axios.post('/admin/api/estimates/' + this.estimateId + '/offer/elements', {
                description: this.newElementDescription,
                quantity: this.newElementQuantity,
                unitPrice: this.newElementUnitPrice,
                startsAt: this.startsAt,
                endsAt: this.endsAt,
                taxRate: this.newElementTaxRate,
                booking_id: this.bookingId
            }).then(res => {
                this.lines.push({
                    description: this.newElementDescription,
                    unit_price: this.newElementUnitPrice,
                    quantity: this.newElementQuantity,
                });
                this.resetForm();
                this.addElement = false;
            });
        },
        resetForm() {
            this.newElementDescription = null;
            this.newElementQuantity = null;
            this.newElementUnitPrice = null;
            this.newElementTaxRate = null;
        }
    },

}
</script>
