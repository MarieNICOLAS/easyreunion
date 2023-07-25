require('../../../bootstrap');

const {h, createApp} = require("vue");
import BookingEditor from "./BookingEditor";

const boookingeditor = createApp({
    components: {
        BookingEditor
    },
    render: () => (
        h(BookingEditor)
    ),
});

boookingeditor.mount('#booking-editor')
