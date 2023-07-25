<template>
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">Derniers 7 jours vs 7 jours précédents</h3>
        <dl class="mt-5 grid grid-cols-1 gap-4 rounded-lg overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-3 md:divide-y-0 md:divide-x">
            <div v-for="item in generalStats" :key="item.name" class="px-4 py-5 sm:p-6 bg-white">
                <dt class="text-base font-normal text-gray-900">
                    {{ item.name }}
                </dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-indigo-600">
                        {{ item.stat }}
                        <span class="ml-2 text-sm font-medium text-gray-500"> contre {{ item.previousStat }} </span>
                    </div>

                    <div
                        :class="[item.changeType === 'increase' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800', 'inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium md:mt-2 lg:mt-0']">
                        <ArrowSmUpIcon v-if="item.changeType === 'increase'"
                                       aria-hidden="true"
                                       class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500"/>
                        <ArrowSmDownIcon v-else aria-hidden="true"
                                         class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-red-500"/>
                        <span class="sr-only"> {{
                                item.changeType === 'increase' ? 'Increased' : 'Decreased'
                            }} by </span>
                        {{ item.change }}
                    </div>
                </dd>
            </div>
        </dl>
    </div>

    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-6 text-center">Taux de remplissage</h3>
    <table class="my-4">
        <thead>
        <tr>
            <th>Salle</th>
            <th>Taux de remplissage 1 mois</th>
            <th>L'année dernière même période</th>
        </tr>
        </thead>
        <tbody>

        <tr v-for="space in spaceStats">
            <td>{{ space.name }}</td>
            <td>{{ space.filled }}</td>
            <td>{{ space.filled_last_year }}</td>
        </tr>

        </tbody>
    </table>

</template>

<script setup>
import {ArrowSmDownIcon, ArrowSmUpIcon} from '@heroicons/vue/solid'</script>
<script>

export default {
    data() {
        return {
            generalStats: [],
            spaceStats: [],
        }
    },
    mounted() {
        axios.get(`/admin/api/stats/general`).then(res => {
            this.generalStats = res.data.data;
        })
        axios.get(`/admin/api/stats/spaces`).then(res => {
            this.spaceStats = res.data.data;
        })
    }
}
</script>
