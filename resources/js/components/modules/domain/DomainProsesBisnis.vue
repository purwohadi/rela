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
                  @close="handleOnClose"
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
					</template>
				</div>
			</div>
    </div>
    <div class="col-12">
      <section class="user">
        <div class="col-9">
          <ul class="nav nav-tabs nav-fill" role="tablist" style="margin-left: 4px; margin-right: 15px;">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_justified-1" role="tab">ProsesBisnis</a>
            </li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_justified-2" role="tab">Referensi Kepmendagri 50/2020</a>
            </li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_justified-3" role="tab">Referensi Tupoksi</a>
            </li>
          </ul>
        </div>
        <div class="tab-content p-3" style="margin-top: -15px">
          <div class=" tab-pane fade show active" id="tab_justified-1" role="tabpanel">
            <data-tables
              id="usertable"
              :fields="fields"
              :api-url="'domain-proses.get'"
              :args-route="{'opd_id': opd_id ? opd_id : $route.params.opd_id ? $route.params.opd_id != null : 0}"
              :title="$t('domain.datatable.title.t_domain_proses')"
              :actions="actionsAplikasi"
              row-action-width="10%"
              @add="handleAdd"
              @update="handleUpdate"
              @detail="handleDetail"
              @delete="handleDelete">
            </data-tables>
          </div>
          <div class="tab-pane fade" id="tab_justified-2" role="tabpanel">
            <div class="col-12">
              <div class="panel" style="margin-left: -15px; margin-right: -15px">
                <div class="col-12">
                  <template>
                    <b-form-group
                      label-cols="2"
                      label-cols-lg="2"
                      label-for="kewenangan"
                      label="Tingkat Kewenangan">
                        <m-select
                          id="kewenangan"
                          ref="kewenangan"
                          class="col-4"
                          :option-height="73"
                          :placeholder="'--pilih tingkat--'"
                          :tabindex="7"
                          :options="optionsKewenangan"
                          v-model="model.kewenangan"
                          @input="changeKewenangan"
                          select-label=""
                          selected-label=""
                          deselect-label=""
                          label="label"
                          value="value"
                          :searchable="true"
                          :limit="100"
                          :options-limit="100"
                          @close="handleOnClose"
                          :disabled="!opdUnique"
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
                              <span class="text-wrap">{{ option.label }}</span>
                            </div>
                          </template>
                        </m-select>
                    </b-form-group>
                  </template>
                </div>
              </div>
            </div>
            <data-tables
              id="refkemendagri_table" :fields="fields2"
              api-url="ref-kemendagri.get" :args-route="{'is_provinsi': is_provinsi ? is_provinsi : null}" :title="$t('domain.datatable.title.t_ref_mendagri')"
              actions="S" row-action-width="10%" @add="handleAdd"
              @update="handleUpdate" @detail="handleDetail" @delete="handleDelete">
            </data-tables>
            <!-- <p>Message is: {{ message }}</p>
            <input v-model="message" placeholder="edit me" /> -->
          </div>
          <div class="tab-pane fade" id="tab_justified-3" role="tabpanel">
            <data-tables
              id="usertable" :fields="fields3"
              :api-url="'ref-tupoksi.get'" :args-route="{'opd_id': opd_id}" :title="$t('domain.datatable.title.t_tupoksi')"
              actions="S" row-action-width="10%" @add="handleAdd" @update="handleUpdate" @detail="handleDetail"
              @delete="handleDelete">
            </data-tables>
          </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>
