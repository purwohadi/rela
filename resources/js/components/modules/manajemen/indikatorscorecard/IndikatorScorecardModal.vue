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
  >
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="jabatan"
          label="Jabatan"
        >
          <input type="hidden" v-model="model.jabatan">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Jabatan"
            :debounce="250"
          >
            <b-form-select
              :options="options_jabatan"
              id="jabatan"
              v-model="model.jabatan"
              :state="errors[0] ? false : (valid ? true : null)"
              autofocus
            >
            </b-form-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="sifat"
          label="Sifat"
        >
          <input type="hidden" v-model="model.sifat">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Sifat"
            :debounce="250"
          >
            <b-form-select
              :options="options_sifat"
              id="sifat"
              v-model="model.sifat"
              :state="errors[0] ? false : (valid ? true : null)"
              autofocus
            >
            </b-form-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="satuan"
          label="Satuan"
        >
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Satuan"
            :debounce="250"
          >
            <b-form-input
              id="satuan"
              v-model="model.satuan"
              :state="errors[0] ? false : (valid ? true : null)"
              placeholder="Input satuan"
              autofocus
            >
            </b-form-input>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="indikator"
          label="Indikator"
        >
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            name="Indikator"
            :debounce="250"
          >
            <b-form-textarea
              id="indikator"
              v-model="model.indikator"
              rows="3"
              max-rows="6"
              :state="errors[0] ? false : (valid ? true : null)"
              placeholder="Input indikator"
              autofocus
            ></b-form-textarea>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="bobot"
          label="Bobot"
        >
          <ValidationProvider
            rules="required|max_value:100"
            v-slot="{ valid, errors }"
            name="Bobot"
            :debounce="250"
          >
            <b-input-group append="%">
              <b-form-input
                id="bobot"
                v-model="model.bobot"
                @keypress="isNumber($event)"
                :maxlength="8"
                :state="errors[0] ? false : (valid ? true : null)"
                placeholder="Input bobot dalam persentase"
                autofocus
              >
              </b-form-input>
            </b-input-group>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="mulai_berlaku"
          label="Tahun Mulai"
        >
          <ValidationProvider
            rules="required|length:4"
            v-slot="{ valid, errors }"
            name="Tahun Mulai"
            :debounce="250"
          >
            <bs-datepicker
              id="mulai_berlaku"
              v-model="model.mulai_berlaku"
              :settings="settings.tahunBerlaku"
              @onSelected="onSelectedStartYear"
              class="mb-3 year-date"
              :state="errors[0] ? false : (valid ? true : null)"
              autofocus
              label=""
              :disabled-day-before="true"
            ></bs-datepicker>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>
        <b-form-group
          label-cols="2"
          label-cols-lg="2"
          label-for="akhir_berlaku"
          label="Tahun Berakhir"
        >
          <ValidationProvider
            v-slot="{ valid, errors }"
            name="Tahun Berakhir"
            :debounce="250"
          >
            <bs-datepicker
              id="akhir_berlaku"
              v-model="model.akhir_berlaku"
              :settings="settings.tahunBerakhir"
              @onSelected="onSelectedEndYear"
              class="mb-3 year-date"
              :state="errors[0] ? false : (valid ? true : null)"
              autofocus
            ></bs-datepicker>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>

        <div class="text-right mt-4">
          <b-button ref="closebtn" variant="default" @click="onCloseModal" class="mr-2">
            <i class="fal fa-times"></i>
            {{ $t('general.form.button_cancel') }}
          </b-button>
          <b-button type="submit" variant="primary">
            <i class="fal fa-save"></i>
            {{ $t('general.form.button_add') }}
          </b-button>
        </div>
      </form>
    </validation-observer>
  </b-modal>
</template>

<script>
import ImageUploader from '../../../bootstraps/base/ImageUploader.vue'

