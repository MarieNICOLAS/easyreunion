require('../../../bootstrap');

const {h, createApp} = require("vue");
import Messaging from "./Messaging";

const messaging = createApp({
    components: {
        Messaging
    },
    render: ()=> h(Messaging),
});

messaging.mount('#messaging')