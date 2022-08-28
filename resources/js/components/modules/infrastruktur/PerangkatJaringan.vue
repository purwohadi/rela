<template>
	<div class="row">
    <div class="col-12">
      <div class="panel">
				<div class="col-12">
					<template>
            <div>Untuk melakukan modifikasi data (tambah, ubah, hapus), mohon menghubungi Pengelola Data JIPD :</div>
            <br>
            <div>1. Budi Supriyanto  +628158367210</div>
            <div>2. Willy Riady Azhar  +6281296630230</div>
            <div>3. Amy Devriadi +6285719265620</div>
					</template>
				</div>
			</div>
    </div>
		<div class="col-12">
			<section class="perangkat-jaringan">
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="'perangkat-jaringan.data-netdev.get'"
					:title="$t('infrastruktur.datatable.titlePerangkatJaringann')"
					:actions="actionsAplikasi"
					row-action-width="10%"
					@add="handleAdd">

					<template #cell(rowaction)="{data}">
						<button
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.view')"
							@click.prevent="handleDetil(data.item)">
							<i class="fal fa-info"></i> Lihat
						</button>

						<button
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUbah(data.item)">
							<i class="fal fa-pen-alt"></i> Ubah
						</button>

						<button
							type="button"
							class="btn btn-danger btn-xs rounded waves-effect waves-themed"
							v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
							@click.prevent="handleDelete(data.item)">
							<i class="fal fa-trash"></i> Hapus
						</button>
					</template>

					<template #cell(proses_id)="{data}">
						{{ data.item.proses_id }} - {{ data.item.ral_level4 }}
					</template>
				</data-tables>
			</section>
		</div>
	</div>
</template>

<script>
export default {
	name: 'PerangkatJaringan',
	data() {
		return {
			tableId: 'perangkat-jaringan',
      opd_id: '',
      model:{
				perangkatDaerah: []
			},
      optionsPerangkatDaerah:[],
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
					key: 'nama',
					label: 'Nama Perangkat Jaringan',
					sortable: true,
				},
				{
					key: 'deskripsi',
					label: 'Deskripsi Perangkat Jaringan',
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
					key: 'tipe_device',
					label: 'Tipe Perangkat',
					sortable: true,
				},
				{
					key: 'tipe_device_2',
					label: 'Tipe Perangkat 2',
					sortable: true,
				},
				{
					key: 'keterangan',
					label: 'Keterangan',
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
	created() {
	},
    watch: {
    // 'model.perangkatDaerah': {
		// 	handler: function(n, o) {
		// 		if (!_.isEmpty(n)) {
		// 			this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id : '0'

    //       if(!(!_.isEmpty(o) && (n.opd_id == o.opd_id))) {
    //         this.$root.$emit('bv::refresh::table', this.tableId)
    //       }
		// 		}
		// 	},
		// },
	},
  computed: {
		actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-proses-bisnis') ? 'L' : ''

			if((this.opd_id==this.$app.user?.opd_id) || this.$app.user.is_admin) {
        actions += this.$app.user.can('tambah-proses-bisnis') ? 'C' : ''
        actions += this.$app.user.can('edit-proses-bisnis') ? 'U' : ''
        actions += this.$app.user.can('hapus-proses-bisnis') ? 'D' : ''
      }
      return actions
		}
	},
  mounted () {
    // let query_opd = this.$route.params.opd_id ? this.$route.params.opd_id : this.$app.user.opd_id
		// this.opd_id = query_opd
		// this.resPerangkatDaerah().then(() => {
		// 	if(!this.$app.user.is_admin || this.$route?.query?.opd_id) {
		// 		this.resPerangkatDaerahById()
		// 	}
		// 	this.$root.$emit('bv::refresh::table', this.tableId)
		// })
  },
	methods: {
    // async resPerangkatDaerah(){
		// 	return this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {})).then((res) => {
		// 		this.optionsPerangkatDaerah = res.data
    //     this.cloneOptionsPerangkatDaerah = res.data
		// 		this.model.perangkatDaerah = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
		// 	})
		// },
		// async resPerangkatDaerahById(){
		// 	return this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {opd_id: this.opd_id})).then((res) => {
		// 		this.model.perangkatDaerah = res.data[0]
		// 	})
		// },
		// namePerangkatDaerah ({nama_opd,opd_id}) {
    //   return nama_opd ? nama_opd : '--pilih perangkat daerah--'
		// },
		handleUbah(data){
			this.$router.push({name: 'infrastruktur.ubah-perangkat-jaringan', params: {
				'id': data.slug_path,
				'status': 'edit'
			}})
		},
		handleDetil(data){
			this.$router.push({name: 'infrastruktur.detil-perangkat-jaringan', params: {
				'id': data.slug_path,
				'status': 'detail'
			}})
		},
		handleAdd() {
			this.$router.push({ name: 'infrastruktur.tambah-perangkat-jaringan', params: {
        // 'opd_id' : this.opd_id != '0' ? this.opd_id : this.$route.params.opd_id
      }})
		},
		handleDelete(data){
			let vm 			= this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
						.post(vm.$app.route('perangkat-jaringan.delete-data-domain-infra-netdev'), {
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
					vm.$app.success(result.value.data.message)
						.then(response => {
							if (response.value === true) {
								this.$root.$emit('bv::refresh::table', this.tableId)
							}
						})
				}
			})
		},
	},
}
</script>
