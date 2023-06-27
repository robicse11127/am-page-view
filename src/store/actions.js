import Axios from 'axios';

export const actions = {
    SAVE_SETTINGS: ( { commit }, payload ) => {
        commit( 'SAVING' );
        let url = ampvAdminLocalizer.apiUrl + '/ampv/v1/settings';

        if ( 1 > payload.countRows ) {
            payload.countRows = 1;
        }

        if ( 5 < payload.countRows ) {
            payload.countRows = 5;
        }

        Axios.post( url, {
            countRows: payload.countRows,
            humanReadable : payload.humanReadable,
            email    : payload.email,
        }, {
            headers: {
                'content-type': 'application/json',
                'X-WP-NONCE': ampvAdminLocalizer.nonce
            }
        } )
        .then( ( response ) => {
            if ( 200 === response.status ) {
                setTimeout( commit( 'SAVED' ), 3000 );
            }
        } )
        .catch( ( error ) => {
            const appID = document.getElementById( 'vue-backend-app' );
            appID.append( error );
        } );
    },

    FETCH_SETTINGS: ( { commit }, payload ) => {
        let url = ampvAdminLocalizer.apiUrl + '/ampv/v1/settings';
        Axios.get( url, {
            headers: {
                'content-type': 'application/json',
                'X-WP-NONCE': ampvAdminLocalizer.nonce
            }
        } )
        .then( ( response ) => {
            payload = response.data;
            commit( 'UPDATE_SETTINGS', payload );
        } )
        .catch( ( error ) => {
            const appID = document.getElementById( 'vue-backend-app' );
            appID.append( error );
        } );
    },

    FETCH_DATA: ( { commit }, payload ) => {
        let url = ampvAdminLocalizer.apiUrl + '/ampv/v1/graph';
        Axios.get( url, {
            headers: {
                'content-type': 'application/json',
                'X-WP-NONCE': ampvAdminLocalizer.nonce
            }
        } )
        .then( ( response ) => {
            payload = response.data;
            commit( 'UPDATE_DATA', payload );
        } )
        .catch( ( error ) => {
            const appID = document.getElementById( 'vue-backend-app' );
            appID.append( error );
        } );
    },

    ADD_EMAIL_FIELD: ( { commit }, payload ) => {
        commit( 'ADD_EMAIL_FIELD', payload );
    },

    REMOVE_EMAIL_FIELD: ( { commit }, payload ) => {
        commit( 'REMOVE_EMAIL_FIELD', payload );
    },
}