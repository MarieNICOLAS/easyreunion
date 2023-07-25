require('../../../bootstrap');

const {h, createApp} = require("vue");
import Settings from "./Settings";

const settings = createApp({
    components: {
        Settings
    },
    render: () => (
        h(Settings)
    ),
});

settings.mount('#settings')
