<template>
    <div class="relative h-screen overflow-hidden bg-gray-100 flex flex-col -mt-6">
        <!-- Top nav-->
        <!--        <header class="flex-shrink-0 relative h-16 bg-white flex items-center">

                    <div class="hidden lg:min-w-0 lg:flex-1 lg:flex lg:items-center lg:justify-between">
                        <div class="min-w-0 flex-1">
                            <div class="max-w-2xl relative text-gray-400 focus-within:text-gray-500">
                                <label for="desktop-search" class="sr-only">Search all inboxes</label>
                                <input id="desktop-search" type="search" placeholder="Search all inboxes"
                                       class="block w-full border-transparent pl-12 placeholder-gray-500 focus:border-transparent sm:text-sm focus:ring-0">
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center justify-center pl-4">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                         fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>-->

        <!-- Bottom section -->
        <div class="min-h-0 flex-1 flex overflow-hidden">
            <!-- Main area -->
            <main class="min-w-0 flex-1 border-t border-gray-200 xl:flex">
                <Message :id="mailId" :is-admin="isAdmin"/>

                <!-- Message list-->
                <aside class="hidden xl:block xl:flex-shrink-0 xl:order-first">
                    <div class="h-full relative flex flex-col w-96 border-r border-gray-200 bg-gray-100">
                        <div class="flex-shrink-0">
                            <div class="h-16 bg-white px-6 flex flex-col justify-center">
                                <div class="flex items-baseline space-x-3">
                                    <h2 class="text-lg font-medium text-gray-900">Messagerie</h2>
                                    <p class="text-sm font-medium text-gray-500">{{ mails.length }}
                                        message{{ (mails.length > 1) ? 's' : '' }}</p>
                                    <button class="btn dark float-right h-in" @click="displayNewMessageModal = true">+
                                    </button>
                                </div>
                            </div>
                            <div
                                class="border-t border-b border-gray-200 bg-gray-50 px-6 py-2 text-sm font-medium text-gray-500">
                                Trié par date
                            </div>
                        </div>
                        <nav aria-label="Message list" class="min-h-0 flex-1 overflow-y-auto">
                            <ul role="list" class="border-b border-gray-200 divide-y divide-gray-200">
                                <li v-for="mail in mails"
                                    v-show="!mail.closed"
                                    @click="openMail(mail.id)"
                                    class="relative bg-white py-5 px-6 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-600"
                                    :key="`message-${mail.id}`"
                                >
                                    <div class="flex justify-between space-x-3">
                                        <div class="min-w-0 flex-1">
                                            <a href="#" class="block focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <!-- Is this useful? -->
                                                <!--
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    Gloria Roberston
                                                </p>
                                                -->
                                                <!--<p class="text-sm text-gray-500 truncate">-->
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ mail.topic }}
                                                </p>

                                            </a>
                                        </div>
                                        <time class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500"
                                              datetime="2021-01-27T16:35">
                                            {{ formatDate(mail.updated_at) }}
                                        </time>
                                    </div>
                                </li>
                                <p class="my-4 !border-t-4 text-center">Messages fermés</p>
                                <li v-for="mail in mails"
                                    v-show="mail.closed"
                                    @click="openMail(mail.id)"
                                    :class="mail.closed ? 'bg-gray-300 hover:bg-gray-300' : ''"
                                    class="relative bg-white py-5 px-6 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-blue-600"
                                    :key="`message-${mail.id}`"
                                >
                                    <div class="flex justify-between space-x-3">
                                        <div class="min-w-0 flex-1">
                                            <a href="#" class="block focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ mail.topic }} <span v-if="mail.closed"> (Fermé)</span>
                                                </p>

                                            </a>
                                        </div>
                                        <time class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500"
                                              datetime="2021-01-27T16:35">
                                            {{ formatDate(mail.updated_at) }}
                                        </time>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>
            </main>
        </div>
    </div>

    <NewMessageModal :show-modal="displayNewMessageModal" @close-modal="displayNewMessageModal = false"/>
</template>


<script>
import TimeAgo from 'javascript-time-ago'
import fr from 'javascript-time-ago/locale/fr.json'
import Message from "./Message";
import NewMessageModal from "./NewMessageModal";

TimeAgo.addDefaultLocale(fr)
const timeAgo = new TimeAgo('fr-FR')

export default {
    name: "Messaging",
    components: {NewMessageModal, Message},
    data() {
        return {
            mails: [],
            isAdmin: document.getElementById('messaging').dataset.isAdmin === "yes",
            mailId: 0,

            displayNewMessageModal: false,
        }
    },

    mounted() {
        this.isAdmin = document.getElementById('messaging').dataset.isAdmin === "yes",

            axios.get('/api/messages').then(res => {
                this.mails = res.data.data.data;
            });
    },
    methods: {
        formatDate(date) {
            return timeAgo.format(Date.parse(date));
        },
        openMail(mailId) {
            this.mailId = mailId;
        },

    }
}
</script>
