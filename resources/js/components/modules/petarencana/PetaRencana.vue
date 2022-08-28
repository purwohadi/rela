<template>
  <div class="row">
    <div class="col-12">
      <section class="peta-rencana">
        <div v-if="!opd_id || $app.user.is_admin" class="panel">
            <div class="col-6 col-md-4">
                <template>                            
                    <m-select
                        id="perangkat-daerah"
                        ref="perangkat-daerah"
                        class="mb-2"
                        :option-height="73"
                        :tabindex="7"
                        :options="optionsPerangkatDaerah"
                        v-model="model.opd"
                        label="nama_opd"
                        :placeholder="$t('petarencana.form.field.opd.placeholder')"
                        select-label=""
                        selected-label=""
                        deselect-label=""
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
                </template>									
            </div>
        </div>
        <div v-if="model.opd" class="panel">
            <div class="col-6 mb-4">
                <ul class="nav nav-tabs nav-fill" role="tablist" style="margin-left: 4px; margin-right: 15px;">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tab_justified-1" role="tab">
                            {{ $t('petarencana.meta.label') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tab_justified-2" role="tab">
                            {{ $t('petarencana.meta.label_ref_inisiatif') }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content p-3" style="margin-top: -15px">
                <div 
                    class=" tab-pane fade show active" 
                    id="tab_justified-1" 
                    role="tabpanel"
                >
                  <inisiatif-form 
                    v-if="isFormOpen" 
                    :bidur="form.bidur_kode"
                    :domain="domain"
                    :program="form.program"
                    :program_id="form.id"
                    @back="isFormOpen=false"
                  ></inisiatif-form>
                  <div v-else>
                    <ValidationObserver v-slot="{ passes }" :slim="true">
						         <form @submit.prevent="passes(onSubmit)">
                      <b-row class="mb-2">
                        <b-col sm="12">
                          <b-form-group
                            label-cols="2"
                            :label="$t('petarencana.meta.label')"
                            label-for="petarencana-opt"
                          >
                            <m-select
                              id="petarencana-opt" v-model="bidurSelected" :options="optionsBidur" :multiple="false"
                              :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                              :placeholder="$t('petarencana.form.field.peta_rencana.label')" label="text" track-by="value"
                              :searchable="true">
                            </m-select>
                          </b-form-group>
                        </b-col>
                      </b-row>
                      <b-row class="mb-2">
                        <b-col lg="12">
                          <b-card>
                            <loading-skeleton
                              :loading="loading"
                              :totalRow="4"
                              type='skeleton-form-horizontal'
                            ></loading-skeleton>
                            <div v-show="!loading">
                              <b-form-group
                                label-cols="2"
                                label="Tujuan"
                                label-for="tujuan"
                              >
                                <b-form-input
                                  id="tujuan"
                                  v-model="model.tujuan"
                                  autofocus
                                  disabled
                                />
                              </b-form-group>
                              <b-form-group
                                label-cols="2"
                                label="Sasaran"
                                label-for="sasaran"
                              >
                                <b-form-input
                                  id="sasaran"
                                  v-model="model.sasaran"
                                  autofocus
                                  disabled
                                />
                              </b-form-group>
                              <b-form-group
                                label-cols="2"
                                label="Indikator Sasaran"
                                label-for="indikator_sasaran"
                              >
                                <b-table
                                  id="table-indikator"
                                  :small="true"
                                  :fixed="true"
                                  :items="model.indikator_sasaran.items"
                                  :fields="model.indikator_sasaran.fields"
                                  :bordered="true"
                                  responsive="sm"
                                >
                                <template #thead-top="data">
                                    <b-tr>
                                      <b-th></b-th>
                                      <b-th class="text-center" colspan="2">Tahun</b-th>
                                      <b-th class="text-center" colspan="6">Target</b-th>
                                    </b-tr>
                                  </template>
                                </b-table>
                              </b-form-group>
                              <b-form-group
                                label-cols="2"
                                :label="$t('petarencana.form.field.program.label')"
                                label-for="inisiatif_strategi"
                              >
                                <b-row>
                                  <b-col sm="10">
                                    <ValidationProvider
                                      rules="required"
                                      v-slot="{ errors, ariaMsg }"
                                      name="Inisiatif Strategi"
                                      :debounce="250"
                                    >
                                      <m-select
                                        :disabled="isDisabled"
                                        id="inisiatif_strategi" 
                                        v-model="programSelected"
                                        :options="optionsProgram" :multiple="false"
                                        :close-on-select="true" :preserve-search="true" :preselect-first="true"
                                        :placeholder="$t('petarencana.form.field.program.placeholder')" label="nomenklatur_urusan" track-by="kode_nomenklatur"
                                        :searchable="true">
                                      </m-select>
                                      <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
                                        {{ errors[0] }}
                                      </small>
                                    </ValidationProvider>
                                  </b-col>
                                  <b-col sm="2" v-if="bidurSelected">
                                    <b-button v-if="isDisabled" type="submit" size="sm">Ubah</b-button>
                                    <b-button v-else type="submit" size="sm" variant="primary">
                                      <i class="fal fa-save"></i>
                                      Simpan
                                    </b-button>
                                  </b-col>
                                </b-row>
                              </b-form-group>
                            </div>
                          </b-card>
                        </b-col>
                      </b-row>
                     </form>
                    </ValidationObserver>							
                    <peta-rencana-nav @add="addInisiatif" v-if="form.id" :opd="opd_id"></peta-rencana-nav>
                  </div>
                </div>
                <div class="tab-pane fade" id="tab_justified-2" role="tabpanel">
                  <referensi-inisiatif :opd="model.opd"></referensi-inisiatif>
                </div>
            </div>
        </div>
      </section>
    </div>
  </div>
</template>

<script>

import ReferensiInisiatif from "./_part/ReferensiInisiatif";
import PetaRencanaNav from "./_part/PetaRencanaNav";
import InisiatifForm from "./_part/InisiatifForm.vue"

export default {
  name: 'PetaRencana',
  components: {
    ReferensiInisiatif, PetaRencanaNav, InisiatifForm
  },
  data() {
    return {
      resourceName: 'peta-rencana',
      show: true,
      title: '',
      opd_id: this.$app.user.opd_id,
      model:{
        opd: null,
        tujuan: null,
        sasaran: null,
        indikator_sasaran: {
          fields: ['indikator','target_awal', 'target_akhir', 'target_baseline', 'target_2022', 'target_2023', 'target_2024', 'target_2025', 'target_2026'],
          items: []
        },
        inisiatif_strategi: null,
        tujuan_id: null,
        sasaran_id: null
      },
      optionsBidur: [],
      optionsProgram: [],
      optionsPerangkatDaerah:[],
      form: {
        id: null,
        bidur_kode: '',
        program: ''
      },
      bidurSelected: null,
      programSelected: null,
      loading: false,
      isFormOpen: false,
      isEdit: true,
      domain: ''
    }
  },
  watch: {
		'model.opd':{
			handler: function(data){
        if (data) {
          let params = Object.entries({opd_id: data.opd_id,})
            .map(([key, val]) => `${key}=${val}`).join('&');
            
          window.history.pushState({}, '','?'+params)
          this.opd_id = data.opd_id

          this.loadBidur().then(() => {
            this.resetProgramRoadmap()
          })
        }
      }
    },
    'bidurSelected' : {
      handler: function(data){
        if (data) {
          this.form.bidur_kode = data.value
          this.resDataRPD()
          this.loadProgramRoadmap().then(() => {
            this.loadProgram()
          })
        } else {
          this.optionsProgram = []
          this.programSelected = null
          this.form = {
            id: null,
            bidur_kode: '',
            program: ''
          }
        }
      }
    },
    'programSelected' : {
      handler: function(data){
        if (data) {
          this.form.program = data.kode_nomenklatur
        }
      }
    }
	},
  computed: {
    isDisabled() {
      return !this.isEdit || !this.bidurSelected
    }
  },
  mounted() {
    let query_opd = this.$route.query.opd_id
    if (query_opd) {
      this.opd_id = query_opd
    }
    this.resPerangkatDaerah().then(() => {
      if (this.opd_id) {
        this.model.opd = this.opd_id ? this.optionsPerangkatDaerah.find(val => val.opd_id === this.opd_id) : null
      }
    })
  },
  methods: {
    resetProgramRoadmap() {
      this.model.tujuan  = null
      this.model.sasaran  = null
      this.model.indikator_sasaran = {
        fields: ['indikator','awal', 'akhir', 'baseline', '2022', '2023', '2024', '2025', '2026'],
        items: []
      },
      this.model.inisiatif_strategi = null,
      this.model.tujuan_id = null,
      this.model.sasaran_id = null
      
      this.optionsProgram = []
      this.form = {
        id: null,
        bidur_kode: '',
        program: ''
      }
      this.bidurSelected = null
    },
    addInisiatif(val) {
      this.domain = val
      this.isFormOpen = true
    },
    async resPerangkatDaerah(){
        return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {})).then(res => {
          this.optionsPerangkatDaerah = res.data 
        })
    },
    async loadProgramRoadmap(){
        return this.$http.get(this.$app.route('program-roadmap.program-by-bidur', {
          bidur_kode: this.form.bidur_kode,
          opd_id: this.opd_id
        })).then(res => {
          if (res.data) {
            this.form.id= res.data.id
            this.form.program= res.data.program
            this.isEdit = false
          } else {
            this.isEdit = true
          }
        })
    },
    async loadBidur(){
        return this.$http.get(this.$app.route('peta-rencana.bidur-opd', {opd_id : this.opd_id})).then(res => { 
          this.optionsBidur = res.data.data.map((val) => {
            return {
              text: `${val.bidur_nama} (${val.bidur_kode})`,
              value: val.bidur_kode
            }
          })
        })
    },
    async resDataRPD(){
      return this.$http.get(this.$app.route('peta-rencana.get-data-rpd', 
      {
        opd_id : this.opd_id,
        bidur_kode: this.form.bidur_kode
      })).then(res => { 
        let data = res.data
        if (data.length) {
          this.model.tujuan = data[0].tujuan
          this.model.sasaran = data[0].sasaran
          this.model.tujuan_id = data[0].tujuan_id
          this.model.sasaran_id = data[0].sasaran_id
          this.model.indikator_sasaran.items = data.map(val => {
            return {
              indikator : val.indikator_sasaran,
              awal: val.kondisi_2022,
              akhir: val.target_2026,
              baseline: val.kondisi_2022,
              '2022': val.kondisi_2022,
              '2023': val.target_2023,
              '2024': val.target_2024,
              '2025': val.target_2025,
              '2026': val.target_2026
            }
          })
        }
      }).catch(error=>{ console.log('error', error) })
    },
    async loadProgram(){
      const res = await this.$http.get(this.$app.route('ref-kemendagri.ref-program', {bidur_kode: this.form.bidur_kode}))
      this.optionsProgram = res.data
      this.programSelected = this.form.program ? this.optionsProgram.find(val => val.kode_nomenklatur === this.form.program) : null
    },
    onSubmit() {
      if (!this.isEdit) {
        this.isEdit = !this.isEdit
        return
      }

      let vm 			= this	
			let url 		= vm.$app.route('program-roadmap.save')
			let frm 		= new FormData()
      let form = {
        id: vm.form.id ? vm.form.id : null,
        tujuan_id : vm.model.tujuan_id,
        sasaran_id : vm.model.sasaran_id,
        program : vm.form.program,
        bidur_kode : vm.form.bidur_kode,
        opd_id: vm.opd_id
      }
			let formData 	= vm.$app.objectToFormData(form, frm)
			
      let method = 'post'
			vm.$app.confirm({
				text: 'Apakah anda yakin untuk menyimpan inisiatif strategi peta rencana?',
				preConfirm: () => {
					return vm.$http
						[method](url, formData)
						.then(response => {
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
					if (result.value.data.status == "success")
					{
            vm.$app.alert.fire('Sukses', 'Data Berhasil Disimpan' , 'success');
            this.loadProgramRoadmap().then(() => {
              this.loadProgram()
            })
					}
				})
		},
  }
}
</script>
<style>
  .card-body {
    padding: 0.5rem;
  }

  thead th {
    text-align: center;
  }

  #table-indikator tbody>tr>td:not(:first-child) {
    text-align: center;
  }
</style>