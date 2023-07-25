require('../../../bootstrap');

const {h, createApp} = require("vue");
import Catalogue from "./Catalogue.vue";

const catalogue = createApp({
    components: {
        Catalogue
    },
    render: () => (
        h(Catalogue)
    ),
});

catalogue.mount('#catalogue')
