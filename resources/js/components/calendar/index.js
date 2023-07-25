require('../../bootstrap');

const {h, createApp} = require("vue");
import Calendar from "./Calendar";

const agenda = createApp({
    components: {
        Calendar
    },
    render: () => (
        h(Calendar)
    ),
});

agenda.mount('#calendar')
