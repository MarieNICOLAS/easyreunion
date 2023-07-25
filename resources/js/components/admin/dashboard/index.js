require('../../../bootstrap');

const {h, createApp} = require("vue");
import Dashboard from "./Dashboard";

const dashboard = createApp({
    components: {
        Dashboard
    },
    render: () => (
        h(Dashboard)
    ),
});

dashboard.mount('#dashboard')
