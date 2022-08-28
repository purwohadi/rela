<template>
  <!-- begin form add -->
  <b-modal
    :id="mIdPendidikanFormal"
    :ref="mIdPendidikanFormal"
    size="lg"
    :title="title"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc>
		
    <section id="modal-tambah-pendidikan-formal">	
      <validation-observer v-slot="{ passes }" :slim="true">
        <form @submit.prevent="passes(onSubmit)">
          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="jenjang_pendidikan"
            label="Jenjang Pendidikan">
            <input type="hidden" v-model="model.jenjang_pendidikan">
            <ValidationProvider
              rules="required"
              v-slot="{ valid, errors }"
              name="Jenjang Pendidikan"
              :debounce="250">
              <b-form-select
                :options="optionPendidikanFormal"
                id="jenjang_pendidikan"
                v-model="model.jenjang_pendidikan"
                :state="errors[0] ? false : (valid ? true : null)"
                autofocus
              ></b-form-select>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="keterangan"
            label="Prestasi Yang Diperoleh">
            <b-form-textarea
              class="cstm-disabled"
              id="keterangan"
              v-model="model.prestasi_diperoleh"
              debounce="250"
              rows="3"
              max-rows="5"
              no-resize />						
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
	name: 'ModalTambahPendidikanFormal',
	props: {
		mIdPendidikanFormal: {
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
			resourceName: 'modal-tambah-pendidikan-formal',						
			readonly:false,	
			model:{
				jenjang_pendidikan: null,
				prestasi_diperoleh: null,
				nrk: null
			},
			items: [],				
			optionPendidikanFormal:[],
			//btnSimpan : false,
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
			this.model.jenjang_pendidikan 	= null
			this.model.prestasi_diperoleh	= null
			this.model.nrk					= null
			this.$bvModal.hide(this.mIdPendidikanFormal)
		},	
		async loadProvider (n) 
		{
			this.loading 			= true
			let promise 			= this.$http.get(this.$app.route('profil.jenis-pendidikan-formal-get', {
										nrk: n
									}))
			return promise.then((data) => {				
				const items 					= data.data
				this.optionPendidikanFormal 	= items
				this.loading 					= false
				return this.items
			}).catch(error => {
				this.loading 		= false
				return []
			})			
		},
		async onSubmit() 
		{	
			console.log('sdsd');
			let vm 			= this
			let url 		= vm.$app.route('profil.store-pendidikan-formal')
			let frm 		= new FormData()
        	let formData 	= this.$app.objectToFormData(this.model, frm)
			
			let method ='post'
			vm.$app.confirm({
				text: vm.$t('general.alert.confirm.add'),
				preConfirm: () => {
				return vm.$http
					[method](url, formData)
					.then(response => {
						console.log(response)
						if (response.data.status == "error") {
							throw new Error(response.data.message)
						} else {
							return response
						}
					})
					.catch(error => {
						console.log('error 2');
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
							this.model.jenjang_pendidikan 	= null
							this.model.prestasi_diperoleh	= null
							this.model.nrk					= null
							this.$root.$emit('bv::refresh::table', 'pendidikanformaltable')
							vm.$bvModal.hide(vm.mIdPendidikanFormal)
						}
					})
				}
			})
		},
	},	
}
</script>

<style lang="scss">
#modal-tambah-pendidikan-formal{
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
