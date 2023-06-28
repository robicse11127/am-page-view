import { __ } from '@wordpress/i18n';
export const mutations = {
	UPDATE_SETTINGS: ( state, payload ) => {
		state.countRows = payload.countRows;
		state.humanReadable = payload.humanReadable;
		state.email = payload.email;
	},

	UPDATE_DATA: ( state, payload ) => {

		let graphData = Object.values( payload.graph );

		state.graphData = [];
		graphData.forEach( elem => {
			state.graphData.push( elem );
		});

		state.tableTitle   = payload.table.title;
		state.tableHeaders = payload.table.data.headers;
		state.tableRows    = payload.table.data.rows;
	},

	ADD_EMAIL_FIELD: ( state ) => {
		state.email.push( { id: Math.floor( Math.random() * 100 ), value: '' } );
	},

	REMOVE_EMAIL_FIELD: ( state, id ) => {
		let emailFields = state.email;
		const objWithIdIndex = emailFields.findIndex( ( obj ) => obj.id === id );

		if ( objWithIdIndex > -1 ) {
			emailFields.splice( objWithIdIndex, 1 );
		}

		state.email = emailFields;
	},

	SAVED: ( state ) => {
		state.loadingText = __( 'Save Settings', 'am-page-view' );
	},

	SAVING: ( state ) => {
		state.loadingText = __( 'Saving...', 'am-page-view' )
	},


}