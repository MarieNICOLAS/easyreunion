<template>
    <input v-model="spacesSearch" type="text" @change="searchSpace"/>
    <select v-show="spacesLoaded.length > 0" v-model="spaces" multiple @change="updateParent">
        <option v-for="space in spacesLoaded" :value="space.id">{{ space.name }}</option>
    </select>
</template>
<script>
export default {
    name: "SpaceFilter",
    props: ['spaces'],
    emits: ['update-parent'],
    data() {
        return {
            // Space search
            spacesSearch: '',
            spacesLoaded: [],
        }
    },
    methods: {
        searchSpace() {
            axios.get('/api/spaces/search?query=' + this.spacesSearch).then(res => {
                this.spacesLoaded = res.data;
            })
        },
        updateParent() {
            this.$emit('update-parent', this.spaces);
        },
        emptySpacesLoaded() {
            this.spacesSearch = '';
            this.spacesLoaded = [];
        }
    }
}
</script>
