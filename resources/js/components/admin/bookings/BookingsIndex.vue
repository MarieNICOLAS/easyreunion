<template>
    <div class="grid md:grid-cols-2 xl:grid-cols-4">
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
            <span class="font-bold text-sm">Statut</span> <br/>
            <select v-model="status" @change="updateFilter">
                <option value="all">Tous</option>
                <option value="confirmation">Réservation confirmées</option>
                <option value="option">Options</option>
            </select>
        </div>
        <div v-if="isAdmin">
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
                            scope="col"> Client
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col">
                            Date
                        </th>
                        <th v-if="isAdmin"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col">
                            Référent
                        </th>
                        <th v-if="isAdmin"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            scope="col">
                            Statut
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="booking in bookings" class="bg-white cursor-pointer"
                        @click="goTo(booking.id)">
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                          {{ booking.organization?.name ?? booking.user?.first_name + ' ' + booking.user?.last_name }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{ booking.starts_at?.substring(0, 10) }}
                      </td>
                      <td v-if="isAdmin" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{ booking.referent ? booking.referent.first_name + ' ' + booking.referent.last_name : '' }}
                      </td>
                      <td v-if="isAdmin"
                          :class="'px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-bold text-' +bookingColors[booking.status]">
                        {{ bookingStatuses[booking.status] }}
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
    name: "BookingsIndex",
    components: {ReferentFilter, SpaceFilter},
    data() {
        return {
            page: 1,
            totalPages: 1,
            bookings: [],

            minGuests: 0,
            maxGuests: 0,
            spaces: [],
            selectedReferent: parseInt(localStorage.bookingReferent) ?? null,

            status: 'confirmation',
            startDate: '',
            endDate: '',
            isAdmin: document.getElementById('baseURL'),

            bookingColors: {
                option_request: 'blue',
                option: 'green',
                confirmation: 'red',
            partner_option: 'orange',
            partner_confirmation: 'black',
            cancelled: 'pink',
          },
          bookingStatuses: {
            option_request: "Demande d'option",
            option: 'Option',
            confirmation: 'Confirmation',
            partner_option: 'Option partenaire',
            partner_confirmation: 'Confirmation partenaire',
            cancelled: 'Annulation',
          },
        }
    },
    mounted() {
        this.reload();
    },
    methods: {
        reload() {
            let params = `?page=${this.page}&status=${this.status}&`;
            if (this.spaces.length > 0)
                params += `spaces=${this.spaces.join(',')}&`;
            if (this.startDate !== '' && this.endDate !== '')
                params += `start=${this.startDate}&end=${this.endDate}`;
            if (this.selectedReferent)
                params += `referent=${this.selectedReferent}&`;
            axios.get('/api/bookings' + params).then(res => {
                let data = res.data.data;
                this.bookings = data.data;
                this.totalPages = data.last_page;
            })
        },
        goTo(id) {
            if (this.isAdmin)
                window.location = '/admin/bookings/' + id;
            else
                window.location = '/partner/bookings/' + id;
        },
        updateSpaceFilter(spaces) {
            this.spaces = spaces;
            this.updateFilter();
        },
        emptyFilters() {
            this.startDate = '';
            this.endDate = '';
            this.spaces = '';
            this.selectedReferent = null;
            localStorage.bookingReferent = null;
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
            localStorage.bookingReferent = newVal;
            this.reload();
        },
    }
}
</script>
