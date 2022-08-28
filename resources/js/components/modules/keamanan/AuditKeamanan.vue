<template>
	<div class="row">
		<div class="col-12">
			<section class="audit-keamanan"> <!-- Edited -->
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="'audit.data-audit-keamanan.get'"
					:title="$t('keamanan.datatable.titleAudit')" 
					actions="SCL"
					row-action-width="10%"
					@add="handleAdd">  

					<template #cell(rowaction) = "{data}">
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
	name: 'audit-keamanan',
	data() {
		return {
			tableId: 'audit-keamanan',
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
					key: 'nama_kegiatan', /* Nama Field */
					label: 'Nama Kegiatan',
					sortable: true,
					class: 'text-center',
				},
                {
					key: 'hasil_audit',
					label: 'Hasil Audit',
					sortable: true,
				},
				{
					key: 'jenis_audit',
					label: 'Jenis Audit',
					sortable: true,
				},
				{
					key: 'tgl_kegiatan',
					label: 'Tanggal Kegiatan',
					sortable: true,
				},
				{
					key: 'tindak_lanjut',
					label: 'Tindak Lanjut',
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
			this.$router.push({name: 'keamanan.ubah-audit-keamanan', params: {
				'id': data.slug_path,
				'status': 'edit'
			}})
		},
		handleDetil(data){
			this.$router.push({name: 'keamanan.detil-audit-keamanan', params: {
				'id': data.slug_path,
				'status': 'detail'
			}})
		},
		handleAdd() {
			this.$router.push({name: 'keamanan.tambah-audit-keamanan'})
		},
		handleDelete(data){
			let vm = this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
						.post(vm.$app.route('audit.delete-data-domain-audit-keamanan'), {
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
