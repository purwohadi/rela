<template>
  <section class="kegiatan">
    <data-table
      :id="tableId"
      :fields="fields"
      :api-url="`/profil/kegiatan-strategis/${vnrk}`"
      :force-url="true"
      :title="$t('profil.datatable.titleKegiatan')"
      :actions="actions"
      row-action-width="13%"
      row-num-width="5%"
      @add="handleAdd">

      <template #cell(rowaction)="{ data }" v-if="$app.user.can('input-data-prestasi')">
        <button
          type="button"
          class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
          v-b-tooltip.hover
          title="Ubah"
          @click="ubahKegiatan(data.item)">
          <i class="fal fa-align-left"></i>
        </button>	
        <button
          type="button"
          class="btn btn-danger btn-dt-refresh btn-sm rounded waves-effect waves-themed mr-2"
          v-b-tooltip.hover
          title="Hapus Data"
          @click="deleteKegiatan(data.item.id)">
          <i class="fal fa-align-left"></i>
        </button>			
      </template> 
    </data-table>

    <modal-tambah-kegiatan 
      :m-id-kegiatan="modal.kegiatan.id"
      :title="modal.kegiatan.title"
      :nrk="modal.kegiatan.nrk">
    </modal-tambah-kegiatan>

    <modal-ubah-kegiatan 
      :m-id-ubah-kegiatan="modal.kegiatan.idUbah"
      :title="modal.kegiatan.titleUbah"
      :item="modal.kegiatan.itemUbah"
      :nrk="modal.kegiatan.nrk">
    </modal-ubah-kegiatan>
  </section>
</template>

<script>
	import ModalTambahKegiatan from './__kegiatan/ModalTambahKegiatan.vue'
	import ModalUbahKegiatan from './__kegiatan/ModalUbahKegiatan'
	export default {
		name: 'Narasumber',
		components: {
			ModalUbahKegiatan,
			ModalTambahKegiatan
		},
		props: {
			vnrk: {
				type: String,
				required: true,
				default: () => ''
			}
		},
		data() 
		{
			return {
				actions: 'SR',
				fields: [
					{
						key: 'rowaction',
						label: '',
						class: 'text-center',
					},
					{
						key: 'rownum',
						class: 'text-center',
					},
					{
						key: 'v_nama_kegiatan',
						label: 'Kegiatan',
						sortable: true,
					},
					{
						key: 'v_tahun_angg',
						label: 'Tahun',
						sortable: true,
					},
					{
						key: 'v_jumlah_angg',
						label: 'Anggaran',
						sortable: true,
					},
					{
						key: 'v_peran',
						label: 'Peran',
						sortable: true,
					},
				],
				modal: {
					kegiatan: {
						id: 'modal-tambah-kegiatan',
						title: null,
						nrk: null,
						idUbah:'modal-ubah-kegiatan',
						titleUbah: null,
						itemUbah:{},
					},
				},
				tableId: 'kegiatantable',
				nrk : this.nrk,
			}
		},
		mounted() {
			this.actions = this.$app.user.can('input-data-prestasi') ? 'SCR' : 'SR'
		},
		methods:{
			handleAdd(){
				this.modal.kegiatan.title = 'Tambah Data Prestasi Mengelola Kegiatan Strategis'
				this.modal.kegiatan.nrk 	= this.vnrk			
        		this.$bvModal.show(this.modal.kegiatan.id)
			},
			ubahKegiatan(params) {
				this.modal.kegiatan.titleUbah 	= 'Ubah Data Prestasi Mengelola Kegiatan Strategis'
				this.modal.kegiatan.nrk 		= this.vnrk	
				this.modal.kegiatan.itemUbah	= params				
				this.$bvModal.show(this.modal.kegiatan.idUbah)
			},
			deleteKegiatan(params){
				const vm = this
				vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
					.delete(vm.$app.route('profil.delete-kegiatan-strategis'), {
						data: { id: params }
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
					if (result.isDismissed) return
					if (result.value.data.status == "success") {
						vm.$app.success(result.value.data.message)
						.then(response => {
							if (response.value === true) {				
								vm.$root.$emit('bv::refresh::table', this.tableId)
							}
						})
					}
				})
			},
		},
	}
</script>
