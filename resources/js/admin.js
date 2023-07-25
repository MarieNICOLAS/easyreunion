require('./bootstrap');

import {createApp} from 'vue/dist/vue.esm-bundler';
import DropdownMenu from "./components/DropdownMenu";


const app = createApp({
    data() {
        return {
            isUserProfileOpen: false,
            isMobileMenuOpen: false,
            isNotificationsOpen: false,
            collapsedSidebar: (!!(localStorage.collapsedSidebar && localStorage.collapsedSidebar === 'true')),
        }
    },
    methods: {
        toggleNotifications: function() {
            this.isNotificationsOpen = !this.isNotificationsOpen;
            axios.get('/notifications/mark-as-read')
        },
        toggleSidebar: function() {
            let el = document.getElementById('navbar-left');
            if(this.collapsedSidebar)
            {
                el.classList.remove('collapsedSidebar');
                localStorage.collapsedSidebar = false;
            }else {
                el.classList.add('collapsedSidebar');
                localStorage.collapsedSidebar = true;
            }
            this.collapsedSidebar = !this.collapsedSidebar;
        }
    },
    components: {
        'dropdown-menu': DropdownMenu,
    }

});
app.mount("#app");


require('./search')
