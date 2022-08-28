<template>
	<div>
    <b-row>
      <b-col sm="11"><h2>{{ $t('petarencana.form.title.add') }} ({{ bidur }})</h2></b-col>
      <b-col>
        <b-btn size="sm" variant="secondary" @click="$emit('back')">Kembali</b-btn>
      </b-col>
    </b-row>
    
    <ValidationObserver v-slot="{ passes }" :slim="true">
    <form @submit.prevent="passes(onSubmit)" class="mt-4">
      <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="domain-arsitektur"
          :label="$t('petarencana.form.field.domain_arsitektur.label')">
          <b-col sm="8">
              <ValidationProvider
                  rules="required"
                  v-slot="{ valid, errors }"
                  name="Domain Peta Rencana"
                  :debounce="250">
                  <b-form-input
                      v-model="domain"
                      id="domain-arsitektur" 
                      :state="errors[0] ? false : (valid ? true : null)"
                      disabled>
                  </b-form-input>
                  <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
          </b-col>
        </b-form-group>
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="kegiatan"
          :label="$t('petarencana.form.field.kegiatan.label')">
          <b-col sm="8">
            <validation-provider name="Kegiatan" rules="required" v-slot="{ errors, ariaMsg }">
              <m-select
                id="kegiatan"
                :option-height="73"
                :tabindex="7"
                :options="optionsKegiatan"
                v-model="model.kegiatan_selected"
                :custom-label="customKegiatan"
                :placeholder="$t('petarencana.form.field.kegiatan.placeholder')"
                track-by="kode_nomenklatur"
                :searchable="true"			
                :allow-empty="false"
              >     
                <template #noOptions>
                  Tidak ada data
                </template>
                <template #noResult>
                  Data tidak ditemukan
                </template>
              </m-select>
              <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
                {{ errors[0] }}
              </small>
            </validation-provider>
          </b-col>
        </b-form-group>
        <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="sub_kegiatan"
            :label="$t('petarencana.form.field.sub_kegiatan.label')">
            <b-col sm="8">
              <validation-provider name="Sub Kegiatan" rules="required" v-slot="{ errors, ariaMsg }">
                <m-select
                  id="sub_kegiatan"
                  :option-height="73"
                  :tabindex="7"
                  :options="optionsSubKegiatan"
                  v-model="model.sub_kegiatan_selected"
                  :custom-label="customSubKegiatan"
                  :placeholder="$t('petarencana.form.field.sub_kegiatan.placeholder')"
                  track-by="kode_nomenklatur"
                  :searchable="true"			
                  :allow-empty="false"
                >     
                  <template #noOptions>
                    Tidak ada data
                  </template>
                  <template #noResult>
                    Data tidak ditemukan
                  </template>
                </m-select>
                <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
                  {{ errors[0] }}
                </small>
              </validation-provider>
            </b-col>
        </b-form-group>
        <h4>Tambah Inisiatif</h4>
        <b-card>
		      <b-card-body>
            <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="nama-inisiatif"
            :label="$t('petarencana.form.field.nama_inisiatif.label')"
          >
            <b-col sm="5">
              <ValidationProvider
                rules="required"
                v-slot="{ valid, errors }"
                name="Nama Inisiatif"
                :debounce="250">
                <b-form-input
                  v-model="form.nama_inisiatif"
                  id="nama-inisiatif" 
                  :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-input>
                <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-col>
          </b-form-group>
          <!-- <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="unit-pj"
            :label="$t('petarencana.form.field.unit_pj.label')"
          >
            <b-col sm="5">
              <ValidationProvider
                rules="required"
                v-slot="{ valid, errors }"
                name="Unit Penanggung Jawab"
                :debounce="250">
                <b-form-input
                  v-model="form.unit_pj"
                  id="unit-pj" 
                  :state="errors[0] ? false : (valid ? true : null)"
                >
                </b-form-input>
                <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-col>
          </b-form-group> -->
          <b-form-group
            :label="$t('petarencana.form.field.tahun_implementasi.label')"
            label-cols="2"
            label-cols-lg="2"
          >
            <b-col sm="12">
              <ValidationProvider
                rules="required"
                v-slot="{ errors }"
                name="Unit Penanggung Jawab"
                :debounce="250"
              >
                <b-form-checkbox
                  v-for="option in optionsYear"
                  v-model="form.arr_tahun_implementasi"
                  :key="option"
                  :value="option"
                  inline
                >
                  {{ option }}
                </b-form-checkbox>
                <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-col>
          </b-form-group>
          <!-- <b-form-group
            v-if="parentForm && parentForm.domain_arsitektur"
            label-cols="2"
            label-cols-lg="2"
            label-for="kegiatan"
            :label="$t('petarencana.form.field.aplikasi.label')">
            <b-col sm="8">
              <validation-provider name="Aplikasi" rules="" v-slot="{ errors, ariaMsg }">
                <m-select
                  id="aplikasi"
                  :option-height="73"
                  :tabindex="7"
                  :options="optionsAplikasi"
                  v-model="model.aplikasi_selected"
                  label="nama_apl"
                  :placeholder="$t('petarencana.form.field.aplikasi.placeholder')"
                  track-by="apl_Id"
                  :searchable="true"			
                  :allow-empty="false"
                >     
                  <template #noOptions>
                    Tidak ada data
                  </template>
                  <template #noResult>
                    Data tidak ditemukan
                  </template>
                </m-select>
                <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
                  {{ errors[0] }}
                </small>
              </validation-provider>
            </b-col>
          </b-form-group> -->
          <div class="text-left">
            <b-button type="submit" size="sm" variant="primary">
              <i class="fal fa-save"></i>
              {{ $t('general.form.button_add') }}
            </b-button>
          </div>
        </b-card-body>
      </b-card>
      <inisiatif-list :opd_id="form.opd_id" :program="program" :domain="domain"></inisiatif-list>
      </form>
    </ValidationObserver>
  </div>
