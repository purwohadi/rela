<template>
  <!-- begin form add -->
  <b-modal
    :id="mIdKegiatan"
    :ref="mIdKegiatan" 
    size="lg"
    :title="title"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc>
		
    <section id="modal-tambah-kegiatan">	
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
	name: 'ModalTambahKegiatan',
	props: {
		mIdKegiatan: {
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
			resourceName: 'modal-tambah-kegiatan',						
			show:false,	
			dpSettings: {
					format: "yyyy",
                    minViewMode: 'years'
				},
			model:{
				selectedYear: (this.$route.params.year) ? this.$route.params.year : this.$moment(this.$app.current_date).format('YYYY'),
				kegiatan: null,
				anggaran: null,
				peran: null,
				nrk: null,
			},
			option:[],
		}
	},
	watch:{
		nrk(n) {
			if (n) {
				this.model.nrk = n				
				this.loadProvider(this.model.selectedYear)
			}
		},
    },	
	methods:{			
		onChange(data) {
			console.log(data)
			this.show = false
			
		},
		onCloseModal() {
			this.model.kegiatan 	= null
			this.model.anggaran 	= null
			this.model.peran 		= null
			this.model.nrk 			= null
			this.model.selectedYear	= (this.$route.params.year) ? this.$route.params.year : this.$moment(this.$app.current_date).format('YYYY')
			this.$bvModal.hide(this.mIdNarasumber)
		},			
		async loadProvider(n) 
		{
			this.loading 	= true
			let promise 	= this.$http.get(this.$app.route('profil.jenis-kegiatan-get', {
								tahun: n
							}))
			return promise.then((data) => {				
				const items 	= data.data
				this.option 	= items
				this.loading 	= false
				return this.items
			}).catch(error => {
				this.loading 	= false
				return []
			})			
		},
		onSelected(date) {
			this.model.selectedYear = this.$moment(date.date).format('YYYY')
			//this.loadProvider(this.model.selectedYear)
		},	
		async onSubmit() 
		{	
			let vm 			= this
			let url 		= vm.$app.route('profil.store-kegiatan-strategis')
			let frm 		= new FormData()
        	let formData 	= this.$app.objectToFormData(this.model, frm)
			
			let method ='post'
			vm.$app.confirm({
				text: vm.$t('general.alert.confirm.add'),
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
						if (response.value === true) {
							//this.$router.go(-1)
							this.model.kegiatan 	= null
							this.model.anggaran 	= null
							this.model.peran 		= null
							this.model.nrk 			= null
							this.model.selectedYear	= (this.$route.params.year) ? this.$route.params.year : this.$moment(this.$app.current_date).format('YYYY')
							this.$root.$emit('bv::refresh::table', 'kegiatantable')
							vm.$bvModal.hide(vm.mIdKegiatan)
						}
					})
				}
			})
		},
	},	
}
</script>

<style lang="scss">
#modal-tambah-kegiatan{
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
