<template>
	<div class="row">
		<div class="col-12">
			<section id="edukasi-keamanan-form">						
				<b-card class="mb-4 mt-3 rounded">						
					<b-row>
						<b-col lg="12" md="12" sm="12" class="text-right"> 
							<button
								type="button"
								style="margin: 10px 15px 0px;"
								class="btn btn-danger btn-sm rounded waves-effect waves-themed"
								v-b-tooltip.hover.top="$t('general.button.back')"
								@click="onBack">
								<i class="fal fa-arrow-circle-left"></i> 
								{{ $t('general.button.back') }}
							</button>
						</b-col>
					</b-row>
							
					<ValidationObserver v-slot="{ passes }" :slim="true">
						<form @submit.prevent="passes(onSubmit)">

							<!--
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_1"
								label="Referensi Arsitektur Keamanan Level 1">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Keamanan Level 1" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_1"
											ref="rai-level_1"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel1"
											v-model="model.rai_level_1"
											:custom-label="nameRaiLevel"
											select-label=""
											selected-label="02 Penerapan Keamanan"
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="false"
											:disabled="true">     

											<template #noOptions>
												Tidak ada data
											</template>
											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>
							
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_2"
								label="Referensi Arsitektur Keamanan Level 2">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Keamanan Level 2" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_2"
											ref="rai-level_2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel2"
											v-model="model.rai_level_2"
											:custom-label="nameRaiLevel"
											select-label=""
											selected-label="02.01 Edukasi Kesadaran Keamanan SPBE"
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="false"
											:disabled="true">     

											<template #noOptions>
												Tidak ada data
											</template>
											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select> 

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>  
								</b-col>	
							</b-form-group>
							-->
							
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai_level_1_fix"
								label="Referensi Arsitektur Keamanan Level 1">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Referensi Arsitektur Keamanan Level 1"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.rai_level_1_fix"
											maxlength="20"
											:id="'rai_level_1_fix'" 
											placeholder="Referensi Arsitektur Keamanan Level 1"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai_level_2_fix"
								label="Referensi Arsitektur Keamanan Level 2">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Referensi Arsitektur Keamanan Level 2"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.rai_level_2_fix"
											maxlength="20"
											:id="'rai_level_2_fix'" 
											placeholder="Referensi Arsitektur Keamanan Level 2"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="nama"
								label="Nama Kegiatan Edukasi Keamanan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Kegiatan Edukasi Keamanan"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.nama"
											:id="'nama'" 
											placeholder="Nama Kegiatan Edukasi Keamanan"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="deskripsi"
								label="Deskripsi Edukasi Keamanan">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Deskripsi Edukasi Keamanan"
										:debounce="250">					
										<b-form-textarea
											class="ml-2"
											:id="'deskripsi'" 
											v-model="model.deskripsi"
											placeholder="Deskripsi Edukasi Keamanan"
											rows="3"
											max-rows="6"
            								:state="errors[0] ? false : (valid ? true : null)"
											:readonly="!isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tanggal"
								label="Tanggal Kegiatan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Tanggal Kegiatan"
										:debounce="250">
										<b-form-datepicker
											class="ml-2"
											v-model="model.tanggal"
											min="min"
											max="max"
											date-format-options="{day: 'numeric' , month: 'numeric' , year: 'numeric'}"
											locale="id"
											maxlength="20"
											:id="'tanggal'" 
											placeholder="Tanggal Kegiatan"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="!isDetail">
										</b-form-datepicker>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!-- :custom-label="nameSelected" -->
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-terkait"
								label="ID Metadata Terkait">
								<b-col sm="6">
									<validation-provider name="ID Metadata Terkait" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="id-metadata-terkait"
											ref="id-metadata-terkait"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsIdMetadataTerkait"
											v-model="model.id_metadata_terkait"
											:multiple="true"
											:close-on-select="false" 
											:clear-on-select="false" 
											:preserve-search="true" 
											:preselect-first="true"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="true"
											:disabled="!isDetail">     

											<template #noOptions>
												Tidak ada data
											</template>

											<template #noResult>
												Data tidak ditemukan
											</template>

											<template #option="{ option }">
												<div class="d-flex align-items-baseline mb-1">
													<i class="fal fa-laptop mr-2"></i>
													<span class="text-wrap">{{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>   

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>

							<div class="text-left mt-4">
								<b-button type="submit" variant="primary" v-show="isDetail">
									<i class="fal fa-save"></i>
									{{ $t('general.form.button_add') }}
								</b-button>
							</div>
						</form>	
					</ValidationObserver>

				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default
{
	name: 'EdukasiKeamananForm',
	components: { 
	},
	data(){

		const now = new Date()
		const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())

		return{
			mediaShow: false,
			model: {				
				nama: '',
				deskripsi: '',
				tanggal: '',
				rai_level_1_fix: '02 Penerapan Keamanan',
				rai_level_2_fix: '02.01 Edukasi Kesadaran Keamanan SPBE',
				rai_level_1: [],
				rai_level_2: [],
				id_metadata_terkait: [],
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			optionsProsesBisnis: [],
			optionsRaiLevel1: [],
			optionsRaiLevel2: [],
			optionsIdMetadataTerkait:[],
			isDetail: false,
		}
	},
	computed: { },
	watch: {
		'model.rai_level_1':{
			handler: function(data){
				this.resRal(data.kode,2).then((data) =>{this.optionsRaiLevel2 = data})
			},
		},		
		'model.rai_level_2':{
			handler: function(data){	
				this.resRal(data.kode,3).then((data) =>{this.optionsRaiLevel3 = data})
			},
		},
	},
	mounted:function(){ },
	created(){
		console.log('status : '+this.model.status)
		this.resDomainEdukasiKeamanan()
		this.isDetail = (this.model.status == 'detail')?false:true		
		this.resRal('', 1).then((data) =>{this.optionsRaiLevel1 = data})
		this.resMetadata().then((data) => {this.optionsIdMetadataTerkait = data})
	},
	methods :
	{				
		onBack() {
			this.$router.go(-1)
		},	
		onSubmit(){
			let vm 			= this			
      		let routeName 	= vm.model.status ? 'edukasi.update-data-domain-edukasi-keamanan' : 'edukasi.simpan-data-domain-edukasi-keamanan'
			let url 		= vm.$app.route(routeName)
			let frm 		= new FormData()
			let formData 	= vm.$app.objectToFormData(vm.model, frm)

			let method ='post'
			vm.$app.confirm({
				text: vm.$t('Yakin Simpan Data'),
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
					if (result.value.data.status == "success")
					{
						vm.$app.success(result.value.data.message)
						this.$router.go(-1)
					}
				})
		},					
		async resDomainEdukasiKeamanan(){
			const res = await this.$http.get(this.$app.route('edukasi.search-edukasi-keamanan.get', {id_edukasi: this.model.id}))
			console.log(res.data)
			if(res.data){
				const rai1 = await this.resRal('',1,res.data.rak_level_1)
				const rai2 = await this.resRal(res.data.rak_level_1.split(' ')[0],2,res.data.rak_level_2)

				console.log(res.data.nama)

				this.model.id					= res.data.id //nama field tabel
				this.model.nama 				= res.data.nama
				this.model.deskripsi 			= res.data.deskripsi
				this.model.tanggal	 			= res.data.tgl_kegiatan
				//this.model.rai_level_1 		= rai1[0]
				//this.model.rai_level_2 		= rai2[0]

				const metadata = res.data.id_metadata_terkait
				let split = metadata.split("; ")
				
				let isi = []
				for (let element of split) { // You can use `let` instead of `const` if you like
					let a = this.optionsIdMetadataTerkait.find(data => data.kode === element)
					isi.push(a)					
				}
				this.model.id_metadata_terkait = isi
			}
		},	
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'rak'}))
			return res.data			
		},
		nameRaiLevel({kode_nama}){
			return `${kode_nama}`
		},
		nameSelected({kode_nama}){
			return `${kode_nama}`
		},
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('edukasi.get-metadata'))
			return res.data			
		},
	},
}

</script>

<style>
#app {
  margin: 20px;
}
</style>