<template>
        <div class="bg-white text-black overflow-auto border rounded-md border-gray-300 my-10">

            <div class="grid md:grid-cols-3 gap-8 py-2">

                <label class="flex flex-1 items-center">
                    <select id="selectCity" v-model="filters.city" class="border-0 flex-1 w-2/4 optionFont" name="city"
                            @change="filtersUpdated">
                        <option selected="" value="">Choisir une ville</option>
                        <optgroup label="Localisation">
                            <option v-for="city in availableCities" :value="city">{{ city }}</option>
                        </optgroup>
                    </select>
                </label>

                <label class="flex flex-1 items-center">
                    <select id="selectType" v-model="filters.type" class="border-0 flex-1 w-2/4 optionFont" name="type"
                            @change="filtersUpdated">
                        <option selected="selected" value="">Type d'événement</option>
                        <optgroup label="Type">
                            <option v-for="type in tags" :value="type" :selected="type === 'meeting'">{{ translateTag(type) }}</option>
                        </optgroup>
                    </select>
                </label>

                <label class="flex flex-1 items-center">

                    <input v-model="filters.numGuests" class="border-0 flex-1 w-2/4 optionFont" placeholder="Nombre de participants"
                           type="number" @change="filtersUpdated">
                </label>

            </div>
        </div>


    <div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-6 mx-auto">

            <article v-for="space in spaces" id="articleSpace" class="h-full w-full boxShadow">


                <figure class="relative">
                    <a :href="space.full_url">
                        <ul class="carousel aspect-video flex flex-nowrap w-full h-64 overflow-hidden bg-gray-200"
                                style="--carousel-index: 0;">

                                <li v-for="image in space.thumbnail_images"
                                    class="transition transform slide w-full h-full flex-grow flex-shrink-0 flex-basis-[auto] relative"
                                    style="--tw-translate-x: calc(var(--carousel-index) * -100%)">
                                    <img
                                        :alt="space.name"
                                        :src="image"
                                        class="w-full h-auto object-contain object-center absolute top-1/2 transform -translate-y-1/2">

                                </li>

                        </ul>
                    </a>
                    <ul class="controls absolute bottom-0 right-0 flex justify-between gap-x-0.5" style="width: 100%;">
                        <li>
                            <button
                                class="grid place-content-center easyBtn bg-opacity-70 hover:bg-opacity-100 text-white text-lg py-0.5 px-2"
                                onclick="const carousel = this.closest('figure').querySelector('.carousel'), index = +getComputedStyle(carousel).getPropertyValue('--carousel-index'); carousel.style.setProperty('--carousel-index', Math.max(0, index - 1))">
                                &lt;
                            </button>
                        </li>
                        <li>
                            <button
                                class="grid place-content-center easyBtn bg-opacity-70 hover:bg-opacity-100 text-white text-lg py-0.5 px-2"
                                onclick="const carousel = this.closest('figure').querySelector('.carousel'), numberItems = carousel.children.length - 1, index = +getComputedStyle(carousel).getPropertyValue('--carousel-index');  carousel.style.setProperty('--carousel-index', Math.min(numberItems, index + 1))">
                                &gt;
                            </button>
                        </li>
                    </ul>
                </figure>
                <section class="flex flex-col w-full divide-y divide-gray-200 border-gray-200 border-l border-r"
                         role="contentinfo">
                    <div class="flex w-full flex-1 divide-x">
                        <article
                            class="flex flex-grow justify-between items-center text-xs py-2 px-2 whitespace-nowrap">
                            <span>{{ space.capacity_max }} personnes</span>

                        </article>

                        <article class="flex-grow grid place-content-center text-xs py-2 px-2 whitespace-nowrap">
                            <span class="flex gap-x-2 flex-nowrap"><span
                                class="hidden lg:block">Salle de </span>{{ space.area }}m²</span>
                        </article>

                        <article class="flex-1 py-2 px-2 grid place-content-center whitespace-nowrap">
                                 <span v-if="space.has_disabled_access" class="h-4 w-4">
                                <img alt="acces handicap" class="w-full h-auto" src="/images/wheelchair-solid.svg">
                            </span>
                        </article>
                    </div>
                    <a :href="space.full_url">
                        <article
                            class="flex-grow w-full py-2 px-2 font-bold text-center transition hover:bg-primary hover:text-white">
                            <span>{{ space.name }}</span>
                        </article>
                    </a>
                    <a :href="space.parent_full_url">
                        <article>
                            <button
                                class="transition font-semibold text-center text-white easyBtn hover:text-white grid place-content-center hover:bg-primary w-full py-2 px-2">
                                {{ space.space_group?.name }}
                            </button>
                        </article>
                    </a>
                </section>
            </article>
        </div>

        <div class="flex mt-3">
            <a class="btn info mx-auto h-in" @click="loadMore">Charger +</a>
        </div>
    </div>

</template>


<script>
export default {
    data() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        return {
            page: 1,
            spaces: [],
            tags: [],
            availableCities: [],
            filters: {
                city: urlParams.get('city') ?? "",
                numGuests: urlParams.get('attendees'),
                type: urlParams.get('type'),
            }
        }
    },

    mounted() {
        axios.get('/api/cities-and-tags').then(res => {
            this.availableCities = res.data.cities;
            this.tags = res.data.tags
        })
        this.loadMore();
    },
    methods: {
        loadMore() {
            let addReq = `?page=${this.page}`
            if (this.filters.city && this.filters.city !== "")
                addReq += `&city=${this.filters.city}`
            if (this.filters.numGuests)
                addReq += `&numGuests=${this.filters.numGuests}`
            if (this.filters.type)
                addReq += `&type=${this.filters.type}`

            axios.get(`/api/catalogue${addReq}`).then(res => {
                this.spaces = this.spaces.concat(res.data.data);
            })
            this.page = this.page + 1;
        },

        reInitFilters() {
            this.page = 1
            this.spaces = []
        },

        filtersUpdated() {
            this.reInitFilters()
            this.loadMore()
        },
        translateTag(tag) {
            const translations = {
                meeting: "Réunion",
                coworking: "Coworking",
                training: "Formation",
                seminar: "Séminaire",
                conference: "Conférence",
                amphitheater: "Amphithéâtre",
                cocktail: "Cocktail"

            };
            return translations[tag] || tag;
        },
    }

};
</script>
