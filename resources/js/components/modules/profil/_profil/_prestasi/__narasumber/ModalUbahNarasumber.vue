<template>
  <!-- begin form add -->
  <b-modal
    :id="mIdUbahNarasumber"
    :ref="mIdUbahNarasumber"
    size="lg"
    :title="title"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc>
		
    <section id="modal-ubah-narasumber">	
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
	name: 'ModalUbahNarasumber',
	props: {
		mIdUbahNarasumber: {
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
			resourceName: 'modal-ubah-narasumber',						
			show:false,	
			required: null,
			dpSettings: {
						format: "yyyy",
						minViewMode: 'years'
					},
			model:{
				id: null,
				kegiatan: null,
				judul: null,
				lembaga: null,
				nrk: null,
				selectedYear: '',
			},
		}
	},
	watch:{
		item(n) {
			if (n) 
			{
				this.model.nrk 			= this.nrk
				this.model.id 			= n.id				
				this.model.kegiatan 	= n.v_kegiatan				
				this.model.judul 		= n.v_judul				
				this.model.lembaga 		= n.v_lembaga								
				this.model.selectedYear = n.v_tahun
			}
		},
    },	
	methods:{	
		onCloseModal() {
			this.model.kegiatan 	= null
			this.model.judul		= null
			this.model.lembaga		= null
			this.model.nrk			= null
			this.model.selectedYear	= ''
			this.$bvModal.hide(this.mIdUbahNarasumber)
		},
		async onSubmit() 
		{	
			let vm 			= this
			let url 		= vm.$app.route('profil.update-narsum')
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
					this.$app.success(
					result.value.data.message,
					result.value.data.status,
					)
					.then(response => {
						if (response.value === true) 
						{
							this.model.kegiatan 	= null
							this.model.judul		= null
							this.model.lembaga		= null
							this.model.nrk			= null
							this.model.selectedYear	= ''
							this.$root.$emit('bv::refresh::table', 'narasumbertable')
							this.$bvModal.hide(this.mIdUbahNarasumber)
						}
					})
				}
			})
		},
	},	
}
</script>

<style lang="scss">
#modal-ubah-narasumber{
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
