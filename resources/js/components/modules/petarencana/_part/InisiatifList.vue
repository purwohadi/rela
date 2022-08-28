<template>
	<section class="inisiatif-list">
		<data-tables
			:id="`${resourceName}`"					
			:api-url="'peta-rencana.search-inisiatif'"
			:args-route="{
				opd_id: opd_id,
				program: program,
				domain: domain
			}"
			:fields="fields"
			:title="$t('petarencana.datatable.title_inisiatif')"
			actions="SRUD"
			row-action-width="5%"
			default-sort-by="created_at"
			@update="handleUpdate"
			@delete="handleDelete"
		>
			<template #cell(tahun_implementasi)="{ data }">
				<b-badge pill variant="success" v-for="(item,index) in arrTahunImplementasi(data.item.tahun_implementasi)" :key="index">
					{{ item }}
				</b-badge>
			</template>
		</data-tables>
		<inisiatif-update
          :m-id="modal.id"
          :title="modal.title"
          :item="modal.item"
        ></inisiatif-update>
	</section>
</template>

<script>
import InisiatifUpdate from './InisiatifUpdate.vue'

export default {
	name: 'InisiatifList',
	components: {
		InisiatifUpdate
	},
	props: {
		opd_id: {
			type: String,
			default: null
		},
		domain: {
			type: String,
			required: true
		},
		program: {
			type: String,
			required: true
		}
	},
	data() {
		return {
			resourceName: 'inisiatif-list',
			show: true,
			title: '',
			form: {
				id: null,
				name: '',
				jenis_inisiatif: null
			},
			modal: {
				id: 'inisiatif-update',
				title: this.$t('petarencana.update.inisiatif'),
				item: {}
			},
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
		arrTahunImplementasi(arr) {
			return arr.split(',')
		},
		handleUpdate(item, index, $el) {
			this.modal.item = item
			this.$bvModal.show(this.modal.id)
		},
		handleDelete(item, index, $el) {
			let vm = this
			let url 	=  vm.$app.route('peta-rencana.delete')
			let method = 'post'
			vm.$app.confirm({
				text: vm.$t('petarencana.alert.confirm.drop', {name: item.nama_inisiatif}),
				preConfirm: () => {
					return vm.$http
						[method](url, {id: item.id})
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