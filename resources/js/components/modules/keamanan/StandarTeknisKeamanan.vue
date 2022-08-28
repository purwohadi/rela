<template>
	<div class="row">
		<div class="col-12">
			<section class="standar-teknis-keamanan">
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="apiUrl"
					:title="$t('keamanan.datatable.titleStandarTeknisKeamanan')"
					actions="SCL"
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
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUbah(data.item)">
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
				</data-tables>
			</section>
		</div>
	</div>
</template>

<script>
export default {
	name: 'StandarTeknisKeamanan',
	data() {
		return {
			tableId: 'standar-teknis-keamanan',
			apiUrl: 'standar-teknis-keamanan.data-standar-teknis-keamanan.get',
			fields: [
				{
					key: 'rowaction',
					label: '',
					sortable: false,
					class: 'text-center',
				},
				{
					key: 'rak_level_1',
					label: 'RAK Level 1',
					sortable: true,
				},
				{
					key: 'rak_level_2',
					label: 'RAK Level 2',
					sortable: true,
				},
				{
					key: 'nama',
					label: 'Nama Perangkat',
					sortable: true,
				},
				{
					key: 'tgl_mulai',
					label: 'Tanggal Mulai Penerapan',
					sortable: true,
				},
				{
					key: 'id_metadata_terkait',
					label: 'ID Metadata Terkait',
					sortable: true,
				},
			],
		}
	},
	created() {
	},
	methods: {
		handleUbah(data){
			this.$router.push({name: 'keamanan.ubah-standar-teknis-keamanan', params: {
				'id': data.slug_path,
				'status': 'edit'
			}})
		},
		handleDetil(data){
			this.$router.push({name: 'keamanan.detil-standar-teknis-keamanan', params: {
				'id': data.slug_path,
				'status': 'detail'
			}})
		},
		handleAdd() {
			this.$router.push({name: 'keamanan.tambah-standar-teknis-keamanan'})
		},
		handleDelete(data){
			let vm 			= this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
						.post(vm.$app.route('standar-teknis-keamanan.delete-data-domain-standar-keamanan'), {
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
