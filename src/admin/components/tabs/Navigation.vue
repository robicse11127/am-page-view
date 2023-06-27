<template>
    <ul class="tab-menu">
        <li><router-link to="/">Table</router-link></li>
        <li><router-link to="/graph">Graph</router-link></li>
        <li><router-link to="/settings">Settings</router-link></li>
    </ul>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    name: 'TabNavigation',

    data() {
        return {}
    },

    mounted() {
        this.fetchData();
        this.fetchSettings();
    },

    methods: {
        ...mapActions([ 'FETCH_DATA', 'FETCH_SETTINGS' ]),

        fetchData() {
            this.FETCH_DATA();
        },

        fetchSettings() {
            this.FETCH_SETTINGS();
        },

    }
}
</script>
