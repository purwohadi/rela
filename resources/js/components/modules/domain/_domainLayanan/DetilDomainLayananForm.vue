<template>
	<b-modal
		:id="mId"
		:ref="mId"
		size="xl"
		:title="title"
		hide-footer
		no-close-on-backdrop
		no-close-on-esc>
		<section id="detil-domain-layanan-form">		
			<div class="col-12">			
				<ValidationObserver v-slot="{ passes }" :slim="true">
					<form @submit.prevent="passes(onSubmit)">	
						<b-form-group
							label-cols="4"
							label-cols-lg="4"
							label-for="fungsi-layanan"
							label="Fungsi Layanan">
							<b-col lg="10">		
								<ValidationProvider
									rules="required"
									v-slot="{ valid, errors }"
									name="Fungsi Layanan"
									:debounce="250">					
									<b-form-textarea
										class="ml-2"
										:id="'fungsi-layanan'" 
										v-model="model.fungsi_layanan"
										placeholder="Fungsi Layanan"
										rows="3"
										max-rows="6"
										:state="errors[0] ? false : (valid ? true : null)">
									</b-form-textarea>
									<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
								</ValidationProvider>
							</b-col>
						</b-form-group>
						
						<b-form-group
							label-cols="4"
							label-cols-lg="4"
							label-for="pelaksana-level1"
							label="Unit Pelaksana Level 1 (Eselon 3)">
							<b-col sm="10">
								<validation-provider name="Unit Pelaksana Level 1 (Eselon 3)" rules="required" v-slot="{ errors, ariaMsg }">
									<m-select
										id="pelaksana-level1"
										ref="pelaksana-level1"
										class="mb-2"
										:option-height="73"
										:tabindex="7"
										:options="optionsPelaksanaLevel1"
										v-model="model.pelaksana_level1"
										label="najabl"
										track-by="najabl"
										placeholder=""
										:searchable="true"
										:limit="100"
										@input="resJabatanTropdEselon4"
										:options-limit="100">     

										<template #noOptions>
											Tidak ada data
										</template>
										<template #noResult>
											Data tidak ditemukan
										</template>
									</m-select>
									<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
										{{ errors[0] }}
									</small>
								</validation-provider>
							</b-col>

							<!-- <b-col lg="10">		
								<ValidationProvider
									rules="required"
									v-slot="{ valid, errors }"
									name="Unit Pelaksana Level 1 (Eselon 3)"
									:debounce="250">					
									<b-form-textarea
										class="ml-2"
										:id="'pelaksana-level1'" 
										v-model="model.pelaksana_level1"
										placeholder="Unit Pelaksana Level 1 (Eselon 3)"
										rows="3"
										max-rows="6"
										:state="errors[0] ? false : (valid ? true : null)">
									</b-form-textarea>
									<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
								</ValidationProvider>
							</b-col> -->
						</b-form-group>

						<b-form-group
							label-cols="4"
							label-cols-lg="4"
							label-for="pelaksana-level2"
							label="Unit Pelaksana Level 2 (Eselon 4)">
							<b-col sm="10">
								<validation-provider name="Unit Pelaksana Level 2 (Eselon 4)" rules="required" v-slot="{ errors, ariaMsg }">
									<m-select
										id="pelaksana-level2"
										ref="pelaksana-level2"
										class="mb-2"
										:option-height="73"
										:tabindex="7"
										:options="optionsPelaksanaLevel2"
										v-model="model.pelaksana_level2"
										label="najabl"
										track-by="najabl"
										placeholder=""
										:searchable="true"
										:limit="100"
										:options-limit="100"
										:multiple="true"										
										:close-on-select="false" 
										:clear-on-select="false">     

										<template #noOptions>
											Tidak ada data
										</template>
										<template #noResult>
											Data tidak ditemukan
										</template>
									</m-select>
									<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
										{{ errors[0] }}
									</small>
								</validation-provider>
							</b-col>
							<!-- <b-col lg="10">		
								<ValidationProvider
									rules="required"
									v-slot="{ valid, errors }"
									name="Unit Pelaksana Level 2 (Eselon 4)"
									:debounce="250">					
									<b-form-textarea
										class="ml-2"
										:id="'pelaksana-level2'" 
										v-model="model.pelaksana_level2"
										placeholder="Unit Pelaksana Level 2 (Eselon 4)"
										rows="3"
										max-rows="6"
										:state="errors[0] ? false : (valid ? true : null)">
									</b-form-textarea>
									<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
								</ValidationProvider>
							</b-col> -->
						</b-form-group>

						<b-form-group
							label-cols="4"
							label-cols-lg="4"
							label-for="target-layanan"
							label="Target Layanan">
							<b-col lg="10">		
								<ValidationProvider
									rules="required"
									v-slot="{ valid, errors }"
									name="Target Layanan"
									:debounce="250">					
									<b-form-textarea
										class="ml-2"
										:id="'target-layanan'" 
										v-model="model.target_layanan"
										placeholder="Target Layanan"
										rows="3"
										max-rows="6"
										:state="errors[0] ? false : (valid ? true : null)">
									</b-form-textarea>
									<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
								</ValidationProvider>
							</b-col>
						</b-form-group>
						
						<b-form-group
							label-cols="4"
							label-cols-lg="4"
							label-for="delegasi"
							label="Unit Pendelegasian Kewenangan">
							<b-col sm="10	">
								<validation-provider name="Unit Pendelegasian Kewenangan" rules="required" v-slot="{ errors, ariaMsg }">
									<m-select
										id="delegasi"
										ref="delegasi"
										class="mb-2"
										:option-height="73"
										:tabindex="7"
										:options="optionsDelegasi"
										v-model="model.delagasi"
										label="akronim"
										track-by="akronim"
										placeholder=""
										:searchable="true"
										:limit="100"
										:options-limit="100"									
										:multiple="true"											
										:close-on-select="false" 
										:clear-on-select="false" >     

										<template #noOptions>
											Tidak ada data
										</template>
										<template #noResult>
											Data tidak ditemukan
										</template>
									</m-select>
									<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
										{{ errors[0] }}
									</small>
								</validation-provider>
							</b-col>
							<!-- <b-col lg="10">		
								<ValidationProvider
									rules="required"
									v-slot="{ valid, errors }"
									name="Unit Pendelegasian Kewenangan"
									:debounce="250">					
									<b-form-textarea
										class="ml-2"
										:id="'delegasi'" 
										v-model="model.delegasi"
										placeholder="Unit Pendelegasian Kewenangan"
										rows="3"
										max-rows="6"
										:state="errors[0] ? false : (valid ? true : null)">
									</b-form-textarea>
									<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
								</ValidationProvider>
							</b-col> -->
						</b-form-group>

						<div class="text-right mt-4">
							<b-button type="submit" variant="primary">
								<i class="fal fa-save"></i>
								{{ $t('general.form.button_add') }}
							</b-button>
							<b-button ref="closebtn" variant="default" @click="onCloseModal" class="mr-2">
								<i class="fal fa-times"></i>
								{{ $t('general.form.button_cancel') }}
							</b-button>
						</div>
					</form>	
				</ValidationObserver>
			</div>
		</section>
	</b-modal>
