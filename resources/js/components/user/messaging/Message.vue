<template>
    <section v-show="id !== 0" aria-labelledby="message-heading"
             class="min-w-0 flex-1 h-full flex flex-col overflow-hidden xl:order-last">
        <!-- Top section -->
        <div class="flex-shrink-0 bg-white border-b border-gray-200">
            <!-- Toolbar-->
            <div class="h-16 flex flex-col justify-center">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="py-3 flex justify-between">
                        <!-- Left buttons -->
                        <div>
                                        <span
                                            class="relative z-0 inline-flex shadow-sm rounded-md sm:shadow-none sm:space-x-3">
                                            <span class="inline-flex sm:shadow-sm">
                                            <a href="#mail-message"><button
                                                class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-900 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600"
                                                type="button"
                                                @click="replyForm = true">
                                                <!-- Heroicon name: solid/reply -->
                                                <svg aria-hidden="true"
                                                     class="mr-2.5 h-5 w-5 text-gray-400" fill="currentColor"
                                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path clip-rule="evenodd"
                                                          d="M7.707 3.293a1 1 0 010 1.414L5.414 7H11a7 7 0 017 7v2a1 1 0 11-2 0v-2a5 5 0 00-5-5H5.414l2.293 2.293a1 1 0 11-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                          fill-rule="evenodd"/>
                                                </svg>
                                                <span>Répondre</span>
                                            </button></a>

                                            </span>

                                            <span class="-ml-px relative block sm:shadow-sm lg:hidden">

                                                <div
                                                    aria-labelledby="menu-2-button"
                                                    aria-orientation="vertical"
                                                    class="origin-top-right absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                                    role="menu" tabindex="-1"
                                                >
                                                    <div v-if="isAdmin" class="py-1" role="none">
                                                        <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                                        <a id="menu-2-item-0"
                                                           class="text-gray-700 block sm:hidden px-4 py-2 text-sm"
                                                           href="#" role="menuitem" tabindex="-1">
                                                            Fermer
                                                        </a>

                                                    </div>
                                                </div>
                                            </span>
                                        </span>
                        </div>


                    </div>
                </div>
            </div>
            <!-- Message header -->
        </div>

        <div class="min-h-0 flex-1 overflow-y-auto">
            <div class="bg-white pt-5 pb-6 shadow">
                <div class="px-4 sm:flex sm:justify-between sm:items-baseline sm:px-6 lg:px-8">
                    <div class="sm:w-0 sm:flex-1">
                        <h1 id="message-heading" class="text-lg font-medium text-gray-900">
                            {{ this.topic }}
                        </h1>
                        <p class="mt-1 text-sm text-gray-500 truncate">
                            {{ this.participants }}
                        </p>
                    </div>

                </div>
            </div>
            <!-- Thread section-->
            <ul class="messages-list py-4 space-y-2 sm:px-6 sm:space-y-4 lg:px-8" role="list">
                <li v-for="message in messages" :key="`message-id-${message.id}`"
                    class="bg-white px-4 py-6 shadow sm:rounded-lg sm:px-6">
                    <div class="sm:flex sm:justify-between sm:items-baseline">
                        <p class="text-base font-medium">
                            <span class="text-gray-900">{{
                                    message.user.first_name + ' ' + message.user.last_name
                                }}</span>
                            <span class="text-gray-600"> a écrit</span>
                        </p>
                        <p class="mt-1 text-sm text-gray-600 whitespace-nowrap sm:mt-0 sm:ml-3">
                            {{ formatDate(message.updated_at) }}
                        </p>
                    </div>
                    <div class="mt-4 space-y-6 text-sm text-gray-800">
                        <p>{{ message.text }}</p>
                    </div>
                </li>
            </ul>

            <div v-show="replyForm" class="flex flex-col" name="send-message">
                <input name="mail_id" type="hidden">
                <textarea id="mail-message" v-model="replyContent"
                          class="shadow w-11/12 mx-auto border border-gray-300 rounded-lg"
                          cols="60" name="message" placeholder="Écrivez votre message" required
                          rows="10"></textarea>
                <div class="w-11/12 mx-auto">
                    <button
                        class="px-4 py-2 rounded-md border border-gray-300 bg-white w-max mx-auto mt-4 hover:bg-gray-50"
                        @click="sendMessage">
                        Envoyer
                    </button>
                </div>

            </div>
        </div>
    </section>

</template>

<script>
import TimeAgo from 'javascript-time-ago'
import fr from 'javascript-time-ago/locale/fr.json'

TimeAgo.addLocale(fr)
const timeAgo = new TimeAgo('fr-FR')

export default {
    name: "Message.vue",
    props: ['id', 'isAdmin'],
    data() {
        return {
            messages: [],
            topic: '',
            closed: '',
            participants: [],

            // New message
            replyForm: false,
            replyContent: '',

        }
    },

    methods: {
        sendMessage() {
            axios.post(`/api/messages/${this.id}`, {
                message: this.replyContent
            }).then(res => {
                this.messages.push({
                    id: 0,
                    user: {first_name: 'Moi', last_name: ''},
                    text: this.replyContent,
                    created_at: (Date.now()),
                    updated_at: (Date.now())
                });

                this.replyContent = '';
                this.replyForm = false;
            })
        },

        formatDate(date) {
            if (!Number.isInteger(date)) {
                date = Date.parse(date);
            }
            return timeAgo.format(date);
        },
        loadMessages() {
            let participants = []
            axios.get('/api/messages/' + this.id).then(res => {
                this.messages = res.data.data.messages
                this.topic = res.data.data.topic
                this.closed = res.data.data.closed
                this.messages.forEach((message) => {
                    participants.push(`${message.user.first_name} ${message.user.last_name}`)
                })
                // Keep unique values
                participants = participants.filter((v, i, a) => a.indexOf(v) === i);
                this.participants = participants.join(', ')


            })
        },
        closeMessage(event) {
            const id = +event.target.closest('section').querySelector('[name*="id"]').value;
            axios.post('/api/messages/' + id + '/close').then(res => {
                const {ok} = res
                window.location.reload()
            })
        }
    },
    watch: {
        id: function (newVal, oldVal) { // watch it
            if (newVal !== 0) {
                this.loadMessages()
            }
        }
    }
}
</script>

<style scoped>

</style>
