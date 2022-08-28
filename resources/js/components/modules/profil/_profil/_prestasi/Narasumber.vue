<template>
  <section class="narsum">
    <data-table
      :id="tableId"
      :fields="fields"
      :api-url="`/profil/narsum/${vnrk}`"
      :force-url="true"
      :title="$t('profil.datatable.titleNarsum')"
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
          @click="ubahNarsum(data.item)">
          <i class="fal fa-align-left"></i>
        </button>	
        <button
          type="button"
          class="btn btn-danger btn-dt-refresh btn-sm rounded waves-effect waves-themed mr-2"
          v-b-tooltip.hover
          title="Hapus Data"
          @click="deleteNarsum(data.item.id)">
          <i class="fal fa-align-left"></i>
        </button>			
      </template> 
    </data-table>

    <modal-tambah-narasumber 
      :m-id-narasumber="modal.narasumber.id"
      :title="modal.narasumber.title"
      :nrk="modal.narasumber.nrk">
    </modal-tambah-narasumber>

    <modal-ubah-narasumber 
      :m-id-ubah-narasumber="modal.narasumber.idUbah"
      :title="modal.narasumber.titleUbah"
      :item="modal.narasumber.itemUbah"
      :nrk="modal.narasumber.nrk">
    </modal-ubah-narasumber>
  </section>
</template>

<script>
	import ModalTambahNarasumber from './__narasumber/ModalTambahNarasumber.vue'
	import ModalUbahNarasumber from './__narasumber/ModalUbahNarasumber'
	export default {
		name: 'Narasumber',
		components: {
			ModalUbahNarasumber,
			ModalTambahNarasumber
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
						key: 'v_kegiatan',
						label: 'kegiatan',
						sortable: true,
					},
					{
						key: 'v_judul',
						label: 'Judul Materi',
						sortable: true,
					},
					{
						key: 'v_lembaga',
						label: 'Lembaga Penyelenggara',
						sortable: true,
					},
					{
						key: 'v_tahun',
						label: 'Tahun',
						sortable: true,
					},
				],
				modal: {
					narasumber: {
						id: 'modal-tambah-narasumber',
						title: null,
						nrk: null,
						idUbah:'modal-ubah-narasumber',
						titleUbah: null,
						itemUbah:{},
					},
				},
				tableId: 'narasumbertable',
				nrk : this.nrk,
			}
		},
		mounted() {
			this.actions = this.$app.user.can('input-data-prestasi') ? 'SCR' : 'SR'
		},
		methods:{
			handleAdd(){
				this.modal.narasumber.title = 'Tambah Data Pengalaman Sebagai Narasumber'
				this.modal.narasumber.nrk 	= this.vnrk			
        		this.$bvModal.show(this.modal.narasumber.id)
			},
			ubahNarsum(params) {
				this.modal.narasumber.titleUbah = 'Ubah Data Pengalaman Sebagai Narasumber'
				this.modal.narasumber.nrk 		= this.vnrk	
				this.modal.narasumber.itemUbah	= params
				this.$bvModal.show(this.modal.narasumber.idUbah)
			},
			deleteNarsum(params){
				const vm = this
				vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
					.delete(vm.$app.route('profil.delete-narsum'), {
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
