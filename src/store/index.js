import Vue from 'vue';
import Vuex from 'vuex';
import { __ } from '@wordpress/i18n';

import { getters } from './getters';
import { mutations } from './mutations';
import { actions } from './actions';

Vue.use( Vuex );

export default new Vuex.Store({
    state: {
        countRows: 5,
        humanReadable: true,
        email: [ { id: 1, value: ampvAdminLocalizer.adminEmail } ],
        tableHeaders: {},
        tableRows: {},
        graphData: [],
        loadingText: __( 'Save Settings', 'am-page-view' )
    },
    actions,
    getters,
    mutations
})