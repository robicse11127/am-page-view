<template>
	<div id="ampv-settings-setting-tab" class="tab-container">
		<h2>{{ pageTitle }}</h2>
		<form id="ampv-general-setting-form" class="ampv-general-setting-form" @submit="saveSettings">
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<label for="rows">{{ settings.rowLabel }}</label>
						</th>
						<td>
							<input id="rows" class="regular-text" min="1" max="5" type="number" v-model="formData.countRows">
							<p class="am-error-msg" v-if="! isValidNumberField">Please enter valid number value between 1 to 5!</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="human-readable">{{ settings.humanReadableLabel }}</label>
						</th>
						<td>
							<input id="human-readable" class="regular-text" type="checkbox" v-model="formData.humanReadable">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="email">{{ settings.emailLabel }}</label>
						</th>
						<td>
							<p v-for="field in formData.email" :key="field.id">
								<input :id="`email-${field.id}`" class="regular-text" type="email" v-model="field.value">
								<button v-if="1 < formData.email.length" type="button" href="#" @click="removeEmail( field.id )" class="button button-danger">{{ removeBtnLabel }}</button>
								<br/><br />
							</p>
							<p class="am-error-msg" v-if="! isValidEmailField">Please enter valid email adress!</p>
							<p v-if="5 > formData.email.length"><button @click="addEmail" type="button" class="button button-primary">{{ addBtnLabel }}</button></p>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<button type="submit" class="button button-primary">{{ loadingText }}</button>
			</p>
		</form>
		<div class="clear"></div>
		<div class="am-notification" id="am-notification"></div>
	</div>
</template>

<script>
import { __ } from '@wordpress/i18n';
import { mapActions, mapGetters } from 'vuex';

export default {
	name: 'SettingsTab',

	data() {
		return {
			pageTitle: __( 'Settings', 'am-page-view' ),
			settings: {
				rowLabel: __( 'Number of Rows:', 'am-page-view' ),
				humanReadableLabel: __( 'Human Readable (Date Format)?:', 'am-page-view' ),
				emailLabel: __( 'Email:', 'am-page-view' )
			},
			addBtnLabel: __( 'Add', 'am-page-view' ),
			removeBtnLabel: __( 'Remove', 'am-page-view' ),
			isValidNumberField: true,
			isValidEmailField: true
		}
	},

	computed: {
		...mapGetters([ 'GET_GENERAL_SETTINGS', 'GET_LOADING_TEXT' ]),

		formData: {
			get() {
				return this.GET_GENERAL_SETTINGS;
			},
		},

		loadingText: {
			get() {
				return this.GET_LOADING_TEXT;
			}
		},

	},

	methods: {
		...mapActions([ 'SAVE_SETTINGS', 'ADD_EMAIL_FIELD', 'REMOVE_EMAIL_FIELD'  ]),

		formValidation() {
			const isValidNumberFieldCheck = this.isValidNumberFieldCheck( this.formData.countRows );
			const isValidEmailFieldCheck = this.isValidEmailFieldCheck( this.formData.email );

			if ( isValidNumberFieldCheck ) {
				this.isValidNumberField = true;
			} else {
				this.isValidNumberField = false;
				return false;
			}

			if ( isValidEmailFieldCheck ) {
				this.isValidEmailField = true;
			} else {
				this.isValidEmailField = false;
				return false;
			}

			return true;
		},

		saveSettings(e) {
			e.preventDefault();
			if ( this.formValidation() ) {
				this.SAVE_SETTINGS( this.formData );
			}

			return false;
		},

		addEmail( e ) {
			e.preventDefault();
			this.ADD_EMAIL_FIELD();
		},

		removeEmail( id ) {
			this.REMOVE_EMAIL_FIELD( id );
		},

		isValidNumberFieldCheck( value ) {
			return /^[0-9]$/.test( value );
		},

		isValidEmailFieldCheck( values ) {
			let flag = true;
			values.forEach( ( email ) => {
				const result = /^[^@]+@\w+(\.\w+)+\w$/.test( email.value );
				if ( ! result ) {
					flag = false;
				}
			} );

			return flag;
		}

	}
}
</script>
