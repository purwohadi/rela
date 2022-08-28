<template>
  <!-- begin form add -->
  <b-modal
    :id="mIdPrestasiJabatan"
    :ref="mIdPrestasiJabatan"
    size="lg"
    :title="title"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc>
		
    <section id="modal-tambah-prestasi-jabatan">	
      <validation-observer v-slot="{ passes }" :slim="true">
        <form @submit.prevent="passes(onSubmit)">
          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="jabatan"
            label="Jabatan">
            <input type="hidden" v-model="model.jabatan">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="Jabatan"
              :debounce="250">
              <m-select
                :options="option"
                id="jabatan"
                label="label" 
                track-by="value"
                v-model="model.jabatan"
                :state="errors[0] ? false : (valid ? true : null)"
                autofocus
                :searchable="true">
              </m-select>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>
									
          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="tahun"
            label="Tahun">						
            <input type="hidden" v-model="model.selectedYear">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="Tahun"
              :debounce="250">
              <bs-datepicker
                v-model="model.selectedYear"
                id="tahun"
                label=""
                placeholder="Tahun"
                :settings="dpSettings"
                :state="errors[0] ? false : (valid ? true : null)"
                @onSelected="onSelected">
              </bs-datepicker>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="keberhasilan"
            label="Keberhasilan">
            <input type="hidden" v-model="model.keberhasilan">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="Keberhasilan"
              :debounce="250">
              <b-form-textarea
                class="cstm-disabled"
                id="keberhasilan"
                v-model="model.keberhasilan"
                :state="errors[0] ? false : (valid ? true : null)"
                debounce="250"
                rows="3"
                max-rows="5"
                no-resize />	
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>					
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="kendala"
            label="Kendala yang dihadapi">
            <input type="hidden" v-model="model.kendala">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="Kendala yang dihadapi"
              :debounce="250">
              <b-form-textarea
                class="cstm-disabled"
                id="kendala"
                v-model="model.kendala"
                :state="errors[0] ? false : (valid ? true : null)"
                debounce="250"
                rows="3"
                max-rows="5"
                no-resize />	
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>					
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="solusi"
            label="Solusi yang dilakukan">
            <input type="hidden" v-model="model.solusi">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="Solusi yang dilakukan"
              :debounce="250">
              <b-form-textarea
                class="cstm-disabled"
                id="solusi"
                v-model="model.solusi"
                :state="errors[0] ? false : (valid ? true : null)"
                debounce="250"
                rows="3"
                max-rows="5"
                no-resize />	
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
	name: 'ModalTambahPrestasiJabatan',
	props: {
		mIdPrestasiJabatan: {
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
			resourceName: 'modal-tambah-prestasi-jabatan',						
			show:false,	
			required: null,
			dpSettings: {
					format: "yyyy",
                    minViewMode: 'years'
				},
			model:{
				selectedYear: (this.$route.params.year) ? this.$route.params.year : this.$moment(this.$app.current_date).format('YYYY'),
				jabatan: null,
				keberhasilan: null,
				kendala: null,
				solusi: null,
				nrk: null
			},
			items: [],				
			option:[],
		}
	},
	watch:{
		nrk(n) {
			if (n) {
				this.model.nrk = n
				this.loadProvider(n)
			}
		},
    },	
	methods:{	
		onCloseModal() {
			this.model.selectedYear = ''
			this.model.jabatan		= null
			this.model.keberhasilan	= null
			this.model.kendala		= null
			this.model.solusi		= null
			this.model.nrk			= null
			this.$bvModal.hide(this.mIdPrestasiJabatan)
		},		
		async loadProvider(n) 
		{
			this.loading 	= true
			let promise 	= this.$http.get(this.$app.route('profil.jenis-jabatan-get', {
								nrk: n
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
		},	
		async onSubmit() 
		{	
			let vm 			= this
			let url 		= vm.$app.route('profil.store-prestasi-jabatan')
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
							this.model.selectedYear = ''
							this.model.jabatan		= null
							this.model.keberhasilan	= null
							this.model.kendala		= null
							this.model.solusi		= null
							this.model.nrk			= null
							this.$root.$emit('bv::refresh::table', 'prestasijabatantable')
							vm.$bvModal.hide(vm.mIdPrestasiJabatan)
						}
					})
				}
			})
		},
	},	
}
</script>

<style lang="scss">
.custom-input-width {
	min-width: 70px;
}
</style>
