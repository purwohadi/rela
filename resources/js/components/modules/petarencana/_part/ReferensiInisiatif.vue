<template>
	<div class="row">
		<div class="col-12">
			<section class="infra-software">
				<data-tables
					:id="`${resourceName}`"
					:api-url="'peta-rencana.get-ref-inisiatif'"
					:args-route="{
						opd_id: opd.opd_id,
						jenis_inisiatif: jenis_inisiatif
					}"
					:fields="fields"
					:title="$t('petarencana.datatable.title')"
					actions="SRNLF1"
					row-action-width="5%"
					default-sort-by="opd_id_pemilik"
					@detail="handleDetail"
				>
					<template #cell(deskripsi_pekerjaan)="{ data }">
						<p class="deskripsi">{{ data.item.deskripsi_pekerjaan }}</p>
					</template>
					<template slot="filter">
						<b-row style="width:200px;">
							<m-select
								id="filter_status"
								class="ml-2"
								v-model="form.jenis_inisiatif"
								:options="optionsJenisInisiatif"
								:placeholder="$t('petarencana.datatable.filter.jenis_inisiatif')"
								label="text"
								track-by="value"
								:searchable="true"
								@input="handleChange"
							>
							</m-select>
						</b-row>
					</template>
				</data-tables>
			</section>
		</div>
		<referensi-inisiatif-view
          :m-id="modal.id"
          :title="modal.title"
          :item="modal.item"
        ></referensi-inisiatif-view>
	</div>
</template>

<script>
import ReferensiInisiatifView from './ReferensiInisiatifView.vue'
export default {
	name: 'ReferensiInisiatif',
	props: {
		opd: {
			type: Object,
			default: null
		},
	},
	components: {
		ReferensiInisiatifView
	},
	data() {
		return {
			resourceName: 'ref-inisiatif',
			show: true,
			title: '',
			form: {
				id: null,
				name: '',
				jenis_inisiatif: null
			},
			modal: {
				id: 'inisiatif-view',
				title: this.$t('petarencana.detail.ref_inisiatif'),
				item: {}
			},
			optionsJenisInisiatif: [
				{
					text: 'Semua Jenis Inisiatif',
					value: null
				},
				{
					text: 'Teknologi',
					value: 'Teknologi'
				},
				{
					text: 'SDM',
					value: 'SDM'
				},
				{
					text: 'Proses',
					value: 'Proses'
				}
			],
			fields: [
				{
					key: 'rowaction',
					label: '',
					class: 'text-center',
				},
				{
					key: 'nama_inisiatif',
					label: this.$t('petarencana.datatable.column.nama_inisiatif'),
					sortable: true,
				},
				{
					key: 'jenis_inisiatif',
					label: this.$t('petarencana.datatable.column.jenis_inisiatif'),
					sortable: true,
				},
				{
					key: 'domain_arsitektur',
					label: this.$t('petarencana.datatable.column.domain_arsitektur'),
					sortable: true,
				},
				{
					key: 'aplikasi',
					label: this.$t('petarencana.datatable.column.aplikasi'),
					sortable: false,
				},
				{
					key: 'jenis_kesenjangan_app',
					label: this.$t('petarencana.datatable.column.jenis_kesenjangan'),
					sortable: false,
				},
				{
					key: 'deskripsi_pekerjaan',
					label: this.$t('petarencana.datatable.column.deskripsi_pekerjaan'),
					sortable: false,
				}
			],
			jenis_inisiatif: null
		}
	},
	created() {
	},
	methods: {
		handleAdd() {
			this.$router.push({name: 'infra-software-add'})
		},
		async loadRencanaInisiatif(){
			const res = await this.$http.get(this.$app.route('peta-rencana.get-ref-inisiatif', {}))
			this.optionsRefInisiatif = res.data
		},	
		handleUpdate(item, index, $el) {
			this.$router.push({name: 'infra-software-edit', params: { id: item.slug_path }})
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
		handleDetail(item) {
			this.modal.item = item
			this.$bvModal.show(this.modal.id)
		},
		handleChange(item) {
			this.jenis_inisiatif = this.form.jenis_inisiatif.value

			this.$root.$emit('bv::refresh::table', this.resourceName)
		}
	}
}
</script>
<style lang="css" scoped>
	p.deskripsi {
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
	max-width: 200px;
	}
</style>