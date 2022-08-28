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
			<section class="domain_layanan">
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="'domain.get-domain-layanan'"
					:args-route="{'opd_id': opd_id}"
					:title="$t('domain.datatable.titleDomainLayanan')"
					:actions="actionsAplikasi"
					row-action-width="10%"
					@add="handleAdd">  

					<!-- <template slot="dateFilterTop">
						<div class="panel-container show">
							<b-row>
                                <b-col md="4" class="mb-4">
									<button
										type="button"
										class="btn btn-success btn-sm rounded waves-effect waves-themed ml-3 mt-3 mb-0"
										data-toggle="tooltip"
										data-placement="top"
										v-b-tooltip.hover.top="$t('general.datatable.toolbar.add')"
										@click="handleAdd">
										<i class="fal fa-plus"></i> Tambah
									</button>
								</b-col>
							</b-row>
						</div>
					</template> -->

					<template #cell(rowaction)="{data}">
						<button
							v-if="$app.user.can('lihat-daftar-layanan')"
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.view')"
							@click.prevent="handleDetil(data.item)">
							<i class="fal fa-info"></i> Lihat
						</button>

						<button
							v-if="$app.user.can('edit-layanan') && show(data.item)"
							type="button"
							class="btn btn-warning btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUbah(data.item)">
							<i class="fal fa-pen-alt"></i> Ubah 
						</button>

						<button
							v-if="$app.user.can('hapus-layanan') && show(data.item)"
							type="button"
							class="btn btn-danger btn-xs rounded waves-effect waves-themed"
							v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
							@click.prevent="handleDelete(data.item)">
							<i class="fal fa-trash"></i> Hapus
						</button>
					</template>
				</data-tables>
			</section>
		</div>
	</div>
</template>

<script>
export default {
	name: 'DomainLayanan',
	data() {
		return {
			tableId: 'domain-layanan',
			opd_id: (this.$route?.params?.opd_id) ?this.$route?.params?.opd_id : this.$app.user?.opd_id,
			title: '',
			model:{
				perangkatDaerah: []
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
					key: 'domain_code',
					label: 'Domain Code',
					sortable: true,
				},
				{
					key: 'ral_level_1',
					label: 'RAL Level 1',
					sortable: true,
					class: 'text-left',
				},
				{
					key: 'ral_level_2',
					label: 'RAL Level 2',
					sortable: true,
					class: 'text-left',
				},
				{
					key: 'ral_level_3',
					label: 'RAL Level 3',
					sortable: true,
					class: 'text-left',
				},
				{
					key: 'nama_layanan',
					label: 'Nama Layanan',
					sortable: true,
					class: 'text-left',
				},
			],
		}
	},
	computed: {
		actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-layanan') ? 'L' : ''

			if (this.opd_id) {
				if (this.$app.user.opd_id) {
					if((this.opd_id === this.$app.user.opd_id) || this.$app.user.is_admin) {
						actions += this.$app.user.can('tambah-layanan') ? 'C' : ''
					}
				} else {
					actions += this.$app.user.can('tambah-layanan') ? 'C' : ''
				}
			}
			return actions
		}
	},
	watch: {
		'model.perangkatDaerah': {
			handler: function(n) {
				if (!_.isEmpty(n)) {				
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id:n[0].opd_id
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
			// this.model.perangkatDaerah = res.data[0]
			return
		},		
		async resPerangkatDaerahById(){
			const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.opd_id}))
			this.model.perangkatDaerah = res.data[0]
			return
		},		
		handleUbah(data){
			this.$router.push({name: 'domain.ubah-domain-layanan', params: {
				'id': data.layanan_id,
				'status': 'edit'
			}})
		},
		handleDetil(data){
			this.$router.push({name: 'domain.detil-domain-layanan', params: {
				'id': data.layanan_id,
				'status': 'detail'
			}})
		},
		handleAdd() {
			this.$router.push({name: 'domain.tambah-domain-layanan', params: {
				opd_id: this.model.perangkatDaerah.slug_path
			}})
		},
		handleDelete(data){
			let vm 			= this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
						.post(vm.$app.route('domain.delete-data-domain-layanan'), {
							data: { id: data.layanan_id}
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
			})
				.then(result => {
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
		show(data){
			if(!this.$app.user.opd_id || (data.opd_id==this.$app.user?.opd_id) || this.$app.user.is_admin){
				return true
			}
			else{
				return false
			}
		},
	},
}
</script>
