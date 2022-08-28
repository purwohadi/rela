<template>
  <div class="row">
    <div class="col-12">
      <section class="user">
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="perangkat_daerah"
          label="Perangkat Daerah">
            <m-select
              id="perangkat-daerah"
              ref="perangkat-daerah"
              class="col-4"
              :option-height="73"
              :placeholder="'--pilih perangkat daerah--'"
              :tabindex="7"
              :options="optionsPerangkatDaerah"
              v-model="model.perangkatDaerah"
              :custom-label="namePerangkatDaerah"
              select-label=""
              selected-label=""
              deselect-label=""
              :preselect-first="false"
              track-by="nama_opd"
              :searchable="true"
              :limit="100"
              :options-limit="100"
            >

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
        </b-form-group>
        <data-tables
        id="domaintable" :fields="fields"
        :title="$t('domain.datatable.title.t_infrastruktur_cloud')"
        api-url="domain-infrastruktur-cloud.get"
        :args-route="{'opd_id': opd_id ? opd_id : $route.params.opd_id ? $route.params.opd_id != null : 0}"
        :actions="actionsAplikasi"
        row-action-width="10%"
        @add="handleAdd"
        @update="handleUpdate" @detail="handleDetail" @delete="handleDelete">
        </data-tables>
      </section>
    </div>
  </div>
</template>

<script>
import { extend } from 'vee-validate'
export default {
  name: 'DomainInfrastrukturCloud',
  filters: {
    getFirst(value = []) {
      let temp = [...value]
      return temp.length ? temp.shift().name : ''
    }
  },
  data() {
    return {
      show: true,
      tableId: 'domaintable',
      title: '',
      opd_id: '',
      model:{
				perangkatDaerah: []
			},
      optionsPerangkatDaerah:[],
      form: {
        id: null,
        name: ''
      },
      fields: [
        {
          key: 'rowaction',
          label: '',
          sortable: false,
          class: 'text-center',
        },
        {
          key: 'rai_level_1',
          label: this.$t('domain.datatable.column.v_rai1'),
          sortable: true,
        },
        {
          key: 'rai_level_2',
          label: this.$t('domain.datatable.column.v_rai2'),
          sortable: true,
        },
        {
          key: 'rai_level_3',
          label: this.$t('domain.datatable.column.v_rai3'), //INI lihatnya di js>lang
          sortable: true,
        },
        {
          key: 'instansi',
          label: this.$t('domain.datatable.column.v_instansi'),
          sortable: true,
        },
        {
          key: 'nama',
          label: this.$t('domain.datatable.column.v_gov_cloud'),
          sortable: true,
        },
        {
          key: 'deskripsi',
          label: this.$t('domain.datatable.column.v_des_gov_cloud'),
          sortable: true,
        },
        {
          key: 'status_ownership',
          label: this.$t('domain.datatable.column.v_status_own'),
          sortable: true,
        },
        {
          key: 'nama_owner',
          label: this.$t('domain.datatable.column.v_name_own'),
          sortable: true,
        },
        {
          key: 'domain_code',
          label: 'Domain Code',
          sortable: true,
        }
      ]
    }
  },
  created() {
  },
  watch: {
    'model.perangkatDaerah': {
			handler: function(n, o) {
				if (!_.isEmpty(n)) {
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id : '0'

          if(!(!_.isEmpty(o) && (n.opd_id == o.opd_id))) {
            this.$root.$emit('bv::refresh::table', this.tableId)
          }
				}
			},
		},
	},
  computed: {
		actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-proses-bisnis') ? 'L' : ''

			if (this.opd_id) {
        if((this.opd_id==this.$app.user?.opd_id) || this.$app.user.is_admin) {
          actions += this.$app.user.can('tambah-proses-bisnis') ? 'C' : ''
					actions += this.$app.user.can('edit-proses-bisnis') ? 'U' : ''
					actions += this.$app.user.can('hapus-proses-bisnis') ? 'D' : ''
				}
			}
      return actions
		}
	},
  mounted () {
    let query_opd = this.$route.params.opd_id ? this.$route.params.opd_id : this.$app.user.opd_id
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
			return this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {})).then((res) => {
				this.optionsPerangkatDaerah = res.data
        this.cloneOptionsPerangkatDaerah = res.data
				this.model.perangkatDaerah = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
		async resPerangkatDaerahById(){
			return this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {opd_id: this.opd_id})).then((res) => {
				this.model.perangkatDaerah = res.data[0]
			})
		},
		namePerangkatDaerah ({nama_opd,opd_id}) {
      return nama_opd ? nama_opd : '--pilih perangkat daerah--'
		},
    handleAdd() {
      this.$router.push({ name: 'infrastruktur-cloud-add', params: {
        'opd_id' : this.opd_id != '0' ? this.opd_id : this.$route.params.opd_id
      }})
    },
    handleUpdate(item, index, $el) {
      this.$router.push({name: 'infrastruktur-cloud-update', params: {
				'id': item.slug_path,
        'opd_id' : item.opd_id,
				'status': 'update'
			}})
    },
    handleDetail(item, index, $el) {
      this.$router.push({name: 'infrastruktur-cloud-detil', params: {
				'id': item.slug_path,
        'opd_id' : item.opd_id,
				'status': 'detail'
			}})
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('domain.alert_cloud.confirm.drop'),
        preConfirm: () => {
          return vm.$http
            .post(vm.$app.route('domain-infrastruktur-cloud.drop'), {
              data: { id: item.id}
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
            vm.$app.success(this.$t(`domain.alert_cloud.actions.drop.${result.value.data.status}`))
              .then(response => {
                if (response.value === true) {
                  vm.$root.$emit('bv::refresh::table', 'domaintable')
                }
              })
          }
        })
    },
  }
}
</script>
