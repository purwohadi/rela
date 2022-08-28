<template>
	<div class="row">
		<div class="col-12">
			<section id="audit-keamanan-form">						
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
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="false"
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
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="false"
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
								label="Nama Kegiatan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Kegiatan"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.nama"
											:id="'nama'" 
											placeholder="Nama Kegiatan"
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
								label-for="jenis"
								label="Jenis Audit">
								<b-col sm="6">
									<validation-provider name="Jenis Audit" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="jenis"
											ref="jenis"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsJenisAudit"
											v-model="model.jenis"
											:custom-label="nameRaiLevel"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="false"
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

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="hasil"
								label="Hasil Audit">
								<b-col sm="6">
									<validation-provider name="Hasil Audit" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="hasil"
											ref="hasil"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsHasilAudit"
											v-model="model.hasil"
											:custom-label="nameRaiLevel"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="false"
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

							<!--
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
										<b-form-input
											class="ml-2"
											v-model="model.tanggal"
											maxlength="20"
											:id="'tanggal'" 
											placeholder="Tanggal Kegiatan"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							-->

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

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tl"
								label="Tindak Lanjut">
								<b-col sm="6">
									<validation-provider name="Tindak Lanjut" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="tl"
											ref="tl"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsTindakLanjut"
											v-model="model.tl"
											:custom-label="nameRaiLevel"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="false"
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
											track-by="kode"
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
													<span class="text-wrap">{{ option.kode }}</span>
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
	name: 'AuditKeamananForm',
	components: { 
	},
	data(){
		return{				
			mediaShow: false,
			model: {				
				nama: '',
				hasil: '',
				jenis: '',
				tanggal: '',
				tl: '',
				rai_level_1: [],
				rai_level_2: [],
				rai_level_1_fix: '02 Penerapan Keamanan',
				rai_level_2_fix: '02.05 Audit Keamanan SPBE',
				id_metadata_terkait: [],
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			optionsRaiLevel1: [],
			optionsRaiLevel2: [],
			optionsIdMetadataTerkait:[],			
			optionsJenisAudit:[
				{kode: "Internal", kode_nama: "Internal"},
				{kode: "Eksternal", kode_nama: "Eksternal"}
			],
            optionsHasilAudit:[
				{kode: "Belum/tidak dilaksanakan", kode_nama: "Belum/tidak dilaksanakan"},
				{kode: "Memadai", kode_nama: "Memadai"},
                {kode: "Perlu Peningkatan", kode_nama: "Perlu Peningkatan"},
                {kode: "Tidak Memadai", kode_nama: "Tidak Memadai"}
			],
			optionsTindakLanjut:[
				{kode: "Belum ditindaklanjuti", kode_nama: "Belum ditindaklanjuti"},
				{kode: "Sebagian ditindaklanjuti", kode_nama: "Sebagian ditindaklanjuti"},
				{kode: "Sebagian besar ditindaklanjuti", kode_nama: "Sebagian besar ditindaklanjuti"},
				{kode: "Penuh ditindaklanjuti", kode_nama: "Penuh ditindaklanjuti"}
			],
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
		}
	},
	mounted:function(){ },
	created(){
		//console.log('status : '+this.model.status)
		//console.log('id : '+this.model.id)
		this.resDomainAuditKeamanan()
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
      		let routeName 	= vm.model.status ? 'audit.update-data-domain-audit-keamanan' : 'audit.simpan-data-domain-audit-keamanan'
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
		async resDomainAuditKeamanan(){
			const res = await this.$http.get(this.$app.route('audit.search-audit-keamanan.get', {id_audit: this.model.id}))
			console.log(res.data)
			console.log(res.data.nama_kegiatan)
			if(res.data){
				const rai1 = await this.resRal('',1,res.data.rak_level_1)
				const rai2 = await this.resRal(res.data.rak_level_1.split(' ')[0],2,res.data.rak_level_2)
				//const rai3 = await this.resRal(res.data.rai_level_2.split(' ')[0],3,res.data.rai_level_3)				
				//const rai4 = await this.resRal(res.data.rai_level_3.split(' ')[0],4,res.data.rai_level_4)

				this.model.id					= res.data.id //nama field tabel
				this.model.nama 				= res.data.nama_kegiatan
				this.model.hasil 				= this.optionsHasilAudit.find(data => data.kode === res.data.hasil_audit)
				this.model.tanggal	 			= res.data.tgl_kegiatan
				this.model.jenis 				= this.optionsJenisAudit.find(data => data.kode === res.data.jenis_audit)
				//this.model.rai_level_1 		= rai1[0]
				//this.model.rai_level_2 		= rai2[0]
				this.model.tl			 		= this.optionsTindakLanjut.find(data => data.kode === res.data.tindak_lanjut)
			
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
		nameProsesBisnis ({proses_id}) {
			return `${proses_id}`
		},	
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'rak'}))
			return res.data			
		},
		nameRaiLevel({kode_nama}){
			return `${kode_nama}`
		},
		nameSelected({kode}){
			return `${kode}`
		},
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('audit.get-metadata'))
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