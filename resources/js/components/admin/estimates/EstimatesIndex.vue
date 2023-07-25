<template>
    <a class="btn success float-right h-in" href="/admin/estimates/create">Créer un devis</a>

    <div class="grid md:grid-cols-2 xl:grid-cols-3">
        <div>
            <span class="font-bold text-sm">Période</span> <br/>
            Du <input v-model="startDate" type="date" @change="updateFilter"/> au <input v-model="endDate" type="date"
                                                                                         @change="updateFilter"/>
        </div>
        <div>
            <span class="font-bold text-sm">Espace / Salle</span> <br/>
            <SpaceFilter ref="spaceFilter" :spaces="spaces" @updateParent="updateSpaceFilter"/>
        </div>
        <div>
            <span class="font-bold text-sm">Référent</span> <br/>
            <ReferentFilter :current-admin="selectedReferent" @updateParent="updateReferent"/>
        </div>

    </div>
    <div class="mb-4 mt-2">
        <p class="text-xs"><a href="#" @click="emptyFilters">Vider les filtres</a></p>
    </div>

    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col">Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col">
                            Référent interne
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col">
                            Montant
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="estimate in estimates" class="bg-white cursor-pointer"
                        @click="goTo(estimate.id)">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{
                                estimate.organization?.name ?? estimate.user.first_name + ' ' + estimate.user.last_name
                            }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ estimate.referent ? estimate.referent.first_name + ' ' + estimate.referent.last_name : '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ estimate.updated_at.substring(0, 10) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ estimate.amount_total }}
                            euros
                        </td>
                    </tr>

                    </tbody>
                    <div v-show="totalPages > 1">
                        <button class="btn info text-sm h-in" v-show="page > 1" @click="previousPage">Précédent</button>
                        Page {{ page }} / {{ totalPages }}
                        <button class="btn info text-sm h-in" v-show="page < totalPages" @click="nextPage">Suivant</button>
                    </div>
                </table>

            </div>
        </div>
    </div>
</template>
<script>
import SpaceFilter from "../filters/SpaceFilter";
import ReferentFilter from "../filters/ReferentFilter";

export default {
    name: "EstimatesIndex",
    components: {ReferentFilter, SpaceFilter},
    data() {
        return {
            page: 1,
            totalPages: 1,
            estimates: [],

            spaces: [],

            startDate: '',
            endDate: '',

            selectedReferent: parseInt(localStorage.estimateReferent) ?? null,
        }
    },
    mounted() {
        this.reload();
    },
    methods: {
        reload() {
            let params = `?page=${this.page}&`;
            if (this.spaces.length > 0)
                params += `spaces=${this.spaces.join(',')}&`;
            if (this.selectedReferent)
                params += `referent=${this.selectedReferent}&`;
            if (this.startDate !== '' && this.endDate !== '')
                params += `start=${this.startDate}&end=${this.endDate}`;
            axios.get('/admin/api/estimates' + params).then(res => {
                let data = res.data.data;
                this.estimates = data.data;
                this.totalPages = data.last_page;
            })
        },
        goTo(id) {
            window.location = '/admin/estimates/' + id;
        },
        updateSpaceFilter(spaces) {
            this.spaces = spaces;
            this.updateFilter();
        },
        emptyFilters() {
            this.startDate = '';
            this.endDate = '';
            this.spaces = '';
            this.maxGuests = 0;
            this.minGuests = 0;
            this.selectedReferent = null;
            localStorage.estimateReferent = null;
            this.$refs.spaceFilter.emptySpacesLoaded();
            this.reload();
        },
        nextPage() {
            this.page++;
            this.reload();
        },
        previousPage() {
            this.page--;
            this.reload();
        },
        updateFilter() {
            this.page = 1;
            this.reload();
        },
        updateReferent(newVal) {
            this.selectedReferent = newVal;
            localStorage.estimateReferent = newVal;
            this.reload();
        }
    }
}
</script>
