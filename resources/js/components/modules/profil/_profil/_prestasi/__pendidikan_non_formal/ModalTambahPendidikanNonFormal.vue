<template>
  <!-- begin form add -->
  <b-modal
    :id="mIdPendidikanNonFormal"
    :ref="mIdPendidikanNonFormal"
    size="lg"
    :title="title"
    hide-footer
    no-close-on-backdrop
    no-close-on-esc>
		
    <section id="modal-tambah-pendidikan-non-formal">	
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
                class="cstm-disabled"
                :options="option"
                id="jenjang_pendidikan"
                v-model="model.jenjang_pendidikan"
                :state="errors[0] ? false : (valid ? true : null)"
                autofocus
                @change="onChange"
              ></b-form-select>
              <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-cols="2"
            label-cols-lg="2"
            label-for="jenjang_pendidikan_lainnya"
            v-show="show">
            <input type="hidden" v-model="model.jenjang_pendidikan_lainnya">
            <ValidationProvider
              :rules="required"
              v-slot="{ valid, errors }"
              name="Jenjang Pendidikan Lainnya"
              :debounce="250">
              <b-form-input
                class="cstm-disabled"
                id="jenjang_pendidikan_lainnya"
                v-model="model.jenjang_pendidikan_lainnya"
                :state="errors[0] ? false : (valid ? true : null)">
              </b-form-input>
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
	name: 'ModalTambahPendidikanNonFormal',
	props: {
		mIdPendidikanNonFormal: {
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
			resourceName: 'modal-tambah-pendidikan-non-formal',						
			show:false,	
			required: null,
			model:{
				jenjang_pendidikan: null,
				jenjang_pendidikan_lainnya: null,
				prestasi_diperoleh: null,
				nrk: null
			},
			items: [],				
			option:[],
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
			this.$bvModal.hide(this.mIdPendidikanNonFormal)
		},			
		onChange(e) {
			this.show = false
			if (this.model.jenjang_pendidikan=='lainnya') 
			{
				this.show = true
				this.required = 'required'
			}
		},
		async loadProvider (n) 
		{
			this.loading 	= true
			let promise 	= this.$http.get(this.$app.route('profil.jenis-pendidikan-non-formal-get', {
								nrk: n
							}))
			return promise.then((data) => {				
				const items 	= data.data
				var  lainnya 	= {'value' : 'lainnya', "text" : 'Lainnya'}
				this.option 	= items.concat(lainnya)
				this.loading 	= false
				return this.items
			}).catch(error => {
				this.loading 		= false
				return []
			})			
		},
		async onSubmit() 
		{	
			let vm 			= this
			let url 		= vm.$app.route('profil.store-pendidikan-non-formal')
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
							this.model.jenjang_pendidikan 	= null
							this.model.prestasi_diperoleh	= null
							this.model.nrk					= null
							this.$root.$emit('bv::refresh::table', 'pendidikannonformaltable')
							vm.$bvModal.hide(vm.mIdPendidikanNonFormal)
						}
					})
				}
			})
		},
	},	
}
</script>

<style lang="scss">
#modal-tambah-pendidikan-non-formal{
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
