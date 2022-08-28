<template>
  <section class="prestasiJabatan">
    <data-table
      :id="tableId"
      :fields="fields"
      :api-url="`/profil/prestasi-jabatan/${vnrk}`"
      :force-url="true"
      :title="$t('profil.datatable.titleJabatan')"
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
          @click="ubahPrestasiJabatan(data.item)">
          <i class="fal fa-align-left"></i>
        </button>	
        <button
          type="button"
          class="btn btn-danger btn-dt-refresh btn-sm rounded waves-effect waves-themed mr-2"
          v-b-tooltip.hover
          title="Hapus Data"
          @click="deletePrestasiJabatan(data.item.id)">
          <i class="fal fa-align-left"></i>
        </button>			
      </template> 
    </data-table>

    <modal-tambah-prestasi-jabatan 
      :m-id-prestasi-jabatan="modal.prestasiJabatan.id"
      :title="modal.prestasiJabatan.title"
      :nrk="modal.prestasiJabatan.nrk">
    </modal-tambah-prestasi-jabatan>

    <modal-ubah-prestasi-jabatan 
      :m-id-ubah-prestasi-jabatan="modal.prestasiJabatan.idUbah"
      :title="modal.prestasiJabatan.titleUbah"
      :item="modal.prestasiJabatan.itemUbah"
      :nrk="modal.prestasiJabatan.nrk">
    </modal-ubah-prestasi-jabatan>
  </section>
</template>

<script>
	import ModalTambahPrestasiJabatan from './__jabatan/ModalTambahPrestasiJabatan.vue'
	import ModalUbahPrestasiJabatan from './__jabatan/ModalUbahPrestasiJabatan'
	export default {
		name: 'Narasumber',
		components: {
			ModalUbahPrestasiJabatan,
			ModalTambahPrestasiJabatan
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
						key: 'v_najabs',
						label: 'Jabatan',
						sortable: true,
					},
					{
						key: 'v_tahun',
						label: 'Tahun',
						sortable: true,
					},
					{
						key: 'tx_keberhasilan',
						label: 'Keberhasilan',
						sortable: true,
					},
					{
						key: 'tx_kendala',
						label: 'Kendala Yang Dihadapi',
						sortable: true,
					},
					{
						key: 'tx_solusi',
						label: 'Solusi Yang Dilakukan',
						sortable: true,
					},
				],
				modal: {
					prestasiJabatan: {
						id: 'modal-tambah-prestasi-jabatan',
						title: null,
						nrk: null,
						idUbah:'modal-ubah-prestasi-jabatan',
						titleUbah: null,
						itemUbah:{},
					},
				},
				tableId: 'prestasijabatantable',
				nrk : this.nrk,
			}
		},
		mounted() {
			this.actions = this.$app.user.can('input-data-prestasi') ? 'SCR' : 'SR'
		},
		methods:{
			handleAdd(){
				this.modal.prestasiJabatan.title = 'Tambah Data Prestasi dalam Jabatan'
				this.modal.prestasiJabatan.nrk 	= this.vnrk			
        		this.$bvModal.show(this.modal.prestasiJabatan.id)
			},
			ubahPrestasiJabatan(params) {
				this.modal.prestasiJabatan.titleUbah = 'Ubah Data Prestasi dalam Jabatan'
				this.modal.prestasiJabatan.nrk 		= this.vnrk	
				this.modal.prestasiJabatan.itemUbah	= params
				this.$bvModal.show(this.modal.prestasiJabatan.idUbah)
			},
			deletePrestasiJabatan(params){
				const vm = this
				vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
					.delete(vm.$app.route('profil.delete-prestasi-jabatan'), {
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
