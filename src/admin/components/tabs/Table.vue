<template>
	<div id="ampv-table-setting-tab" class="tab-container">
		<h2>{{ tableTitle }}: </h2>
		<table class="form-table am-form-table">
			<tbody>
				<tr>
					<th scope="row" v-for="header in tableHeaders" :key="header.id">{{ header }}</th>
				</tr>
				<tr v-for="row in tableRows" :key="row.id">
					<td width="6%">{{ row.id }}</td>
					<td>{{ row.url }}</td>
					<td>{{ row.title }}</td>
					<td>{{ row.pageviews }}</td>
					<td v-if="settings.humanReadable">{{  getHumanDate( row.date ) }}</td>
					<td v-else>{{ row.date }}</td>
				</tr>
			</tbody>
		</table>
		<div class="clear"></div>
		<div class="list-of-emails">
			<h2 class="am-email-list">{{ emailListLabel }} :</h2>
			<ul><li v-for="email in settings.email" :key="email.id">{{ email.value }}</li></ul>
		</div>
	</div>
</template>

<script>
import { __ } from '@wordpress/i18n';
import { mapGetters } from 'vuex';
import HumanDate from '../common/HumanDate';
export default {
	name: 'TableTab',

	data() {
		return {
			emailListLabel: __( 'List of Email(s)', 'am-page-view' )
		}
	},

	computed: {
		...mapGetters([ 'GET_TABLE_TITLE', 'GET_TABLE_HEADERS', 'GET_TABLE_ROWS', 'GET_GENERAL_SETTINGS' ]),

		tableTitle: {
			get() {
				return __( this.GET_TABLE_TITLE, 'am-page-view' );
			}
		},

		tableHeaders: {
			get() {
				return this.GET_TABLE_HEADERS;
			}
		},

		tableRows: {
			get() {
				return Array.isArray( this.GET_TABLE_ROWS ) ? this.GET_TABLE_ROWS.slice( 0, this.settings.countRows ) : this.GET_TABLE_ROWS;
			}
		},

		settings() {
			return this.GET_GENERAL_SETTINGS;
		}

	},

	methods: {
		getHumanDate( timestamp ) {
			return HumanDate( timestamp );
		}
	}

}
</script>
