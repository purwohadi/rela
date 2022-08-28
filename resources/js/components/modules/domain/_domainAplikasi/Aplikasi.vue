<template>
  <div class="row">
    <div class="col-12">
      <div class="panel">
			<div class="col-12">
				<template>  					
					<b-form-group
						label-cols="2"
						label-cols-lg="2"
						label-for="perangkat_daerah"
						label="Perangkat Daerah">   
						<validation-provider name="Perangkat Daerah" rules="required" v-slot="{ errors, ariaMsg }">                     
							<m-select
								id="perangkat-daerah"
								ref="perangkat-daerah"
								class="col-4"
								:option-height="73"
								:tabindex="7"
								:placeholder="'--pilih perangkat daerah--'"
								:options="optionsPerangkatDaerah"
								v-model="model.perangkatDaerah"
								label="nama_opd"
								track-by="nama_opd"
								:searchable="true"
								:limit="100"
								:options-limit="100">     

								<template #noOptions>
									Tidak ada data
								</template>
								<template #noResult>
									Data tidak ditemukan
								</template>

								<template #option="{ option }">
									<div class="d-flex align-items-baseline mb-1">
										<i class="fal fa-laptop mr-2"></i>
										<span class="text-wrap">{{ option.nama_opd }}</span>
									</div>
								</template>
							</m-select>  
							<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
								{{ errors[0] }}
							</small>
						</validation-provider>
					</b-form-group>        
				</template>									
			</div>
		</div>
      <section class="aplikasi">
        <data-tables
          :id="tableId"
          :api-url="'domain-aplikasi.list'"
          :args-route="{
            opd_id: opd_id
          }"
          :fields="fields"
          :title="$t('aplikasi.datatable.title')"
          :actions="actionsAplikasi"
          row-action-width="10%"
          @add="handleAdd"
			@update="handleUpdate"
			@delete="handleDelete"
			@detail="handleDetail"
          default-sort-by="nama_apl"
        >
        </data-tables>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Aplikasi',
  data() {
    return {
	tableId: 'aplikasi-table',
      show: true,
      title: '',
      opd_id: '',
      form: {
        id: null,
        name: ''
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
          key: 'raa_level1',
          label: this.$t('aplikasi.datatable.column.raa_level1'),
          sortable: true,
        },
        {
          key: 'raa_level2',
          label: this.$t('aplikasi.datatable.column.raa_level2'),
          sortable: true,
        },
        {
          key: 'raa_level3',
          label: this.$t('aplikasi.datatable.column.raa_level3'),
          sortable: true,
        },
        {
          key: 'raa_level4',
          label: this.$t('aplikasi.datatable.column.raa_level4'),
          sortable: true,
        },
        {
          key: 'nama_apl',
          label: this.$t('aplikasi.datatable.column.nama_apl'),
          sortable: true,
        },
        {
          key: 'app_ownership',
          label: this.$t('aplikasi.datatable.column.app_ownership'),
          sortable: true,
        },
      ],
      model:{
				perangkatDaerah: null
			},
			optionsPerangkatDaerah: []
    }
  },
  watch: {
		'model.perangkatDaerah': {
			handler: function(n, o) {
				if (!_.isEmpty(n)) {				
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id:n[0].opd_id
					let params = Object.entries({opd_id: n.opd_id,})
					.map(([key, val]) => `${key}=${val}`).join('&');
						
					window.history.pushState({}, '','?'+params)
				} else {
					this.opd_id = null
				}
				if(!(!_.isEmpty(n) && !_.isEmpty(o) && (n.opd_id == o.opd_id))) {
					this.$root.$emit('bv::refresh::table', this.tableId)
				}
			},
		}
	},
	computed: {
		actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-aplikasi') ? 'L' : ''

			if (this.opd_id) {
				if((this.opd_id === this.$app.user.opd_id) || this.$app.user.is_admin) {
					actions += this.$app.user.can('tambah-aplikasi') ? 'C' : ''
					actions += this.$app.user.can('edit-aplikasi') ? 'U' : ''
					actions += this.$app.user.can('hapus-aplikasi') ? 'D' : ''
				}
			}
			return actions

		}
	},
	mounted () {
		let query_opd = this.$route.query.opd_id ? this.$route.query.opd_id : this.$app.user.opd_id

		this.opd_id = query_opd
		this.resPerangkatDaerah().then(() => {
			if(!this.$app.user.is_admin || this.$route?.query?.opd_id) {
				this.resPerangkatDaerahById()
			}
			this.$root.$emit('bv::refresh::table', this.tableId)
		})
	},
  methods: {
    async resPerangkatDaerah(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {})).then((res) => {
				this.optionsPerangkatDaerah = res.data
				this.model.perangkatDaerah = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
		async resPerangkatDaerahById(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.opd_id})).then((res) => {
				this.model.perangkatDaerah = res.data[0]
			})
		},
		handleAdd() {
			this.$router.push({name: 'aplikasi-add', params: { opd_id: this.opd_id } })
		},
		handleUpdate(item, index, $el) {
			this.$router.push({name: 'aplikasi-edit', params: { id: item.slug_path, opd_id: this.opd_id }})
		},
		handleDelete(item, index, $el) {
			let vm = this
			let url 	=  vm.$app.route('domain-aplikasi.delete')
			let method = 'post'
			vm.$app.confirm({
				text: vm.$t('aplikasi.alert.confirm.drop', {name: item.nama_apl}),
				preConfirm: () => {
					return vm.$http
						[method](url, {id: item.slug_path})
						.then(response => {
							if (response.data.status == "error") {
								throw new Error(response.data.message)
							} else if (response.data.status == "error_used") {
								let splp = response.data.data.reduce((total, item) => {
									return total + '<li><strong>' + item.nama_opd + '</strong>-' + item.nama + '</li>'
								}, '')
								let err_msg = response.data.message + '<br/><ol>' + splp + '</ol>'
								vm.$app.alert.fire({
									icon: 'error',
									title: 'Error',
									html: '<div class="text-left">' + err_msg + '</div>'
								})
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
						vm.$root.$emit('bv::refresh::table', this.tableId)
					}
				})
		},
		handleDetail(item, index, $el) {
			this.$router.push({name: 'aplikasi-detail', params: { id: item.slug_path, opd_id: this.opd_id }})
		}
  }
}
</script>
