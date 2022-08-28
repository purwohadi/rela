<template>
  <!-- begin form add -->
  <b-modal
    :id="mId"
    :ref="mId"
    :title="title"
    size=" "
    hide-footer
    no-close-on-backdrop
    no-close-on-esc
    @close="onCloseModal"
    @hide="onCloseModal"
  >
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)" v-if="show">
        <b-form-group
          label-for="tahun_bulan"
          :label="$t('batastmt.form.field.tahun_bulan.label')"
        >
          <input type="hidden" v-model="form.tahun_bulan">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            :name="$t('batastmt.form.field.tahun_bulan.label')"
            :debounce="250"
          >
            <bs-datepicker
              class="datepicker-input"
              v-model="selectedDateTahunBulan"
              :placeholder="$t('batastmt.form.field.tahun_bulan.placeholder')"
              label=""
              :settings="tahunBulanFormat"
              :state="errors[0] ? false : (valid ? true : null)"
              @onSelected="onSelectedTahunBulan"
            ></bs-datepicker>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>

        <b-form-group
          label-for="batas_tmt"
          :label="$t('batastmt.form.field.batas_tmt.label')"
        >
          <input type="hidden" v-model="form.batas_tmt">
          <ValidationProvider
            rules="required"
            v-slot="{ valid, errors }"
            :name="$t('batastmt.form.field.batas_tmt.label')"
            :debounce="250"
          >
            <bs-datepicker
              ref="dtpBatas"
              class="datepicker-input"
              v-model="selectedDateBatasTMT"
              :placeholder="$t('batastmt.form.field.batas_tmt.placeholder')"
              label=""
              :settings="batasTMTFormat"
              :state="errors[0] ? false : (valid ? true : null)"
              @onSelected="onSelectedBatasTMT"
            ></bs-datepicker>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
          </ValidationProvider>
        </b-form-group>

        <div class="text-right mt-4 pt-3" style="border-top: 1px solid #dcdcdc;">
          <b-button type="submit" variant="primary">
            {{ $t('general.form.button_add') }}
          </b-button>
          <b-button ref="closebtn" variant="default" @click="onCloseModal">
            {{ $t('general.form.button_cancel') }}
          </b-button>
        </div>
      </form>
    </validation-observer>
  </b-modal>
  <!-- end form add -->
</template>

<script>
export default {
    name: 'BatasTmtForm',
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
            require: false,
            default: () => {}
        },
        isEdit: {
            type: Boolean,
            required: false,
            default: false
        },
    },
    data() {
        return {
            show: true,
            form: {
                id: '',
                tahun_bulan: '',
                batas_tmt: ''
            },
            selectedDateTahunBulan: '',
            selectedDateBatasTMT: '',
            tahunBulanFormat: {
                format: "MM yyyy",
                minViewMode: "months",
                startView: "months",
                viewMode: "year",
            },
            batasTMTFormat: {
                format: "dd MM yyyy",
                startDate: '',
                endDate: '',
                maxViewMode: 0
            },
        }
    },
    watch: {
        'item': {
            deep: true,
            immediate: true,
            handler: function(data) {
                this.form.id = data.id
                this.form.tahun_bulan = this.$moment(data.tahun +"-"+ data.bulan).format('YYYYMM')
                this.form.batas_tmt = this.$moment(data.batas_tmt).format('YYYY-MM-DD HH:mm:ss')
                this.selectedDateTahunBulan = this.$moment(data.tahun +"-"+ data.bulan).format('MMMM yyyy')
                this.selectedDateBatasTMT = this.$moment(data.batas_tmt).format('DD MMMM yyyy')
            }
        }
    },
    mounted() {
        this.resetForm()
    },
    methods: {
        resetForm() {
            this.form = {
                tahun_bulan: '',
                batas_tmt: '',
            },
            this.selectedDateTahunBulan = ''
            this.selectedDateBatasTMT = ''
        },
        onCloseModal() {
            this.resetForm()
            this.$bvModal.hide(this.mId)
        },
        onSelectedTahunBulan(date) {
            this.form.tahun_bulan = this.$moment(date.date).format('YYYYMM');
            this.batasTMTFormat.startDate = moment(date.date).startOf('month').format('DD MMMM YYYY')
            this.batasTMTFormat.endDate = moment(date.date).endOf('month').format('DD MMMM YYYY');
        },
        onSelectedBatasTMT(date) {
            this.form.batas_tmt = this.$moment(date.date).format('YYYY-MM-DD HH:mm:ss');
        },
        submit() {
            let vm = this
            let mode = vm.isEdit ? 'edit' : 'add'
            let formData = vm.$app.objectToFormData(vm.$data.form)
            if(vm.isEdit) {
                formData.append('_method', 'PUT')
            }
            let url = vm.$app.route(mode == 'add' ? 'batas-tmt.store' : 'batas-tmt.update', {id:vm.item.id})
            vm.$app.confirm({
                text: vm.$t(`batastmt.alert.confirm.${mode}`),
                preConfirm: () => {
                return vm.$http.post(url, formData)
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
                if (result.value.data.status == "success" || result.value.data.status == "info") {
                    vm.$app.success(
                        result.value.data.message,
                        result.value.data.status,
                        vm.$t(`arahan.alert.${result.value.data.status}`)
                    )
                    .then(response => {
                        if (response.value === true) {
                            vm.$root.$emit('bv::refresh::table', 'batastmttable')
                            vm.$bvModal.hide(vm.mId)
                        }
                    })
                }
            })
        }
    }
}
</script>

<style>
    #batas-tmt-form___BV_modal_header_ {
        border-bottom: 1px solid #e6e6e6;
    }

    #batas-tmt-form___BV_modal_body_ {
        background: #ececec;
        border-radius: 5px;
        margin: 10px;
    }
</style>
