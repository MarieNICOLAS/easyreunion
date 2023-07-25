require('../../../bootstrap');

const {h, createApp} = require("vue");
import AgendaElementsEditor from "./AgendaElementsEditor";

const estimates = createApp({
    components: {
        AgendaElementsEditor
    },
    render: () => (
        h(AgendaElementsEditor)
    ),
});

estimates.mount('#agenda-elements-editor')
