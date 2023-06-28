<template>
	<div class="tab-container">
		<D3BarChart v-if="0 < chart_data.length" :config="chart_config" :datum="chart_data"></D3BarChart>
	</div>
</template>

<script>
import HumanDate from '../common/HumanDate';
import { D3BarChart } from 'vue-d3-charts';
import { mapGetters } from 'vuex';
export default {
	name: 'GraphTab',
	components: { D3BarChart },
	data() {
		return {
			chart_config: {
				key: 'date',
				values: ['value'],
				axis: {
					yTicks: 6
				},
				color: {
					default: '#222f3e',
					current: '#41B882'
				},
			},
		}
	},

	computed: {
		...mapGetters([ 'GET_GRAPH_DATA', 'GET_GENERAL_SETTINGS' ]),
		chart_data: {
			get() {
				if ( this.settings.humanReadable ) {
					let graphData = [];
					this.GET_GRAPH_DATA.forEach( ( item ) => {
						graphData.push( { value: item.value, date: HumanDate( item.date ) } );
					} );

					return graphData;
				}
				return this.GET_GRAPH_DATA;
			}
		},

		settings() {
			return this.GET_GENERAL_SETTINGS;
		}

	},

}
</script>