import { extend } from 'vee-validate'
export default {
  name: 'DomainProsesBisnis',
  data() {
    return {
      show: true,
      title: '',
      opd_id: '',
      model:{
				perangkatDaerah: [],
				kewenangan: []
			},
      form: {
        id: null,
        name: ''
      },
      optionsPerangkatDaerah:[],
      optionsKewenangan:[
        { value: 'provinsi', label: 'Kewenangan Tingkat Provinsi' },
        { value: 'kota', label: 'Kewenangan Tingkat Kota' }
      ],
      cloneOptionsPerangkatDaerah: [],
      fields: [
        {
          key: 'rowaction',
          label: '',
          sortable: false,
          class: 'text-center',
        },
        {
          key: 'domain_code',
          label: this.$t('domain.datatable.column.v_domain_code'),
          sortable: true,
        },
        {
          key: 'nama_opd',
          label: this.$t('domain.datatable.column.v_unitkerja'), //INI lihatnya di js>lang
          sortable: true,
        },
        {
          key: 'rab_level1',
          label: this.$t('domain.datatable.column.v_rabl1'),
          sortable: true,
        },
        {
          key: 'rab_level2',
          label: this.$t('domain.datatable.column.v_rabl2'),
          sortable: true,
        },
        {
          key: 'rab_level3',
          label: this.$t('domain.datatable.column.v_rabl3'),
          sortable: true,
        },
        {
          key: 'rab_level4',
          label: this.$t('domain.datatable.column.v_rabl4'),
          sortable: true,
        },
      ],
      fields2: [
        {
          key: 'urusan',
          label: this.$t('domain.datatable.column.v_ref_urus'),
          sortable: true,
        },
        {
          key: 'bid_urusan',
          label: this.$t('domain.datatable.column.v_ref_bidang'),
          sortable: true,
        },
        {
          key: 'program',
          label: this.$t('domain.datatable.column.v_ref_prog'), //INI lihatnya di js>lang
          sortable: true,
        },
        {
          key: 'kegiatan',
          label: this.$t('domain.datatable.column.v_ref_keg'),
          sortable: true,
        },
        {
          key: 'sub_kegiatan',
          label: this.$t('domain.datatable.column.v_ref_sub_keg'),
          sortable: true,
        },
        {
          key: 'nomenklatur_urusan',
          label: this.$t('domain.datatable.column.v_ref_nomenklatur'),
          sortable: true,
        },
        {
          key: 'kinerja',
          label: this.$t('domain.datatable.column.v_ref_kin'),
          sortable: true,
        },
        {
          key: 'indikator',
          label: this.$t('domain.datatable.column.v_ref_indikator'),
          sortable: true,
        },
        {
          key: 'satuan',
          label: this.$t('domain.datatable.column.v_ref_satuan'),
          sortable: true,
        }
      ],
      fields3: [
        {
          key: 'id_entitas',
          label: this.$t('domain.datatable.column.v_tup_id_entitas'),
          sortable: true,
        },
        {
          key: 'nama_unit',
          label: 'Nama Bidang/UPT',
          sortable: true,
        },
        {
          key: 'nama_opd',
          label: this.$t('domain.datatable.column.v_tup_nama_opd'),
          sortable: true,
        },
        {
          key: 'tupoksi',
          label: this.$t('domain.datatable.column.v_tup_tupoksi'),
          sortable: true,
        },
        {
          key: 'tupoksi_desc',
          label: this.$t('domain.datatable.column.v_tup_des'),
          sortable: true,
        },
      ],
    }
  },
  watch: {
    'model.perangkatDaerah': {
			handler: function(n, o) {
				if (!_.isEmpty(n)) {
					this.opd_id = (typeof n.opd_id !== 'undefined')?n.opd_id : '0'

          if(!(!_.isEmpty(o) && (n.opd_id == o.opd_id))) {
            this.changeOPD()
            this.$root.$emit('bv::refresh::table', 'usertable')
          }
				}
			},
		},
	},
  created(){
    this.is_provinsi = this.opd_id == 'O46' || this.opd_id == 'O51' ? '1' : this.$app.user.is_admin ? '2' : '0'
    this.opdUnique = null
  },
  computed: {
		actionsAplikasi() {
			let actions = 'SR'
			actions += this.$app.user.can('lihat-daftar-proses-bisnis') ? 'L' : ''

			if (this.opd_id) {
        if (this.$app.user.opd_id) {
          if((this.opd_id==this.$app.user?.opd_id) || this.$app.user.is_admin) {
            actions += this.$app.user.can('tambah-proses-bisnis') ? 'C' : ''
            actions += this.$app.user.can('edit-proses-bisnis') ? 'U' : ''
            actions += this.$app.user.can('hapus-proses-bisnis') ? 'D' : ''
          }
        } else {
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
    changeOPD(){
      if(this.opd_id == 'O46' || this.opd_id == 'O51'){
        this.opdUnique = true
        this.model.kewenangan = this.optionsKewenangan[1]
        this.changeKewenangan();
      }else{
        this.opdUnique = false
        this.model.kewenangan = this.optionsKewenangan[0]
        this.changeKewenangan();
      }
    },
    changeKewenangan(){
      if(this.model.kewenangan.value == 'kota'){
        this.is_provinsi = '0'
      }else{
        this.is_provinsi = '1'
      }
      this.$root.$emit('bv::refresh::table', 'refkemendagri_table')
    },
    async resPerangkatDaerah(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {})).then((res) => {
				this.optionsPerangkatDaerah = res.data
        this.cloneOptionsPerangkatDaerah = res.data
				this.model.perangkatDaerah = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
		async resPerangkatDaerahById(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.opd_id})).then((res) => {
				this.model.perangkatDaerah = res.data[0]
			})
		},
		namePerangkatDaerah ({nama_opd,opd_id}) {
      return nama_opd ? nama_opd : '--pilih perangkat daerah--'
		},
    handleAdd() {
      this.$router.push({ name: 'proses-bisnis-add', params: {
        'opd_id' : this.opd_id != '0' ? this.opd_id : this.$route.params.opd_id
      }})
    },
    handleUpdate(item, index, $el) {
      this.$router.push({name: 'proses-bisnis-update', params: {
				'proses_id': item.proses_id,
        'opd_id' : item.opd_id,
				'status': 'update'
			}})
    },
    handleDetail(item, index, $el) {
      this.$router.push({name: 'proses-bisnis-detil', params: {
				'proses_id': item.proses_id,
        'opd_id' : item.opd_id,
				'status': 'detail'
			}})
    },
    handleDelete(item, index, $el) {
      const vm = this
      vm.$app.confirm({
        text: vm.$t('domain.alert.confirm.drop'),
        preConfirm: () => {
          return vm.$http
            .post(vm.$app.route('domain-proses.drop'), {
              data: { id: item.proses_id}
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
            vm.$app.alert.fire({
              icon: result.value.data.status,
              title: result.value.data.status ? 'Sukses' : 'Info',
              text: result.value.data.message,
              showConfirmButton: false,
              timer: 1300
            })
            .then(response => {
              vm.$bvModal.hide(vm.modal)
              this.$router.push({ name: 'domainprosesbisnis', params: {
                'opd_id' : this.$route.params.opd_id
              }})
              vm.$root.$emit('bv::refresh::table', 'usertable')
            })
          }else{
            vm.$app.alert.fire({
              icon: result.value.data.status,
              title: result.value.data.status == 'info' ? 'Info' : null,
              html: result.value.data.message,
              showConfirmButton: true
            })
          }
        })
    },
    handleOnClose() {
      // let model = this.model.perangkatDaerah,
      //     idx = this.cloneOptionsPerangkatDaerah.findIndex(opt => opt.slug_path === model.slug_path),
      //     temp = [...this.cloneOptionsPerangkatDaerah]

      // temp.splice(idx, 1)
      // temp.unshift(model)
      // this.optionsPerangkatDaerah = [...temp]
    }
  }
}
</script>
