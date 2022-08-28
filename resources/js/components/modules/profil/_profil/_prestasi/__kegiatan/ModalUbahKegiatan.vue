<template>
  <!-- begin form add -->
  <b-modal
    :id="mIdUbahKegiatan"
    :ref="mIdUbahKegiatan"
    size="lg"
    :title="title"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc>

    <section id="modal-ubah-kegiatan">
      <validation-observer v-slot="{ passes }" :slim="true">
        <form @submit.prevent="passes(onSubmit)">
          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="tahun"
            label="Tahun">
            <bs-datepicker
              v-model="model.selectedYear"
              id="tahun"
              label=""
              placeholder="Tahun"
              :settings="dpSettings"
              @onSelected="onSelected">
            </bs-datepicker>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="kegiatan"
            label="Kegiatan">
            <input type="hidden" v-model="model.kegiatan">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="Kegiatan"
              :debounce="250">
              <b-form-input
                id="kegiatan"
                maxlength="100"
                v-model="model.kegiatan"
                :state="errors[0] ? false : (valid ? true : null)">
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="anggaran"
            label="Anggaran">
            <input type="hidden" v-model="model.anggaran">
            <ValidationProvider
              rules="required|decimal"
              v-slot="{ valid, errors }"
              name="anggaran"
              :debounce="250">
              <b-form-input
                id="anggaran"
                maxlength="8"
                v-model="model.anggaran"
                :state="errors[0] ? false : (valid ? true : null)">
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="peran"
            label="Peran">
            <input type="hidden" v-model="model.peran">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="peran"
              :debounce="250">
              <b-form-input
                id="peran"
                maxlength="100"
                v-model="model.peran"
                :state="errors[0] ? false : (valid ? true : null)">
              </b-form-input>
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
    </section>
  </b-modal>
</template>

<script>


export default {
	name: 'ModalUbahKegiatan',
	props: {
		mIdUbahKegiatan: {
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
		nrk: {
			type: String,
			required: false,
			default: ''
		},
	},
	data(){
		return{
			resourceName: 'modal-ubah-kegiatan',
			dpSettings: {
					format: "yyyy",
                    minViewMode: 'years'
				},
			model:{
				kegiatan: null,
				anggaran: '',
				peran: null,
				nrk: null,
				id: null,
				selectedYear: '',
			},
		}
	},
	watch:{
		item(n) {
			if (n) {
				this.model.nrk 			= this.nrk
				this.model.id 			= n.id
				this.model.kegiatan		= n.v_nama_kegiatan
				this.model.anggaran		= n.v_jumlah_angg
				this.model.peran 		= n.v_peran
				this.model.selectedYear = n.v_tahun_angg
			}
		},
    },
	methods:{
		onCloseModal() {
			this.model.kegiatan 	= null
			this.model.anggaran		= null
			this.model.peran		= null
			this.model.nrk			= null
			this.model.selectedYear = ''
			this.$bvModal.hide(this.mIdUbahKegiatan)
		},
		onSelected(date) {
			this.model.selectedYear = this.$moment(date.date).format('YYYY')
			//this.loadProvider(this.model.selectedYear)
		},
		async onSubmit()
		{
			let vm 			= this
			let url 		= vm.$app.route('profil.update-kegiatan-strategis')
			let frm 		= new FormData()
        	let formData 	= this.$app.objectToFormData(this.model, frm)

			let method ='post'
			vm.$app.confirm({
				text: vm.$t('general.alert.confirm.edit'),
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
				if (result.value.data.status == "success" || result.value.data.status == "info")
				{
					vm.$app.success(
					result.value.data.message,
					result.value.data.status,
					)
					.then(response => {
						if (response.value === true)
						{
							this.model.jenjang_pendidikan 	= null
							this.model.prestasi_diperoleh	= null
							this.model.nrk					= null
							this.model.selectedYear 		= ''
							this.$root.$emit('bv::refresh::table', 'kegiatantable')
							vm.$bvModal.hide(vm.mIdUbahKegiatan)
						}
					})
				}
			})
		},
	},
}
</script>

<style lang="scss">
#modal-ubah-kegiatan{
	.btn-filter{
		position: absolute;
		margin-left: 5px;
	}
	.width-td{
		min-width: 350px;
	}
}

.custom-input-width {
	min-width: 70px;
}
</style>
