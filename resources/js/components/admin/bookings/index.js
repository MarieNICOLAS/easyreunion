require('../../../bootstrap');

const {h, createApp} = require("vue");
import BookingsIndex from "./BookingsIndex";

const bookings = createApp({
    components: {
        BookingsIndex
    },
    render: () => (
        h(BookingsIndex)
    ),
});

bookings.mount('#bookings')
