require('../../../bootstrap');

const {h, createApp} = require("vue");
import EstimatesIndex from "./EstimatesIndex";

const estimates = createApp({
    components: {
        EstimatesIndex
    },
    render: () => (
        h(EstimatesIndex)
    ),
});

estimates.mount('#estimates')
