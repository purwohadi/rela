<template>
  <div>
    <b-card class="p-3">
      <h3 class="font-weight-bold">
        {{ isNew ? 'Tambah PD' : 'Ubah PD' }}
      </h3>
      <validation-observer v-slot="{ passes }" :slim="true">
        <form @submit.prevent="passes(submit)">
          <template>
            <b-form-group
              label-for="v_kode_skpd"
              label="Kode PD"
            >
              <input type="hidden" v-model="model.v_kode_skpd">
              <ValidationProvider
                rules="required|max:9"
                v-slot="{ valid, errors }"
                name="Kode PD"
                :debounce="250"
              >
                <b-form-input
                  id="v_kode_skpd"
                  v-model="model.v_kode_skpd"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                  :disabled="!isNew"
                >
                </b-form-input>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              label-for="v_nama_skpd"
              label="Nama PD"
            >
              <input type="hidden" v-model="model.v_nama_skpd">
              <ValidationProvider
                rules="required"
                v-slot="{ valid, errors }"
                name="Nama PD"
                :debounce="250"
              >
                <b-form-input
                  id="v_nama_skpd"
                  v-model="model.v_nama_skpd"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                >
                </b-form-input>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              label-for="v_unit_id"
              label="Unit ID"
            >
              <input type="hidden" v-model="model.v_unit_id">
              <ValidationProvider
                rules="required|max:8"
                v-slot="{ valid, errors }"
                name="Unit ID"
                :debounce="250"
              >
                <b-form-input
                  id="v_unit_id"
                  v-model="model.v_unit_id"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                >
                </b-form-input>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              label-for="e_bidang"
              label="Bidang Asisten"
            >
              <input type="hidden" v-model="model.e_bidang">
              <ValidationProvider
                v-slot="{ valid, errors }"
                name="Bidang Asisten"
                :debounce="250"
              >
                <b-form-select
                  :options="options"
                  id="e_bidang"
                  v-model="model.e_bidang"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                >
                </b-form-select>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              label-for="e_is_induk"
              label="Induk PD"
            >
              <input type="hidden" v-model="model.e_is_induk">
              <ValidationProvider
                rules="required"
                v-slot="{ valid, errors }"
                name="Induk PD"
                :debounce="250"
              >
                <b-form-checkbox
                  id="e_is_induk"
                  v-model="model.e_is_induk"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                  switch>
                </b-form-checkbox>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              label-for="v_tahun_awal"
              label="Tahun Awal"
            >
              <input type="hidden" v-model="model.v_tahun_awal">
              <ValidationProvider
                rules="required"
                v-slot="{ valid, errors }"
                name="Tahun Awal"
                :debounce="250"
              >
                <!-- <bs-datepicker
                  id="v_tahun_awal"
                  v-model="model.v_tahun_awal"
                  :settings="dpSettings"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                  label=""
                ></bs-datepicker> -->
                <b-form-input
                  type="number"
                  id="v_tahun_awal"
                  v-model="model.v_tahun_awal"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                >
                </b-form-input>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            <b-form-group
              label-for="v_tahun_akhir"
              label="Tahun Akhir"
            >
              <input type="hidden" v-model="model.v_tahun_akhir">
              <ValidationProvider
                v-slot="{ valid, errors }"
                name="Tahun Akhir"
                :debounce="250"
              >
                <!-- <bs-datepicker
                  id="v_tahun_akhir"
                  v-model="model.v_tahun_akhir"
                  :settings="dpSettings"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                  label=""
                ></bs-datepicker> -->
                <b-form-input
                  type="number"
                  id="v_tahun_akhir"
                  v-model="model.v_tahun_akhir"
                  :state="errors[0] ? false : (valid ? true : null)"
                  autofocus
                >
                </b-form-input>
                <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
              </ValidationProvider>
            </b-form-group>
          </template>
          <div class="text-right mt-4 pt-3">
            <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
              {{ $t('general.form.button_cancel') }}
            </b-button>
            <b-button type="submit" variant="primary">
              {{ $t('general.form.button_add') }}
            </b-button>
          </div>
        </form>
      </validation-observer>
    </b-card>
  </div>
</template>

<script>
  export default {
    name: 'SkpdForm',
    props: {
      id: null
    },
    data(){
      return{
        modelName: 'manajemen_skpd',
        model:{
          v_kode_skpd: '',
          v_nama_skpd: '',
          v_unit_id: '',
          e_bidang: '',
          e_is_induk: false,
          v_tahun_awal: '',
          v_tahun_akhir: '',
          v_created_by: null,
          v_updated_by: null,
        },
        options: [
          { value: '', text: 'Pilih Bidang Asisten' },
          { value: '1', text: 'Pemerintahan' },
          { value: '2', text: 'Perekonomian' },
          { value: '3', text: 'Keuangan' },
          { value: '4', text: 'Pembangunan dan Lingkungan Hidup' },
          { value: '5', text: 'Kesejahteraan Rakyat' },
        ],
        dpSettings: {
          format: "yyyy",
          minViewMode: "months",
          startView: "months",
          viewMode: "year",
        },
      }
    },
    computed: {
      isNew() {
        return this.id === undefined || this.id === null
      }
    },
    created(){
      if(!this.isNew) {
        this.fetchData(this.id)
      }
    },
    methods:{
      async submit(){
        let craetedBy = this.$app.user.v_userid
        this.model.v_created_by = craetedBy
        this.model.v_updated_by = craetedBy

        let action = this.isNew
          ? this.$app.route('manajemen-skpd.store')
          : this.$app.route('manajemen-skpd.update',{
            [this.modelName]: this.model.kode_skpd
          })

        let formData = this.$app.objectToFormData(this.model)

        if (!this.isNew) {
          formData.append('_method', 'PUT')
        }

        let msgAdd = 'Apakah anda yakin untuk menambah data PD'
        let msgEdit = 'Apakah anda yakin untuk mengubah data PD'
        this.$app.confirm({
        text: this.isNew ? msgAdd : msgEdit,
        preConfirm: () => {
          return this.$http.post(action, formData)
            .then(response => {
              if (response.data.status == "error") {
                let errors = response.data.message
                throw new Error(response.data.message)
              } else {
                return response
              }
            })
            .catch(error => {
              this.$app.alert.showValidationMessage(error)
            })
          }
        })
        .then(result => {
					if (result.isDismissed) return
					if (result.value.data.status == "success" || result.value.data.status == "info") {
						this.$app.success(
              result.value.data.message,
              result.value.data.status,
              // this.$t(`${this.routeName}.alert.${result.value.data.status}`)
            )
              .then(response => {
                if (response.value === true) {
                  this.$router.push({name: 'manajemen.skpd'})
                  this.$root.$emit('bv::refresh::table', 'skpdlisttable')
                }
              })
					}
				})

      },
      async fetchData(params) {
        // this.pending = true
        try {
          if (!this.isNew) {
            let { data } = await this.$http.get(
              this.$app.route('manajemen-skpd.show', {
                manajemen_skpd: params
              })
            )

            Object.keys(data).forEach(key => {
              if (key in this.model) {
                this.model[key] = data[key]
              }
            })
          }
        } catch (error) {
          this.$app.error(error)
        }

        // this.pending = false
      },
    }
  }
</script>

<style lang="scss" scoped>

</style>
