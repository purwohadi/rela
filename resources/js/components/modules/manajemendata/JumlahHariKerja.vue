<template>
  <section class="jumlah-hari-kerja">
    <data-table
      :id="table.id"
      :fields="table.fields"
      :items="table.items"
      :api-url="'jumlah-hari-kerja.get'"
      :default-sort-by="table.sortBy"
      :sort-desc="table.sortDesc"
      title="Daftar Jumlah Hari Kerja"
      actions="SCRNL"
      row-action-width="10%"
      row-num-width="3%"
      @add="handleAdd">
      <template #cell(si_bulan)="{ data }">
        <span>{{ data.item.si_bulan | formatMonthNameOnly }}</span>
      </template>
      <template #cell(si_harikerja_guru)="{ data }">
        <form @submit.prevent="saveEdit(data)" v-if="table.selectedType === data.field.key && data.item.i_id == table.selectedCell.item.i_id"> <b-form-input type="number" v-model="data.item.si_harikerja_guru"></b-form-input></form>
        <span v-else @click="editCellHandler(data, 'si_harikerja_guru')">{{ data.item.si_harikerja_guru }}</span>
      </template>
      <!--
			<template v-slot:cell(rowaction)="{ data }">
				<button
					type="button"
					class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
					v-b-tooltip.hover
					title="Ubah"
					@click="ubah(data.item)">
					<i class="fal fa-align-left"></i>
				</button>	
				<button
					type="button"
					class="btn btn-danger btn-dt-refresh btn-sm rounded waves-effect waves-themed mr-2"
                        v-b-tooltip.hover
					title="Hapus Data"
					@click="deleteProgress(data.item.i_id)">
					<i class="fal fa-align-left"></i>
				</button>			
			</template>
			-->
    </data-table>		

    <form-tambah-jumlah-hari-kerja-efektif :m-id="modal.id" :title="modal.title" :dat-non-guru="tempDataNonGuru" width="80%"></form-tambah-jumlah-hari-kerja-efektif>
    <form-ubah-jumlah-hari-kerja-efektif :m-id="modal.idubah" :title="modal.titleubah" :detail="modal.arahan" :item="item"></form-ubah-jumlah-hari-kerja-efektif>
  </section>
</template>

<script>
import FormTambahJumlahHariKerjaEfektif from './__jumlah_hari_kerja/FormTambahJumlahHariKerjaEfektif'
import FormUbahJumlahHariKerjaEfektif from './__jumlah_hari_kerja/FormUbahJumlahHariKerjaEfektif'

export default {
	name: 'JumlahHariKerja',
	components: {
		FormTambahJumlahHariKerjaEfektif,
		FormUbahJumlahHariKerjaEfektif,
	},
	data() {
		return {
			actions: 'SRNL',
			table: {
				id: 'jumlah-hari-kerja',
				selectedCell: null,
				selectedType: null,
				items: [],
				fields: [
					/*{
						key: 'rowaction',
						class: 'text-center',
					},*/
					{
						key: 'rownum',
						class: 'text-center',
					},
					{
						key: 'v_tahun',
						label: 'Tahun',
						sortable: true,
					},					
					{
						key: 'si_bulan',
						label: 'Bulan',
						sortable: true,
					},
					{
						key: 'si_harikerja_nonguru',
						label: 'Jumlah Hari Kerja Non Guru',
						sortable: true,
					},
					
					{
						key: 'si_harikerja_guru',
						label: 'Jumlah Hari Kerja Guru',
						sortable: true,
					},
				],
			},
			form: {
				created_at: null,
				created_by: null,
				i_id: null,
				harikerja_guru: '',
			},
			modal: {
				id: 'form-tambah',
				title: 'Tambah Jumlah Hari Kerja',
				idubah: 'form-ubah',
				titleubah: 'Ubah Jumlah Hari Kerja'
			},
			item:{},
			itemsData: [],
			tempDataNonGuru: [],
		}
	},
	computed: {
	},
	mounted() { },
	created() {
	},
	methods: {
		editCellHandler(data, name) {
			this.table.selectedCell = data
			this.table.selectedType = name
		},
		saveEdit(data){
			console.log(data);
			let vm = this
			this.form.created_by 		= this.$app.user.v_userid
			this.form.created_at 		= moment().format("yyyy-MM-DD")
			this.form.i_id 				= data.item.i_id
			this.form.harikerja_guru	= data.item.si_harikerja_guru
			let dataForm 				= Object.assign({}, vm.$data.form)
			let mode 					= 'edit'
			let url 					=  vm.$app.route('jumlah-hari-kerja.update')
			let method 					= 'post'
			vm.$app.confirm({
				text: vm.$t(`manajemendata.alert.confirm.jum_harikerja.${mode}`),
				preConfirm: () => {
				return vm.$http
					[method](url, dataForm)
					.then(response => {
						console.log(response)
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
				if (result.value.data.status == "success" || result.value.data.status == "info") 
				{
					vm.$app.success(
					result.value.data.message,
					result.value.data.status,
					vm.$t(`manajemendata.alert.${result.value.data.status}`)
					)
					.then(response => {
						if (response.value === true) 
						{
							this.table.selectedType 	= ''
						}
					})
				}
			})
		},
		async handleAdd() 
		{
			this.$bvModal.show(this.modal.id)
			const action 				= this.$app.route('jumlah-hari-kerja.data-non-guru.get', {'tahun': this.$app.getCurrentDate('YYYY')})
        	const {data} 				= await this.$http.get(action)
			this.tempDataNonGuru 		= data			
			//this.tempDataNonGuru = this.itemsData
		},
		ubah(params) {
			this.item=params
			this.$bvModal.show(this.modal.idubah)
		},
		deleteProgress(params){
			const vm = this
			vm.$app.confirm({
			text: 'Apakah yakin akan menghapus data',
			preConfirm: () => {
				return vm.$http
				.delete(vm.$app.route('jumlah-hari-kerja.delete.progress'), {
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
							vm.$root.$emit('bv::refresh::table', 'jumlah-hari-kerja')
							vm.$bvModal.hide(vm.mId)
						}
					})
				}
			})
		},
	}
}
</script>

<style lang="scss" scoped>
.line-clamp {
	overflow: hidden;
	display: -webkit-box;
	-webkit-line-clamp: 3;
	-webkit-box-orient: vertical;
}
</style>
