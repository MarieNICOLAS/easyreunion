<template>

    <form action="{{ route('settings.update') }}" method="POST">
        <h3>A la une</h3>
        <div class="grid md:grid-cols-2">
            <div v-for="(space, index) in featured" class="my-4">
                <label class="block text-sm font-medium text-gray-900">À la Une en position {{ index + 1 }}</label>
                <select v-model="space.key" @change="updateSetting('hp_featured_space_'+(index+1), space.key)">
                    <optgroup label="Espaces">
                        <option v-for="group in groups" :value="group.key">{{ group.name }}</option>
                    </optgroup>
                    <optgroup label="Salles">
                        <option v-for="spaceListed in spaces" :value="spaceListed.key">{{
                                spaceListed.name
                            }}
                        </option>
                    </optgroup>
                </select>
            </div>
            <br/>
            <h3>En exclusivité</h3>
            <div v-for="(space, index) in exclusive" class="my-4">
                <label class="block text-sm font-medium text-gray-900">Exclusivité en position {{ index + 1 }}</label>
                <select v-model="space.key" @change="updateSetting('hp_exclusive_space_'+(index+1), space.key)">
                    <optgroup label="Espaces">
                        <option v-for="group in groups" :value="group.key">{{ group.name }}</option>
                    </optgroup>
                    <optgroup label="Salles">
                        <option v-for="spaceListed in spaces" :value="spaceListed.key">{{
                                spaceListed.name
                            }}
                        </option>
                    </optgroup>
                </select>
            </div>
        </div>
    </form>
</template>


<script>

export default {
    name: "Settings",
    data() {
        return {
            featured: [],
            exclusive: [],

            spaces: [],
            groups: []
        };
    },
    mounted() {
        axios.get('/admin/api/settings').then(res => {
            this.featured = res.data.data.featured;
            this.exclusive = res.data.data.exclusive;
        });
        axios.get('/admin/api/settings/spaces').then(res => {
            this.spaces = res.data.data.spaces;
            this.groups = res.data.data.groups;

        });
    },
    methods: {
        updateSetting(key, value) {
            axios.post('/admin/api/settings', {
                key: key,
                value: value
            });
        }
    }
}
</script>
