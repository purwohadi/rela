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

			<!-- default-sort-by="id"
				:intial-sort-desc="true" -->
			<section class="infra-software">
				<data-table
					:id="`${resourceName}`"
					:ref="`${resourceName}`"
					:fields="fields"
					:api-url="'domain-infra-software.list'"
					:urlParams="{'opd_id': opd_id}" 
					:title="$t('domaininfra.datatable.title', {domain: 'Infra Software'})"
					:actions="actionsAplikasi"
					:access="(opd_id)?true:false"
					row-action-width="10%"
					@add="handleAdd">

					<template #cell(rowaction)="{data}">
						<button
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.view')"
							@click.prevent="handleDetail(data.item)">
							<i class="fal fa-info"></i> Lihat
						</button>

						<button
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUpdate(data.item)">
							<i class="fal fa-pen-alt"></i> Ubah
						</button>

						<button
							type="button"
							class="btn btn-danger btn-xs rounded waves-effect waves-themed"
							v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
							@click.prevent="handleDelete(data.item)">
							<i class="fal fa-trash"></i> Hapus
						</button>
					</template>

					<template #cell(proses_id)="{data}">
						{{ data.item.proses_id }} - {{ data.item.ral_level4 }}
					</template>
				</data-table>
			</section>
		</div>
	</div>
</template>

<script>
export default {
	name: 'InfraSoftware',
	data() {
		return {
			resourceName: 'infra-software',
			opd_id: (this.$route?.params?.opd_id) ? this.$route?.params?.opd_id : this.$app.user?.opd_id,
			show: true,
			model:{
				perangkatDaerah: []
			},
			title: '',
			form: {
				id: null,
				name: ''
			},
			optionsPerangkatDaerah:[],
			fields: [
				{
					key: 'rowaction',
					label: '',
					class: 'text-center',
				},
				{
					key: 'rownum',
					class: 'text-center',
					sortable: false,
				},
				{
					key: 'nama',
					label: this.$t('domaininfra.datatable.column.name', {name: 'Software'}),
					sortable: true,
				},
				{
					key: 'instansi',
					label: this.$t('domaininfra.datatable.column.instansi'),
					sortable: true,
				},
				{
					key: 'rai_level_1',
					label: this.$t('domaininfra.datatable.column.rai_l1'),
					sortable: true,
				},
				{
					key: 'rai_level_2',
					label: this.$t('domaininfra.datatable.column.rai_l2'),
					sortable: true,
				},
				{
					key: 'rai_level_3',
					label: this.$t('domaininfra.datatable.column.rai_l3'),
					sortable: true,
				},
				{
					key: 'rai_level_4',
					label: this.$t('domaininfra.datatable.column.rai_l4'),
					sortable: true,
				},
				{
					key: 'domain_code',
					label: this.$t('domaininfra.datatable.column.domain_code'),
					sortable: true,
				},
				{
					key: 'id_metadata_terkait',
					label: this.$t('domaininfra.datatable.column.id_metadata_terkait'),
					sortable: true,
				}
			]
		}
	},
	watch: {
		'model.perangkatDaerah': {
			handler: function(n) {
				if (!_.isEmpty(n)) {				
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id:n[0].opd_id
					this.$root.$emit('bv::refresh::table', this.resourceName)
					console.log(this.opd_id)
				}
			},
		},
	},
	computed: {
		actionsAplikasi() {
			let actions = 'SR'
			if(this.opd_id){
				actions += this.$app.user.can('infra-software') ? 'C' : ''
			}
      		return actions
		}
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
		handleAdd() {
			this.$router.push({
				name: 'infra-software-add',
				params: {opd_id: this.model.perangkatDaerah.opd_id}
			})
		},
		handleUpdate(item, index, $el) {
			this.$router.push({
				name: 'infra-software-edit', 
				params: {id: item.slug_path}
			})
		},
		handleDetail(item, index, $el) {
			this.$router.push({
				name: 'infra-software-detail', 
				params: { id: item.slug_path }
			})
		},
		handleDelete(item, index, $el) {
			let vm = this
			let url 	=  '/domain-infra-software/delete/' + item.id
			let method = 'delete'
      
			vm.$app.confirm({
				text: vm.$t('domaininfra.alert.confirm.drop', {name: item.nama}),
				preConfirm: () => {
					return vm.$http
						[method](url)
						.then(response => {
							if (response.data.status == "error") {
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
					if (result.isDismissed) return
					if (result.value.data.status == "success")
					{
						vm.$app.alert.fire('Sukses', 'Data Berhasil Dihapus' , 'success');
						vm.$root.$emit('bv::refresh::table', this.resourceName)
					}
				})
		},
	}
}
</script>
