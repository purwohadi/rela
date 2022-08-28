<template>
  <section class="pendidikan-formal">
    <data-table
      :id="tableId"
      :fields="fields"
      :api-url="`/profil/pendidikan-formal/${vnrk}`"
      :force-url="true"
      :title="$t('profil.datatable.titlePendidikanFormal')"
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
          @click="ubahPendidikanFormal(data.item)">
          <i class="fal fa-align-left"></i>
        </button>	
        <button
          type="button"
          class="btn btn-danger btn-dt-refresh btn-sm rounded waves-effect waves-themed mr-2"
          v-b-tooltip.hover
          title="Hapus Data"
          @click="deletePendidikanFormal(data.item.i_id)">
          <i class="fal fa-align-left"></i>
        </button>			
      </template> 
    </data-table>

    <modal-tambah-pendidikan-formal 
      :m-id-pendidikan-formal="modal.pendidikanFormal.id"
      :title="modal.pendidikanFormal.title"
      :nrk="modal.pendidikanFormal.nrk">
    </modal-tambah-pendidikan-formal>

    <modal-ubah-pendidikan-formal 
      :m-id-ubah-pendidikan-formal="modal.pendidikanFormal.idUbah"
      :title="modal.pendidikanFormal.titleUbah"
      :item="modal.pendidikanFormal.itemUbah"
      :nrk="modal.pendidikanFormal.nrk">
    </modal-ubah-pendidikan-formal>
  </section>
</template>

<script>
	import ModalTambahPendidikanFormal from './__pendidikan_formal/ModalTambahPendidikanFormal'
	import ModalUbahPendidikanFormal from './__pendidikan_formal/ModalUbahPendidikanFormal'
	export default {
		name: 'PendidikanFormal',
		components: {
			ModalTambahPendidikanFormal,
			ModalUbahPendidikanFormal
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
						key: 'v_nadik',
						label: 'Jenjang Pendidikan',
						sortable: true,
					},
					{
						key: 'tx_prestasi',
						label: 'Prestasi Yang Pernah Diraih',
						sortable: true,
					},
				],
				modal: {
					pendidikanFormal: {
						id: 'modal-tambah-pendidikan-formal',
						title: null,
						nrk: null,
						idUbah:'modal-ubah-pendidikan-formal',
						titleUbah: null,
						itemUbah:{},
					},
				},
				tableId: 'pendidikanformaltable',
				nrk : this.nrk,
			}
		},
		mounted() {
			this.actions = this.$app.user.can('input-data-prestasi') ? 'SCR' : 'SR'
		},
		methods:{
			handleAdd(){
				this.modal.pendidikanFormal.title 		= 'Tambah Data Prestasi Pendidikan Formal'
				this.modal.pendidikanFormal.nrk 		= this.vnrk			
        		this.$bvModal.show(this.modal.pendidikanFormal.id)
			},
			ubahPendidikanFormal(params) {
				this.modal.pendidikanFormal.titleUbah 	= 'Ubah Data Prestasi Pendidikan Formal'
				this.modal.pendidikanFormal.nrk 		= this.vnrk	
				this.modal.pendidikanFormal.itemUbah	= params
				this.$bvModal.show(this.modal.pendidikanFormal.idUbah)
			},
			deletePendidikanFormal(params){
				const vm = this
				vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
					.delete(vm.$app.route('profil.delete-pendidikan-formal'), {
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
								vm.$root.$emit('bv::refresh::table', 'pendidikanformaltable')
								//vm.$bvModal.hide(vm.mId)
							}
						})
					}
				})
			},
		},
	}
</script>