export default {
  name: 'TambahIndikatorScorecard',
  components: { ImageUploader },
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
    isEdit: {
      type: Boolean,
      required: false,
      default: false
    },
    item: {
      type: Object,
      require: false,
      default: () => {}
    }
  },
  data(){
    return{
      modelName: 'slug',
      resourceRoute: 'manajemen-indikator-scorecard',
      showForm: false,
      model:{
        jabatan: '',
        sifat: '',
        indikator: null,
        satuan: '',
        bobot: null,
        mulai_berlaku: this.$app.getYear(),
        akhir_berlaku: '',
        slug_path: null
      },
      options_jabatan: [
        { value: '', text: 'Pilih Jabatan' },
        { value: 'CAMAT', text: 'Camat' },
        { value: 'LURAH', text: 'Lurah' },
      ],
      options_sifat: [
        { value: '', text: 'Pilih Sifat' },
        { value: 'Wajib', text: 'Wajib' },
        { value: 'Pilihan', text: 'Pilihan' },
      ],
      tempYear: {
        mulai_berlaku: '',
        akhir_berlaku: ''
      },
      settings: {
        tahunBerlaku: {
          format: "yyyy",
          minViewMode: "years",
          startView: "years",
          viewMode: "years",
          orientation: "top auto",
        },
        tahunBerakhir: {
          format: "yyyy",
          minViewMode: "years",
          startView: "years",
          viewMode: "years",
          orientation: "top auto",
          startDate: new Date(),
        }
      }
    }
  },
  watch: {
    'item': {
      handler: function(n) {
        if (n && Object.keys(n).length) {
          this.model = {
            jabatan: n.e_jabatan,
            sifat: n.e_sifat,
            satuan: n.v_satuan,
            indikator: n.tx_indikator,
            bobot: n.f_bobot,
            mulai_berlaku: n.v_tahun_mulai || '',
            akhir_berlaku: n.v_tahun_akhir || '',
            slug_path: n.slug_path
          }
        }
      }
    },
    'model.mulai_berlaku': {
      handler: function(n) {
        if (n) {
          return this.settings.tahunBerakhir.startDate = n
        }
        return
      }
    }
  },
  methods:{
    onCloseModal() {
      this.$bvModal.hide(this.mId)
      this.model = {
        jabatan: '',
        sifat: '',
        satuan: '',
        indikator: '',
        bobot: '',
        mulai_berlaku: '',
        akhir_berlaku: '',
        slug_path: ''
      }
      this.tempYear =  {
        mulai_berlaku: '',
        akhir_berlaku: ''
      }
    },
    isNumber: function(evt) {
      evt = (evt) ? evt : window.event;
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        evt.preventDefault();;
      } else {
        return true;
      }
    },
    onSelectedStartYear(date) {
      this.tempYear.mulai_berlaku = this.$moment(date.date).format('YYYY')
      if (this.tempYear.mulai_berlaku) {
        this.model.mulai_berlaku = this.tempYear.mulai_berlaku
      }
    },
    onSelectedEndYear(date) {
      this.tempYear.akhir_berlaku = this.$moment(date.date).format('YYYY')
      if (this.tempYear.akhir_berlaku) {
        this.model.akhir_berlaku = this.tempYear.akhir_berlaku
      }
    },
    async submit(){
      //Check date
      if (((new Date(this.model.mulai_berlaku).getTime()/1000) > (new Date(this.model.akhir_berlaku).getTime()/1000))) {
        this.$app.alert.fire("Proses Gagal", "Tahun mulai tidak boleh lebih besar dari tahun berakhir", "warning")
        return
      }

      this.model.username = this.$app.user.v_userid
      let action = this.isEdit
        ? this.$app.route(`${this.resourceRoute}.update`, {
            [this.modelName]: this.model.slug_path
          })
        : this.$app.route(`${this.resourceRoute}.store`)

      let frm = new FormData()
      if (this.isEdit) {
        frm.append('_method', 'PATCH')
      }

      let formData = this.$app.objectToFormData(this.model, frm)
      let msgEdit = 'Apakah anda yakin untuk mengubah data'
      let msgAdd = 'Apakah anda yakin untuk menambah data'
      this.$app.confirm({
      text: this.isEdit ? msgEdit : msgAdd,
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
          )
            .then(response => {
              console.log('response', response)
              if (response.value === true) {
                this.$root.$emit('bv::refresh::table', 'indikator_scorecard_table')
                this.onCloseModal()
              }
            })
        }
      })
    }
  }
}
</script>

<style lang="scss">
  .image-preview {
    border-radius: .35rem;
    margin: .7rem 0;
    width: 200px;
    height: auto;
    transition: ease-in-out 0.3s;
    img {
      border-radius: .35rem;
      width: 350px;
      height: auto;
      &.image-cover {
        object-fit: cover;
        object-position: right top;
      }
    }
  }
  .invalid-feedback {
    display: block;
  }

  .year-date {
    label {
      margin-right: 0 !important;
    }
  }
</style>
