<template>
  <!-- begin form add -->
  <b-modal
    :id="mId"
    :ref="mId"
    :title="title"
    size="lg"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc
    @close="onCloseModal"
    @hide="onCloseModal"
  >
    <ValidationObserver v-slot="{ passes }" :slim="true">
    <form @submit.prevent="passes(onSubmit)" class="mt-4">
      <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="domain-arsitektur"
          :label="$t('petarencana.form.field.domain_arsitektur.label')">
          <b-col sm="10">
              <ValidationProvider
                  rules="required"
                  v-slot="{ valid, errors }"
                  name="Domain Peta Rencana"
                  :debounce="250">
                  <b-form-input
                      v-model="form.domain"
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
          <b-col sm="10">
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
            <b-col sm="10">
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
        <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="nama-inisiatif"
            :label="$t('petarencana.form.field.nama_inisiatif.label')"
        >
        <b-col sm="10">
            <ValidationProvider
            rules="required"
            v-slot="{ errors }"
            name="Nama Inisiatif"
            :debounce="250">
            <b-form-input
                v-model="form.nama_inisiatif"
                id="nama-inisiatif" 
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
                v-model="item.unit_pj"
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
            v-slot="{ valid, errors }"
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
            <b-button type="submit" size="sm" variant="primary" :disabled="loading">
                <b-spinner v-if="loading" small></b-spinner>
                <i class="fal fa-save" v-else></i>
                {{ $t('general.form.button_add') }}
            </b-button>
            <b-button type="button" size="sm" @click="onCloseModal" variant="secondary">
                {{ $t('general.button.cancel') }}
            </b-button>
        </div>
      </form>
    </ValidationObserver>
  </b-modal>
  <!-- end form add -->
</template>

<script>
export default {
    name: 'InisiatifUpdate',
    props: {
        mId: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: false,
            default: ''
        },
        item: {
            type: Object,
            required: true,
            default: () => {}
        }
    },
    data() {
        return {
            resourceName: 'inisiatif-update',
			form: {
                id: null,
                domain: null,
                program: null,
                program_id: null,
                kegiatan: null,
                sub_kegiatan: null,
                nama_inisiatif: null,
                arr_tahun_implementasi: [],
                tahun_implementasi: '',
                tahun_awal: null,
                tahun_akhir: null,
                opd_id: null,
                unit_pj: null
            },
            model: {
                kegiatan_selected: null,
                sub_kegiatan_selected: null
            },
            optionsKegiatan: [],
            optionsSubKegiatan: [],
            optionsYear: ['2022', '2023', '2024', '2025', '2026'],
            optionsApps:  [],
            loading: false
        }
    },
    watch : {
        'item':{
			handler: function(data){
				if (data) {
                    this.form = {...this.form, ...data}
                    this.form.arr_tahun_implementasi = data.tahun_implementasi.split(',')
                    this.loadKegiatan()
				}
			},
		},
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
        },
        'optionsKegiatan':{
			handler: function(data){
				if (data) {
					this.model.sub_kegiatan_selected = null
					this.model.kegiatan_selected = this.form.kegiatan ? data.find(val => val.kode_nomenklatur === this.form.kegiatan) : null
				}
			},
		},
        'optionsSubKegiatan':{
			handler: function(data){
				if (data) {
					this.model.sub_kegiatan_selected = this.form.sub_kegiatan ? data.find(val => val.kode_nomenklatur === this.form.sub_kegiatan) : null
				}
			},
		},
    },
    mounted() {
    },
    methods: {
        onCloseModal() {
            this.$bvModal.hide(this.mId)
            this.form = {...this.form, ...this.item}
            this.form.arr_tahun_implementasi = this.item.tahun_implementasi.split(',')
            this.loadKegiatan()
            this.loading = false
        },
        refreshTable() {
          this.$root.$emit('bv::refresh::table', 'inisiatif-list')
        },
        async loadKegiatan(){
            return this.$http.get(this.$app.route('ref-kemendagri.ref-kegiatan', {program: this.form.program})).then(res => {
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
            vm.loading = true
            let url 	=  '/peta-rencana/update'
            this.setDataYear()
            let form = {
                id: this.form.id,
                domain: this.form.domain,
                program: this.form.program_id,
                kegiatan: this.form.kegiatan,
                sub_kegiatan: this.form.sub_kegiatan,
                nama_inisiatif: this.form.nama_inisiatif,
                tahun_implementasi: this.form.tahun_implementasi,
                tahun_awal: this.form.tahun_awal,
                tahun_akhir: this.form.tahun_akhir,
                opd_id: this.form.opd_id,
                unit_pj: this.form.unit_pj
            }
            let frm 		= new FormData()
            let formData 	= vm.$app.objectToFormData(form, frm)

            let method = 'post'
            vm.$http
                [method](url, formData)
                .then(response => {
                    vm.loading = false
                    if (response.data.status == "error") {
                    throw new Error(response.data.message)
                    } else {
                        if (response.data.status == "success")
                        {
                            vm.$app.alert.fire('Sukses', 'Data Berhasil Disimpan' , 'success');
                            this.refreshTable()
                            this.onCloseModal()
                        }
                    return response
                    }
                })
                .catch(error => {
                    vm.loading = false
                    vm.$app.alert.showValidationMessage(error)
                })
        },
    }
}
</script>
<style scoped>
.custom-checkbox {
  width: 50px;
}
</style>