</template>

<script>
export default
{
	name: 'DetilDomainLayananForm',
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
		opdId: {
			type: String,
			default: ''
		},		
		isStatus: {
			type: String,
			default: ''
		},		
		layananId: {
			type: String,
			default: ''
		},	
		// probisId: {
		// 	type: String,
		// 	default: ''
		// },
		idLayananDetail: {
			type: String,
			default: ''
		},
		klikDate: {
			type: String,
			default: ''
		},
	},
	components: { 
	},
	data(){
		return{				
			model: {
				prosesBisnis: [],
				fungsi_layanan: '',
				// pelaksana_level1: '',
				// pelaksana_level2: '',
				target_layanan: '',
				// delegasi: '',	
				id: '',
				layanan_id: '',
				id_layanan_detail: '',
				prosesBisnisUbah: '',				
				pelaksana_level1: [],
				pelaksana_level2: [],
				target_layanan: '',
				delagasi: [],	
			},
			optionsProsesBisnis: [],
			optionsDelegasi: [],	
			optionsPelaksanaLevel1: [{'kojab': '', 'najabl': '', 'kojab_atasan': ''}],
			optionsPelaksanaLevel2: [{'kojab': '', 'najabl': '', 'kojab_atasan': ''}],
			isShow: true
		}
	},
	computed: { },
	watch: {
		opdId(data) {
			// if (data) {
			// 	this.resProsesBisnis()
			// }
		},
		klikDate(data){
			if (data) {					
				this.resJabatanTropdEselon3()
				
				if(this.isStatus == 'tambah'){
					this.model.id_layanan_detail 	= ''
					this.model.pelaksana_level1 	= ''
					this.model.pelaksana_level2 	= ''
					this.model.fungsi_layanan 		= ''
					this.model.target_layanan 		= ''
					this.model.delegasi 			= ''
					this.model.layanan_id 			= ''
					this.model.id 					= ''
					
					this.resPerangkatDaerahOpd()
				}
				
				this.model.id_layanan_detail 	= this.idLayananDetail
				this.isShow 					= (this.isStatus == 'ubah') ? false:true
				this.model.layanan_id 			= this.layananId
				this.model.id_layanan_detail 	= this.idLayananDetail
				if(this.isStatus == 'ubah'){
					this.resDomainLayananDetil()
					this.resPerangkatDaerahOpd(this.opdId)
					this.isShow = false
				}
			}
		}
	},
	mounted:function(){ },
	created(){	
	},
	methods :
	{		
		onCloseModal() {
			this.$bvModal.hide(this.mId)
		},		
		// async resProsesBisnis(){
		// 	const res 					= await this.$http.get(this.$app.route('domain.data-proses-bisnis.get', {opd_id: this.opdId}))
		// 	this.optionsProsesBisnis 	= res.data 
		// 	return res.data
		// },		
		// async resProsesBisnisById(){
		// 	const res 					= await this.$http.get(this.$app.route('domain.data-proses-bisnis.get', {opd_id: this.opdId, proses_id: this.probisId}))
		// 	this.optionsProsesBisnis 	= res.data 
		// 	return res.data
		// },	
		
		nameProbis({proses_id, rab_level4}){
			return `${proses_id} (${rab_level4})`
		},		

		async resDomainLayananDetil(){
			const res = await this.$http.get(this.$app.route('domain.get-layanan-detail-by-id', {id_layanan: this.idLayananDetail}))
			console.log(res.data);
			if(res.data){
				// const dataProses = await this.resProsesBisnisById()			
				// this.model.prosesBisnis 	= dataProses[0]
				// this.model.prosesBisnisUbah = dataProses[0].proses_id+' ('+dataProses[0].rab_level4+')'
				const pelaksanaLevel1 		= await this.resJabatanTropdEselon3(res.data.pelaksana_level1)
				const pelaksanaLevel2		= await this.$http.get(this.$app.route('domain.data-jabatan-tropd-eselon4', {opd_id: this.opdId, kojab_atasan: res.data.pelaksana_level1, kojab:res.data.pelaksana_level2 }))
				const delegasi				= await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id:res.data.unit_delegasi}))

				this.model.fungsi_layanan	= res.data.fungsi_layanan
				this.model.pelaksana_level1 = pelaksanaLevel1.find(data => data.kojab === res.data.pelaksana_level1)
				this.model.pelaksana_level2 = pelaksanaLevel2.data
				
				console.log('delegasi : ',delegasi.data)
				this.model.target_layanan 	= res.data.target_layanan		
				// this.model.delegasi 		= res.data.unit_delegasi	
				this.model.delagasi 		= delegasi.data	
				this.model.id 				= res.data.id			

			}			
		},	
		async onSubmit() 
		{	
			let vm 			= this
			let url 		= vm.$app.route((this.isStatus=='ubah') ? 'domain.ubah-layanan-detail' : 'domain.simpan-layanan-detail')
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
					// vm.$app.success(
					// 	result.value.data.message,
					// 	result.value.data.status,
					// )
					// .then(response => {
					// 	if (response.value === true) {
					// 		this.$root.$emit('bv::refresh::table', 'domain-layanan-form')
					// 		vm.$bvModal.hide(vm.mId)
					// 	}
					// })
					vm.$app.alert.fire({
						icon: result.value.data.status,
						title: result.value.data.status ? 'Sukses' : 'Info',
						text: result.value.data.message,
						showConfirmButton: false,
						timer: 1300
					}).then(response => {
						this.$root.$emit('bv::refresh::table', 'domain-layanan-form')
						vm.$bvModal.hide(vm.mId)
					})	
				}
			})
		},			
		async resPerangkatDaerahOpd(opdId){
			const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {}))
			this.optionsDelegasi = res.data 
			return res.data
		},		
		async resJabatanTropdEselon3(kojab = null){
			const res 					= await this.$http.get(this.$app.route('domain.data-jabatan-tropd-eselon3', {opd_id: this.opdId, kojab:kojab }))
			this.optionsPelaksanaLevel1 = res.data
			return res.data
		},		
		async resJabatanTropdEselon4(){
			this.model.pelaksana_level2 = []
			this.optionsPelaksanaLevel2 = []
			const res 					= await this.$http.get(this.$app.route('domain.data-jabatan-tropd-eselon4', {opd_id: this.opdId, kojab_atasan: this.model.pelaksana_level1.kojab}))
			this.optionsPelaksanaLevel2	= res.data
			return res.data
		}
	},
}
</script>

<style>
#app {
  margin: 20px;
}
</style>