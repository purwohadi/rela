<template>
	<div class="row">
		<div class="col-12">
			<div class="panel">
				<div data-v-4b9960e4="" class="panel-hdr ">
					<h2>
						<i class="fal fa-th-list mr-2"></i>
						<i>Data Rekapitulasi DPT </i>
					</h2> <!---->
				</div>

				<div class="col-12">
					<template>
						<b-row>
							<b-col sm="8">
								<Bar
									:chart-options="chartOptions"
									:chart-data="chartData"
									:chart-id="chartId"
									:dataset-id-key="datasetIdKey"
									:plugins="plugins"
									:css-classes="cssClasses"
									:styles="styles"
									:width="width"
									:height="height"
								/>			
							</b-col>
						</b-row>
					</template>
				</div>
			</div>
			<section class="user">
				ini home
			</section>
		</div>
	</div>
</template>

<script>
import { defineComponent, h, PropType } from 'vue'
import { Pie } from 'vue-chartjs/legacy'

import { Bar } from 'vue-chartjs/legacy'

import { Chart as ChartJS, 
	     Title, 
		 Tooltip, 
		 Legend, 
		 BarElement, 
  		 ArcElement,
		 CategoryScale, 
		 LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, ArcElement, CategoryScale, LinearScale)

export default {
	name: 'Home',
	components: { Pie, Bar },
	props: {
		chartId: {
			type: String,
			default: 'bar-chart'
		},
		datasetIdKey: {
			type: String,
			default: 'label'
		},
		width: {
			type: Number,
			default: 400
		},
		height: {
			type: Number,
			default: 400
		},
		cssClasses: {
			default: '',
			type: String
		},
		styles: {
			type: Object,
			default: () => {}
		},
		plugins: {
			type: Object,
			default: () => {}
		}
	},
	data() {
		return {
			chartData: {
				labels: [ 'January', 'February', 'March', 'April', 'Mei', 'Juni', 'Juli' ],
				// labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
				// datasets: [ 
				// 	{ 
				// 		backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
				// 		data: [40, 20, 80, 10]
				// 	} 
				// ]
				datasets: [{
					axis: 'y',
    				label: ' ',
					fill: false,
					data: [65, 59, 80, 81, 56, 55, 400	],
					backgroundColor: ['#41B883'],
					// backgroundColor: [
					// 	'rgba(255, 99, 132, 0.2)',
					// 	'rgba(255, 159, 64, 0.2)',
					// 	'rgba(255, 205, 86, 0.2)',
					// 	'rgba(75, 192, 192, 0.2)',
					// 	'rgba(54, 162, 235, 0.2)',
					// 	'rgba(153, 102, 255, 0.2)',
					// 	'rgba(201, 203, 207, 0.2)'
					// ],
					// borderColor: [
					// 	'rgb(255, 99, 132)',
					// 	'rgb(255, 159, 64)',
					// 	'rgb(255, 205, 86)',
					// 	'rgb(75, 192, 192)',
					// 	'rgb(54, 162, 235)',
					// 	'rgb(153, 102, 255)',
					// 	'rgb(201, 203, 207)'
					// ],
					borderWidth: 1
				}]
			},
			// chartData: {
			// 	labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
			// 	datasets: [
			// 		{
			// 			backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
			// 			data: [40, 20, 80, 10]
			// 		}
			// 	]
			// },
			chartOptions: {
				responsive: true,
				indexAxis: 'y',
			}
		}
	},
	async mounted (){
		this.loaded = false
		try {
			const userlist  				= await this.$http.get(this.$app.route('beranda.get-dpt'))
			this.chartData.labels 			= userlist.data.labels
			this.chartData.datasets[0].data	= userlist.data.jumlah_dpt
			this.loaded 					= true
		} catch (e) {
			console.error(e)
		}
	},
}
</script>

<style lang="scss" scoped>

</style>
