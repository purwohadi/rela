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
			<section class="perangkat-keamanan"> <!-- Edited -->
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="'perangkat-keamanan.data-perangkat-keamanan.get'"
					:args-route="{
						opd_id: this.opd_id
					}"
					:title="$t('infrastruktur.datatable.titleKeamanan')" 
					:actions="actionsAplikasi"
					row-action-width="10%"
					@add="handleAdd">  

					<template #cell(rowaction) = "{data}">
						<button
							v-if="$app.user.can('lihat-daftar-perangkat-keamanan')"
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.view')"
							@click.prevent="handleDetil(data.item)">
							<i class="fal fa-info"></i> Lihat
						</button>

						<button
							v-if="$app.user.can('edit-perangkat-keamanan')"
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUbah(data.item)">
							<i class="fal fa-pen-alt"></i> Ubah
						</button>

						<button
							v-if="$app.user.can('hapus-perangkat-keamanan')"
							type="button"
							class="btn btn-danger btn-xs rounded waves-effect waves-themed"
							v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
							@click.prevent="handleDelete(data.item)">
							<i class="fal fa-trash"></i> Hapus
						</button>
					</template>

					<template v-slot:cell(proses_id)="{data}">
						{{ data.item.proses_id}} - {{ data.item.ral_level4}}
					</template>
				</data-tables>
			</section>
		</div>
	</div>
</template>

<script>
import { exit } from 'process'


export default {
	name: 'perangkat-keamanan',
	data() {
		return {
			tableId: 'perangkat-keamanan',
			opd_id: (this.$route?.query?.opd_id) ?this.$route?.query?.opd_id : this.$app.user?.opd_id,
			form: {
				id: null,
				name: ''
			},
			model: {
				perangkatDaerah: null,
			},
			optionsPerangkatDaerah:[],
			fields: [
				{
					key: 'rowaction',
					label: '',
					sortable: false,
					class: 'text-center',
				},
				/*
				{
					key: 'opd_id',
					label: 'OPD ID',
					sortable: false,
					class: 'text-center',
				},
				*/
				{
					key: 'rai_level_1_nama',
					label: 'RAI Level 1',
					sortable: true,
				},
				{
					key: 'rai_level_2_nama',
					label: 'RAI Level 2',
					sortable: true,
				},
				{
					key: 'rai_level_3_nama',
					label: 'RAI Level 3',
					sortable: true,
				},
				{
					key: 'rai_level_4_nama',
					label: 'RAI Level 4',
					sortable: true,
				},
				{
					key: 'nama',
					label: 'Nama Perangkat Keamanan',
					sortable: false,
					class: 'text-center',
				},
				{
					key: 'instansi',
					label: 'Instansi',
					sortable: true,
				},
				{
					key: 'jenis',
					label: 'Jenis',
					sortable: true,
				},
				{
					key: 'tipe',
					label: 'Tipe',
					sortable: true,
				},
				{
					key: 'nama_owner',
					label: 'Pemilik',
					sortable: true,
				},
				{
					key: 'status_ownership',
					label: 'Kepemilikan',
					sortable: true,
				},
				{
					key: 'domain_code',
					label: 'Kode Domain',
					sortable: true,
				}
			],
		}
	},
	watch: {
		'model.perangkatDaerah': {
			handler: function(n, o) {
				if (!_.isEmpty(n)) {				
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id:n[0].opd_id
					let params = Object.entries({opd_id: n.opd_id,})
					.map(([key, val]) => `${key}=${val}`).join('&');
						
					window.history.pushState({}, '','?'+params)
				} else {
					this.opd_id = null
				}
				if(!(!_.isEmpty(n) && !_.isEmpty(o) && (n.opd_id == o.opd_id))) {
					this.$root.$emit('bv::refresh::table', this.tableId)
				}
			},
		}
	},
	computed: {
		actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-perangkat-keamanan') ? 'L' : ''

			if (this.opd_id) {
				if((this.opd_id === this.$app.user.opd_id) || this.$app.user.is_admin) {
					actions += this.$app.user.can('tambah-perangkat-keamanan') ? 'C' : ''
				}
			}
			return actions
		}
	},
	mounted() {
		let query_opd = this.$route.query.opd_id ? this.$route.query.opd_id : this.$app.user.opd_id
		this.model.opd_id = query_opd
		if(this.model.opd_id && ((this.model.opd_id === this.$app.user.opd_id) || this.$app.user.is_admin)) {
			this.actions += this.$app.user.can('tambah-perangkat-keamanan') ? 'C' : ''
		}
		this.resPerangkatDaerah().then(() => {
			if(!this.$app.user.is_admin || this.$route?.query?.opd_id) {
				this.resPerangkatDaerahById()
			}
			this.$root.$emit('bv::refresh::table', this.tableId)
		})
	},
	methods: {
		async resPerangkatDaerah(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {})).then((res) => {
				this.optionsPerangkatDaerah = res.data
				this.model.perangkatDaerah = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
		async resPerangkatDaerahById(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.opd_id})).then((res) => {
				this.model.perangkatDaerah = res.data[0]
			})
		},
		handleUbah(data){
			this.$router.push({name: 'infrastruktur.ubah-perangkat-keamanan', params: {
				opd_id: this.opd_id,
				'id': data.slug_path,
				'status': 'edit'
			}})
		},
		handleDetil(data){
			this.$router.push({name: 'infrastruktur.detil-perangkat-keamanan', params: {
				opd_id: this.opd_id,
				'id': data.slug_path,
				'status': 'detail'
			}})
		},
		handleAdd() {
			this.$router.push({name: 'infrastruktur.tambah-perangkat-keamanan', params: {
				 opd_id: this.opd_id,
				'status': 'add'
			}})
		},
		handleDelete(data){
			let vm = this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data?',
				preConfirm: () => {
					return vm.$http
						.post(vm.$app.route('perangkat-keamanan.delete-data-domain-infra-keamanan'), {
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
					vm.$app.success(result.value.data.message)
						.then(response => {
							if (response.value === true) {
								this.$root.$emit('bv::refresh::table', this.tableId)
							}
						})
				}
			})   
		},
	},
}
</script>
