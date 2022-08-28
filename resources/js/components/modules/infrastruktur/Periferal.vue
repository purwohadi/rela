<template>
	<div class="row">
		<div class="col-12">
			<div class="panel">
				<div class="col-12">
					<template>  					
						<b-form-group
							label-cols="2"
							label-cols-lg="2"
							label-for="perangkat_daerah"
							label="Perangkat Daerah">   
							<validation-provider name="Perangkat Daerah" rules="required" v-slot="{ errors, ariaMsg }">                     
								<m-select
									id="perangkat-daerah"
									ref="perangkat-daerah"
									class="col-4"
									:option-height="73"
									:tabindex="7"
									:placeholder="'--pilih perangkat daerah--'"
									:options="optionsPerangkatDaerah"
									v-model="model.perangkatDaerah"
									label="nama_opd"
									track-by="nama_opd"
									:searchable="true"
									:limit="100"
									:options-limit="100">     

									<template #noOptions>
										Tidak ada data
									</template>
									<template #noResult>
										Data tidak ditemukan
									</template>

									<template #option="{ option }">
										<div class="d-flex align-items-baseline mb-1">
											<i class="fal fa-laptop mr-2"></i>
											<span class="text-wrap">{{ option.nama_opd }}</span>
										</div>
									</template>
								</m-select>  
								<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
									{{ errors[0] }}
								</small>
							</validation-provider>
						</b-form-group>        
					</template>									
				</div>
			</div>
			<section class="periferal">
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="'periferal.data-periferal.get'"
					:args-route="{'opd_id': opd_id}"
					:title="$t('infrastruktur.datatable.titlePeriferal')"
					actions="SCL"
					:access="action"
					row-action-width="10%"
					@add="handleAdd">  

					<template #cell(rowaction)="{data}">
						<button
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.view')"
							@click.prevent="handleDetil(data.item)">
							<i class="fal fa-info"></i> Lihat
						</button>

						<button
							type="button"
							class="btn btn-warning btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUbah(data.item)"
							v-if="action">
							<i class="fal fa-pen-alt"></i> Ubah
						</button>

						<button
							type="button"
							class="btn btn-danger btn-xs rounded waves-effect waves-themed"
							v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
							@click.prevent="handleDelete(data.item)"
							v-if="action">
							<i class="fal fa-trash"></i> Hapus
						</button>
					</template>

					<template #cell(proses_id)="{data}">
						{{ data.item.proses_id }} - {{ data.item.ral_level4 }}
					</template>
				</data-tables>
			</section>
		</div>
	</div>
</template>

<script>
import { exit } from 'process'


export default {
	name: 'JaringanIntraPemerintah',
	data() {
		return {
			tableId: 'jaringan-intra-pemerintah',
			opd_id: (this.$route?.params?.opd_id) ?this.$route?.params?.opd_id : this.$app.user?.opd_id,
			model:{
				perangkatDaerah: []
			},
			form: {
				id: null,
				name: ''
			},
			optionsPerangkatDaerah:[],
			fields: [
				{
					key: 'rowaction',
					label: '',
					sortable: false,
					class: 'text-center',
				},
				{
					key: 'rai_level_1',
					label: 'RAI Level 1',
					sortable: true,
				},
				{
					key: 'rai_level_2',
					label: 'RAI Level 2',
					sortable: true,
				},
				{
					key: 'rai_level_3',
					label: 'RAI Level 3',
					sortable: true,
				},
				{
					key: 'rai_level_4',
					label: 'RAI Level 4',
					sortable: true,
				},
				{
					key: 'nama',
					label: 'Nama Perangkat',
					sortable: true,
				},
				{
					key: 'deskripsi',
					label: 'Deskripsi Periferal',
					sortable: true,
				},
				{
					key: 'nm_perangkat_daerah',
					label: 'Instansi',
					sortable: true,
				},
				{
					key: 'tipe',
					label: 'Tipe',
					sortable: true,
				},
				{
					key: 'lokasi',
					label: 'Lokasi (server)',
					sortable: true,
				},
				{
					key: 'domain_code',
					label: 'Kode Domain',
					sortable: true,
				},
			],
			action : false
		}
	},
	watch: {
		'model.perangkatDaerah': {
			handler: function(n) {
				if (!_.isEmpty(n)) {				
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id:n[0].opd_id
					this.action = this.$app.user.is_admin ? true : (this.opd_id == this.$app.user?.opd_id)? true : false
					this.$root.$emit('bv::refresh::table', this.tableId)
				}
			},
		},
	},
	created() {
		this.resPerangkatDaerah()
		if(!this.$app.user.is_admin || this.$route?.params?.opd_id) this.resPerangkatDaerahById()
	},
	methods: {
		async resPerangkatDaerah(){
			const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {}))
			this.optionsPerangkatDaerah = res.data 
			return
		},		
		async resPerangkatDaerahById(){
			const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.opd_id}))
			this.model.perangkatDaerah = res.data[0]
			return
		},		
		handleUbah(data){
			this.$router.push({name: 'infrastruktur.ubah-periferal', params: {
				'id': data.id,
				'status': 'edit'
			}})
		},
		handleDetil(data){
			this.$router.push({name: 'infrastruktur.detil-periferal', params: {
				'id': data.id,
				'status': 'detail'
			}})
		},
		handleAdd() {
			this.$router.push({name: 'infrastruktur.tambah-periferal', params: {
				opd_id: this.model.perangkatDaerah.slug_path
			}})
		},
		handleDelete(data){
			let vm 			= this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
						.post(vm.$app.route('periferal.delete-data-domain-infra-pheri'), {
							data: { id: data.id}
						})
						.then(response => {
							if (response.data.status == "error") {
								let errors = response.data.message
								throw new Error(response.data.message)
							} else {
								return response
							}
						})
						.catch(error => {
							vm.$app.alert.showValidationMessage(error)
						})
				}
			}).then(result => {
				if (result.isDismissed) {
					return
				}
				if (result.value.data.status == "success") {
					// vm.$app.success(result.value.data.message)
					// 	.then(response => {
					// 		if (response.value === true) {
					// 			this.$root.$emit('bv::refresh::table', this.tableId)
					// 		}
					// 	})
					vm.$app.alert.fire({
						icon: result.value.data.status,
						title: result.value.data.status ? 'Sukses' : 'Info',
						text: result.value.data.message,
						showConfirmButton: false,
						timer: 1300
					}).then(response => {
						this.$root.$emit('bv::refresh::table', this.tableId)
					})
				}
			})   
		},
	},
}
</script>
