<template>
  <!-- begin form add -->
  <b-modal
    :id="mIdNarasumber"
    :ref="mIdNarasumber"
    size="lg"
    :title="title"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc>
		
    <section id="modal-tambah-narasumber">	
      <validation-observer v-slot="{ passes }" :slim="true">
        <form @submit.prevent="passes(onSubmit)">
          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="target_tw"
            label="Kegiatan">
            <input type="hidden" v-model="model.kegiatan">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="kegiatan"
              :debounce="250">
              <b-form-input
                id="kegiatan"
                v-model="model.kegiatan"
                :state="errors[0] ? false : (valid ? true : null)">
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="judul"
            label="Judul Materi">
            <input type="hidden" v-model="model.target_tw">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="judul"
              :debounce="250">
              <b-form-input
                id="judul"
                v-model="model.judul"
                :state="errors[0] ? false : (valid ? true : null)">
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="lembaga"
            label="Lembaga Penyelenggara">
            <input type="hidden" v-model="model.lembaga">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="lembaga"
              :debounce="250">
              <b-form-input
                id="lembaga"
                v-model="model.lembaga"
                :state="errors[0] ? false : (valid ? true : null)">
              </b-form-input>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="tahun"
            label="Tahun">
            <bs-datepicker
              class="ml-1 ml-lg-1 mt-2"
              v-model="model.selectedYear"
              id="tahun"
              label=""
              placeholder="Tahun"
              :settings="dpSettings">
            </bs-datepicker>
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
	name: 'ModalTambahNarasumber',
	props: {
		mIdNarasumber: {
			type: String,
			required: true,
		},
		title: {
			type: String,
			required: false,
			default: ''
		},
		nrk: {
			type: String,
			required: false,
			default: ''
		},
	},
	data(){
		return{			
			resourceName: 'modal-tambah-narasumber',						
			show:false,	
			dpSettings: {
					format: "yyyy",
                    minViewMode: 'years'
				},
			model:{
				kegiatan: null,
				judul: null,
				lembaga: null,
				selectedYear: (this.$route.params.year) ? this.$route.params.year : this.$moment(this.$app.current_date).format('YYYY'),
				nrk: null,
			},
		}
	},
	watch:{
		nrk(n) {
			if (n) {
				this.model.nrk = n
			}
		},
    },	
	methods:{	
		onCloseModal() {
			this.model.kegiatan 	= null
			this.model.judul		= null
			this.model.lembaga		= null
			this.model.lembaga		= null
			this.model.selectedYear	= (this.$route.params.year) ? this.$route.params.year : this.$moment(this.$app.current_date).format('YYYY')
			this.$bvModal.hide(this.mIdNarasumber)
		},		
		async onSubmit() 
		{	
			let vm 			= this
			let url 		= vm.$app.route('profil.store-narsum')
			let frm 		= new FormData()
        	let formData 	= this.$app.objectToFormData(this.model, frm)
			
			let method ='post'
			vm.$app.confirm({
				text: vm.$t('general.alert.confirm.add'),
				preConfirm: () => {
				return vm.$http
					[method](url, formData)
					.then(response => {
						//console.log(response)
						if (response.data.status == "error") {
							throw new Error(response.data.message)
						} else {
							return response
						}
					})
					.catch(error => {
						//console.log('error 2');
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
						if (response.value === true) {
							//this.$router.go(-1)
							this.model.kegiatan 	= null
							this.model.judul		= null
							this.model.lembaga		= null
							this.model.lembaga		= null
							this.model.selectedYear	= (this.$route.params.year) ? this.$route.params.year : this.$moment(this.$app.current_date).format('YYYY')
							this.model.nrk			= null
							this.$root.$emit('bv::refresh::table', 'narasumbertable')
							vm.$bvModal.hide(vm.mIdNarasumber)
						}
					})
				}
			})
		},
	},	
}
</script>

<style lang="scss">
#modal-tambah-narasumber{
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
