<template>
  <section class="pendidikan-non-formal">
    <data-table
      :id="tableId"
      :fields="fields"
      :api-url="`/profil/pendidikan-non-formal/${vnrk}`"
      :force-url="true"
      :title="$t('profil.datatable.titlePendidikanNonFormal')"
      :actions="actions"
      row-action-width="13%"
      row-num-width="5%"
      @add="handleAddPendidikanNonFormal">

      <template #cell(rowaction)="{ data }" v-if="$app.user.can('input-data-prestasi')">
        <button
          type="button"
          class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
          v-b-tooltip.hover
          title="Ubah"
          @click="ubahPendidikanNonFormal(data.item)">
          <i class="fal fa-align-left"></i>
        </button>	
        <button
          type="button"
          class="btn btn-danger btn-dt-refresh btn-sm rounded waves-effect waves-themed mr-2"
          v-b-tooltip.hover
          title="Hapus Data"
          @click="deletePendidikanNonFormal(data.item.i_id)">
          <i class="fal fa-align-left"></i>
        </button>			
      </template>
    </data-table>

    <modal-tambah-pendidikan-non-formal 
      :m-id-pendidikan-non-formal="modal.pendidikanNonFormal.id"
      :title="modal.pendidikanNonFormal.title"
      :nrk="modal.pendidikanNonFormal.nrk">
    </modal-tambah-pendidikan-non-formal>

    <modal-ubah-pendidikan-non-formal 
      :m-id-ubah-pendidikan-non-formal="modal.pendidikanNonFormal.idUbah"
      :title="modal.pendidikanNonFormal.titleUbah"
      :item="modal.pendidikanNonFormal.itemUbah"
      :nrk="modal.pendidikanNonFormal.nrk">
    </modal-ubah-pendidikan-non-formal>
  </section>
</template>

<script>
	import ModalTambahPendidikanNonFormal from './__pendidikan_non_formal/ModalTambahPendidikanNonFormal'
	import ModalUbahPendidikanNonFormal from './__pendidikan_non_formal/ModalUbahPendidikanNonFormal'
	export default {
		name: 'PendidikanNonFormal',
		components: {
			ModalTambahPendidikanNonFormal,
			ModalUbahPendidikanNonFormal,
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
						label: 'Jenjang Pendidikan / Pelatihan',
						sortable: true,
					},
					{
						key: 'tx_prestasi',
						label: 'Prestasi Yang Pernah Diraih',
						sortable: true,
					},
				],
				modal: {
					pendidikanNonFormal: {
						id: 'modal-tambah-pendidikan-non-formal',
						title: null,
						nrk: null,
						idUbah:'modal-ubah-pendidikan-non-formal',
						titleUbah: null,
						itemUbah:{},
					},
				},
				tableId: 'pendidikannonformaltable',
				nrk : this.nrk,
			}
		},
		mounted() {
			this.actions = this.$app.user.can('input-data-prestasi') ? 'SCR' : 'SR'
		},
		methods:{
			handleAddPendidikanNonFormal(){
				this.modal.pendidikanNonFormal.title 	= 'Tambah Data Prestasi Pendidikan Non Formal'
				this.modal.pendidikanNonFormal.nrk 		= this.vnrk			
        		this.$bvModal.show(this.modal.pendidikanNonFormal.id)
			},
			ubahPendidikanNonFormal(params) {
				this.modal.pendidikanNonFormal.titleUbah 	= 'Ubah Data Prestasi Pendidikan Non Formal'
				this.modal.pendidikanNonFormal.nrk 			= this.vnrk	
				this.modal.pendidikanNonFormal.itemUbah		= params
				this.$bvModal.show(this.modal.pendidikanNonFormal.idUbah)
			},
			deletePendidikanNonFormal(params){
				const vm = this
				vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
					.delete(vm.$app.route('profil.delete-pendidikan-non-formal'), {
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
								vm.$root.$emit('bv::refresh::table', 'pendidikannonformaltable')
								//vm.$bvModal.hide(vm.mId)
							}
						})
					}
				})
			},
		},
	}
</script>
