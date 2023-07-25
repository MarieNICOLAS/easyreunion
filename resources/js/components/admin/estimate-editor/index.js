require('../../../bootstrap');

const {h, createApp} = require("vue");
import EstimateEditor from "./EstimateEditor";

const estimateEditor = createApp({
    components: {
        EstimateEditor
    },
    render: () => (
        h(EstimateEditor)
    ),
});

estimateEditor.mount('#estimate-editor')
