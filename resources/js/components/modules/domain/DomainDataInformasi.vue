<template>
  <div class="row">
    <div class="col-12">
      <div class="panel" style="margin-left: 15px; margin-right: 15px">
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
                class="mb-2 col-4"
                :option-height="73"
                :tabindex="7"
                :options="optionsPerangkatDaerah"
                v-model="model.perangkatDaerah"
                :custom-label="namePerangkatDaerah"
                select-label=""
                selected-label=""
                deselect-label=""
                track-by="nama_opd"
                :placeholder="'--pilih perangkat daerah--'"
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
      <section class="user">
        <div class="tab-content p-3" style="margin-top: -15px">
          <div class=" tab-pane fade show active" id="tab_justified-1" role="tabpanel">
            <data-tables
              id="datainfotable"
              :fields="fields"
              :api-url="'domain-data-informasi.get'"
              :args-route="{'opd_id': opd_id}"
              :title="$t('domain.datatable.title.t_data_informasi')"
              :actions="actionsAplikasi"
              row-action-width="10%"
              @add="handleAdd"
              @update="handleUpdate"
              @detail="handleDetail"
              @delete="handleDelete">
            </data-tables>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DomainDataInformasi',
  data(){
    return{
      opd_id: '',
      model:{
				perangkatDaerah: []
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
          key: 'rownum',
          class: 'text-center',
          sortable: false,
        },
        {
          key: 'rad_level1_nama',
          label: this.$t('domain.datatable.column.v_radl1'),
          sortable: true,
        },
        {
          key: 'rad_level2_nama',
          label: this.$t('domain.datatable.column.v_radl2'),
          sortable: true,
        },
        {
          key: 'rad_level3_nama',
          label: this.$t('domain.datatable.column.v_radl3'),
          sortable: true,
        },
        {
          key: 'nama_opd',
          label: this.$t('domain.datatable.column.v_tup_nama_opd'), //INI lihatnya di js>lang
          sortable: true,
        },
        {
          key: 'nama_data',
          label: this.$t('domain.datatable.column.v_nama_data'),
          sortable: true,
        },
      ],
    }
  },
  watch: {
    'model.perangkatDaerah': {
			handler: function(n,o) {
				if (!_.isEmpty(n)) {				
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id:n[0].opd_id
					let params = Object.entries({opd_id: n.opd_id,})
					.map(([key, val]) => `${key}=${val}`).join('&');
						
					window.history.pushState({}, '','?'+params)
				} else {
					this.opd_id = null
				}
				if(!(!_.isEmpty(n) && !_.isEmpty(o) && (n.opd_id == o.opd_id))) {
          this.$root.$emit('bv::refresh::table', 'datainfotable')
				}
			},
		},
  },
  computed: {
		actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-data-dan-informasi') ? 'L' : ''
			if (this.opd_id) {
        if (this.$app.user.opd_id) {
          if((this.opd_id==this.$app.user?.opd_id) || this.$app.user.is_admin) {
            actions += this.$app.user.can('tambah-data-dan-informasi') ? 'C' : ''
            actions += this.$app.user.can('edit-data-dan-informasi') ? 'U' : ''
            actions += this.$app.user.can('hapus-data-dan-informasi') ? 'D' : ''
          }
        } else {
          actions += this.$app.user.can('tambah-data-dan-informasi') ? 'C' : ''
          actions += this.$app.user.can('edit-data-dan-informasi') ? 'U' : ''
          actions += this.$app.user.can('hapus-data-dan-informasi') ? 'D' : ''
        }
			}
      return actions
		}
	},
  created(){
    // console.log(this.opd_id);
		// this.resPerangkatDaerah()
		// this.resPerangkatDaerahById()
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
		namePerangkatDaerah ({nama_opd,opd_id}) {
			return `${nama_opd}`
		},
    handleAdd() {
      this.$router.push({ name: 'domain-data-informasi-add', params: {
        'opd_id' : this.opd_id
      }})
    },
    handleUpdate(item, index, $el) {
      // console.log(item.proses_id);
      this.$router.push({name: 'data-informasi-update', params: {
        'opd_id' : this.opd_id,
				'info_id': item.info_id,
				'status': 'update'
			}})
    },
    handleDetail(item, index, $el) {
      console.log(item);
      this.$router.push({name: 'data-informasi-detil', params: {
				'info_id': item.info_id,
        'opd_id' : this.opd_id,
				'status': 'detail'
			}})
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('domain.alert_data_informasi.confirm.drop'),
        preConfirm: () => {
          return vm.$http
            .post(vm.$app.route('domain-data-informasi.drop'), {
              data: { info_id: item.info_id}
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
            vm.$app.success(this.$t(`domain.alert.actions.drop.${result.value.data.status}`))
              .then(response => {
                if (response.value === true) {
                  vm.$root.$emit('bv::refresh::table', 'datainfotable')
                }
              })
          }
        })
    },
  }
}
</script>

<style>

</style>