</template>

<script>

import InisiatifDetailForm from "./InisiatifDetailForm.vue"
import InisiatifList from "./InisiatifList.vue"


export default {
	name: 'InisiatifForm',
	props: {
		domain: {
			type: String,
			required: true
		},
    bidur: {
			type: String
		},
    program: {
      type: String,
      required: true
    },
    program_id: {
      type: Number,
      required: true
    }
	},
  components: {
    InisiatifDetailForm, InisiatifList
  },
	data() {
		return {
      resourceName: 'inisiatif-list',
			form: {
				id: null,
        domain: this.domain,
        program: this.program_id,
				kegiatan: null,
        sub_kegiatan: null,
        nama_inisiatif: null,
        arr_tahun_implementasi: [],
        tahun_implementasi: '',
        tahun_awal: '',
        tahun_akhir: '',
        opd_id: '',
        unit_pj: ''
			},
      model: {
        kegiatan_selected: null,
        sub_kegiatan_selected: null
      },
      optionsKegiatan: [],
      optionsSubKegiatan: [],
      optionsYear: ['2022', '2023', '2024', '2025', '2026'],
      optionsApps:  []
		}
	},
  watch: {
		'model.kegiatan_selected' : {
      handler: function(data){
        if (data) {
          this.form.kegiatan = data.kode_nomenklatur
          this.loadSubKegiatan()
        }
      }
    },
    'model.sub_kegiatan_selected' : {
      handler: function(data){
        if (data) {
          this.form.sub_kegiatan = data.kode_nomenklatur
        }
      }
    }
	},
	mounted() {
    let query_opd = this.$route.query.opd_id ? this.$route.query.opd_id : this.$app.user.opd_id
    if (query_opd) {
      this.form.opd_id = query_opd
    }
    this.loadKegiatan()
  },
	methods: {
    refreshTable() {
      this.$root.$emit('bv::refresh::table', this.resourceName)
    },
    async loadApps(){
        return this.$http.get(this.$app.route('ref-kemendagri.ref-kegiatan', {})).then(res => {
          this.optionsApps = res.data 
        })
    },
    async loadKegiatan(){
        return this.$http.get(this.$app.route('ref-kemendagri.ref-kegiatan', {program: this.program})).then(res => {
          this.optionsKegiatan = res.data 
        })
    },
    async loadSubKegiatan(){
        return this.$http.get(this.$app.route('ref-kemendagri.ref-sub-kegiatan', {kegiatan: this.form.kegiatan})).then(res => {
          this.optionsSubKegiatan = res.data 
        })
    },
    customKegiatan ({ kode_nomenklatur, nomenklatur_urusan }) {
      return `${kode_nomenklatur} – ${nomenklatur_urusan}`
    },
    customSubKegiatan ({ kode_nomenklatur, nomenklatur_urusan }) {
      return `${kode_nomenklatur} – ${nomenklatur_urusan}`
    },
    setDataYear() {
      this.form.tahun_implementasi = this.form.arr_tahun_implementasi.sort().join(',')
      this.form.tahun_awal = this.form.arr_tahun_implementasi.reduce((init, curr) => {
        return parseInt(curr) < parseInt(init) ? curr : init
      }, 2022);
      this.form.tahun_akhir = this.form.arr_tahun_implementasi.reduce((last, curr) => {
        return parseInt(curr) > parseInt(last)  ? curr : last
      }, 2026);
    },
    onSubmit(){
			let vm 			= this	
      let url 	=  '/peta-rencana/save'
      this.setDataYear()

			let frm 		= new FormData()
			let formData 	= vm.$app.objectToFormData(vm.form, frm)

			let method = 'post'
			vm.$http
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
      .then(result => {
        if (result.isDismissed) return
        if (result.data.status == "success")
        {
          vm.$app.alert.fire('Sukses', 'Data Berhasil Disimpan' , 'success');
          this.refreshTable()
          this.resetFormInisiatif()
        }
      })
		},
    resetFormInisiatif() {
      this.form.arr_tahun_implementasi = [],
      this.form.tahun_implementasi = ''
      this.form.tahun_akhir = ''
      this.form.tahun_awal = ''
      this.form.nama_inisiatif = ''
      this.form.unit_pj = ''
    }
	}
}
</script>
<style scoped>
.custom-checkbox {
  width: 50px;
}
</style>