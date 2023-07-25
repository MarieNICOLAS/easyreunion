require('../../../bootstrap');

const {h, createApp} = require("vue");
import PartnersIndex from "./PartnersIndex";

const partnersIndex = createApp({
    components: {
        PartnersIndex
    },
    render: () => (
        h(PartnersIndex)
    ),
});

partnersIndex.mount('#partners-index')
