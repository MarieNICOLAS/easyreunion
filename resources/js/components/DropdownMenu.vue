<template>
    <div class="flex items-center justify-between mb-2 cursor-pointer" @click="toggleShow">
        <a class="flex items-center w-full text-gray-300 hover:bg-gray-700 hover:text-white group px-2 py-2 font-medium rounded-md"
           :class="this.text">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="text-gray-300 group-hover:text-gray-300 h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" :class="this.mr" v-html="this.svg">


            </svg>

            {{ title }}


            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" :class="{'rotate-90' : showMenu}"
                 class="dropdown-menu ml-auto" viewBox="0 0 24 24" stroke="currentColor">
                <path fill="none" d="M0 0h24v24H0V0z"/>
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
            </svg>
        </a>

    </div>

    <ul class="ml-4 dropdown-menu font-normal" :class="this.class">
        <slot></slot>
    </ul>
</template>
<script>
export default {
    name: "DropdownMenu",
    props: ["title", "text", "mr", "svg"],
    data() {
        return {
            showMenu: false
        };
    },

    methods: {
        toggleShow() {
            this.showMenu = !this.showMenu;
        }
    },

    computed: {
        class() {
            return this.showMenu ? '' : "h-0 overflow-hidden";
        }
    }
}
</script>
<style scoped>
.dropdown-menu {
    transition: 300ms;
}

svg.rotate-90 {
    transform: rotate(90deg);
}
</style>
