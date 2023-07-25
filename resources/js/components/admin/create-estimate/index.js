require('../../../bootstrap');

const {h, createApp} = require("vue");
import CreateEstimate from "./CreateEstimate";

const createEstimate = createApp({
    components: {
        CreateEstimate
    },
    render: () => (
        h(CreateEstimate)
    ),
});

createEstimate.mount('#create-estimate')
