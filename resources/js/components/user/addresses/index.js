require('../../../bootstrap');

const {h, createApp} = require("vue");
import Addresses from "./Addresses";

const addresses = createApp({
    components: {
        Addresses
    },
    render: () => (
        h(Addresses)
    ),
});

addresses.mount('#addresses')
