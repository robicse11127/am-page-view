<template>
    <div id="vue-backend-app">
        <h1>{{ pageTitle }}</h1>
        <router-view name="tab"></router-view>
        <router-view></router-view>
    </div>
</template>

<script>
import TabNavigation from './components/tabs/Navigation.vue';
import { __ } from '@wordpress/i18n';
export default {
    name: 'App',
    components: {
        'tab-navigation': TabNavigation
    },
    data() {
        return {
            pageTitle: __( 'Awesome Motive Page View', 'am-page-view' ),
        }
    }
}
</script>
