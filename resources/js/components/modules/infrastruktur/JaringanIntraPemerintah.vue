<template>
	<div class="row">
		<div class="col-12">
			<div class="panel">
				<div class="col-12">
					<template>  					
						Untuk melakukan modifikasi data (tambah, ubah, hapus), mohon menghubungi Pengelola Data JIPD :<br></br>
						1. Budi Supriyanto  +628158367210 <br>
						2. Willy Riady Azhar  +6281296630230 <br>
						3. Amy Devriadi +6285719265620 <br>
					</template>									
				</div>
			</div>

			<section class="jaringan-intra-pemerintah">
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="'jaringan-intra-pemerintah.data-intra-pemerintah.get'"
					:title="$t('infrastruktur.datatable.titleJip')"
					:actions="actions"
					row-action-width="10%"
					@add="handleAdd">  

					<template #cell(rowaction)="{data}">
						<button
							v-if="$app.user.can('lihat-daftar-jaringan-intra-pemerintah')"
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.view')"
							@click.prevent="handleDetil(data.item)">
							<i class="fal fa-info"></i> Lihat
						</button>

						<button
							v-if="$app.user.can('edit-jaringan-intra-pemerintah')"
							type="button"
							class="btn btn-warning btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUbah(data.item)">
							<i class="fal fa-pen-alt"></i> Ubah
						</button>

						<button
							v-if="$app.user.can('hapus-jaringan-intra-pemerintah')"
							type="button"
							class="btn btn-danger btn-xs rounded waves-effect waves-themed"
							v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
							@click.prevent="handleDelete(data.item)">
							<i class="fal fa-trash"></i> Hapus
						</button>
					</template>

					<!-- <template v-slot:cell(proses_id)="{data}">
						{{ data.item.proses_id}} - {{ data.item.ral_level4}}
					</template> -->
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
			actions: 'SL',
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
					key: 'nama_jip',
					label: 'Nama JIP',
					sortable: true,
				},
				{
					key: 'instansi_1',
					label: 'Instansi 1',
					sortable: true,
				},
				{
					key: 'instansi_2',
					label: 'Instansi 2',
					sortable: true,
				},
				{
					key: 'deskripsi',
					label: 'Deskripsi Jaringan',
					sortable: true,
				},
				{
					key: 'domain_code',
					label: 'Kode Domain',
					sortable: true,
				},
			],
		}
	},
	mounted() {
		this.actions += this.$app.user.can('tambah-jaringan-intra-pemerintah') ? 'C' : ''
	},
	methods: {
		handleUbah(data){
			this.$router.push({name: 'infrastruktur.ubah-jaringan-intra-pemerintah', params: {
				'id': data.id,
				'status': 'edit'
			}})
		},
		handleDetil(data){
			this.$router.push({name: 'infrastruktur.detil-jaringan-intra-pemerintah', params: {
				'id': data.id,
				'status': 'detail'
			}})
		},
		handleAdd() {
			this.$router.push({name: 'infrastruktur.tambah-jaringan-intra-pemerintah'})
		},
		handleDelete(data){
			let vm 			= this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
						.post(vm.$app.route('jaringan-intra-pemerintah.delete-data-domain-infra-jip'), {
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
