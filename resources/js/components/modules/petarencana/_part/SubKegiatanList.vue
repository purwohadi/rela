<template>
	<div class="row">
		<div class="col-12">
			<section class="infra-software" v-for="(item, index) in subkegiatan" :key="index">
				<data-tables
					:id="`${resourceName}`"
					:fields="fields"
					:api-url="'peta-rencana.search-inisiatif'"
					:args-route="{
						opd_id: opd_id,
						domain: domain,
						sub_kegiatan: getSubKegiatanCode(item)
					}"
					:title="item"
					actions=""
					:row-action-width="'5%'"
                    :per-page-custom="5"
				>
					<template #cell(tahun_implementasi)="{ data }">
						<b-badge pill variant="success" v-for="(item,index) in arrTahunImplementasi(data.item.tahun_implementasi)" :key="index">
							{{ item }}
						</b-badge>
					</template>
				</data-tables>
			</section>
		</div>
	</div>
</template>

<script>
import ReferensiInisiatifView from './ReferensiInisiatifView.vue'
export default {
	name: 'ReferensiInisiatif',
	props: {
		subkegiatan: {
			type: Array,
			default: []
		},
		opd_id: {
			type: String
		},
		domain: {
			type: String
		}
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
			fields: [
				{
					key: 'rownum',
					class: 'text-center',
					sortable: false,
				},
				{
					key: 'nama_inisiatif',
					label: this.$t('petarencana.datatable.column.nama_inisiatif'),
					sortable: true,
				},
				{
					key: 'kegiatan_teks',
					label: 'Kegiatan',
					sortable: true,
				},
				{
					key: 'sub_kegiatan_teks',
					label: 'Sub Kegiatan',
					sortable: true,
				},
				{
					key: 'tahun_implementasi',
					label: 'Tahun Implementasi',
					sortable: false,
				}
			]
		}
	},
	created() {
	},
	methods: {
		handleAdd() {
			this.$router.push({name: 'infra-software-add'})
		},
		arrTahunImplementasi(arr) {
			return arr.split(',')
		},
		getSubKegiatanCode(subkegiatan) {
			return subkegiatan.split('-')[0]
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
		handleDetail(item, index, $el) {
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