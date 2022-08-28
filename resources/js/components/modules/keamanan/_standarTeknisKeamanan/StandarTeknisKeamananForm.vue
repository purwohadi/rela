<template>
	<div class="row">
		<div class="col-12">
			<section id="standar-teknis-keamanan-form">						
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
											:readonly="true">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							
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
											:custom-label="nameSelected"
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
								label-for="rai_level_2"
								label="Referensi Arsitektur Keamanan Level 2">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Keamanan Level 2" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai_level_2"
											ref="rai_level_2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel2"
											v-model="model.rai_level_2"
											:custom-label="nameSelected"
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
								label-for="nama"
								label="Nama">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.nama"
											:id="'nama'" 
											placeholder="Nama"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							
							<!--
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tanggal-mulai-penerapan"
								label="Tanggal Mulai Penerapan">
								<b-col sm="4">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Tanggal Mulai Penerapan"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.tgl_mulai"
											:id="'tanggal-mulai-penerapan'" 
											placeholder="Format : DD-MM-YYYY"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>	
							</b-form-group>
							-->

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tanggal-mulai-penerapan"
								label="Tanggal Mulai Penerapan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Tanggal Mulai Penerapan"
										:debounce="250">
										<b-form-datepicker
											class="ml-2"
											v-model="model.tgl_mulai"
											date-format-options="{day: 'numeric' , month: 'numeric' , year: 'numeric'}"
											locale="id"
											maxlength="20"
											:id="'tanggal-mulai-penerapan'" 
											placeholder="Pilih Tanggal Mulai Kegiatan"
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
							
							<!--
							<b-form-group label-for="id_metadata" label="ID Metadata Terkait">
							<input v-model="model.id_metadata" type="hidden">
							<ValidationProvider
								rules="required" v-slot="{ valid, errors }"
								:name="ID Metadata Terkait" :debounce="250">
								<m-select
									id="id_metadata" 
									v-model="model.id_metadata" 
									:options="optionsMetadata" 
									:multiple="true"
									:close-on-select="false" 
									:clear-on-select="false" 
									:preserve-search="true" 
									:preselect-first="true"
									placeholder="ID Metadata Terkait" 
									label="id_metadata" 
									track-by="id_metadata"
									:searchable="true" 
									:state="errors[0] ? false : (valid ? true : null)">

									<template #noOptions>
										Tidak ada data
									</template>

									<template #noResult>
										Data tidak ditemukan
									</template>

								</m-select>
								<invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
							</ValidationProvider>
							</b-form-group>
							-->

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
	name: 'StandarTeknisKeamananForm',
	components: { 
	},
	data(){
		return{				
			mediaShow: false,
			model: {			
				nama: '',
				tgl_mulai: '',
				rai_level_1_fix: '01 Standar Keamanan',
				rai_level_1: [],
				rai_level_2: [],
				id_metadata_terkait: [],
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			dpSettings: {
				todayBtn: true,
				immediateUpdates: false,
				todayHighlight: true,
				endDate: new Date(this.$app.current_date)
			},
			optionsIdMetadataTerkait:[],
			optionsRaiLevel1:[],
			optionsRaiLevel2:[],
			isDetail: false,
		}
	},
	computed: { },
	watch: {
		'model.rai_level_1':{
			handler: function(data){
				this.resRal(data.kode,2).then((data) => {this.optionsRaiLevel2 = data})
			},
		},		
		'model.rai_level_2':{
			handler: function(data){	
				this.resRal(data.kode,3).then((data) => {this.optionsRaiLevel3 = data})
			},
		},
	},
	mounted:function(){ },
	created(){
		this.resDomainInfraTeknisKeamanan()
		//this.resMetadataTerkait().then((data) => {this.optionsIdMetadataTerkait = data})
		this.resMetadata().then((data) => {this.optionsIdMetadataTerkait = data})
		//console.log(this.resMetadata())
		this.isDetail = (this.model.status == 'detail')?false:true
		//this.resRal('', 1).then((data) =>{this.optionsRaiLevel1 = data})
		this.resRal('01', 2).then((data) =>{this.optionsRaiLevel2 = data})		
	},
	methods :
	{				
		onBack() {
			this.$router.go(-1)
		},	
		onSubmit(){
			let vm 			= this			
      		let routeName 	= vm.model.status ? 'standar-teknis-keamanan.update-data-domain-standar-keamanan' : 'standar-teknis-keamanan.simpan-data-domain-standar-keamanan'
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
			}).then(result => {
				if (result.isDismissed) return
				if (result.value.data.status == "success")
				{
					vm.$app.success(result.value.data.message)
						.then(response => {
							if (response.value === true) {								
								this.$router.go(-1)
							}
						})
				}
			})
		},					
		async resDomainInfraTeknisKeamanan(){
			const res = await this.$http.get(this.$app.route('standar-teknis-keamanan.search-standar-keamanan.get', {id_sk: this.model.id}))
			if(res.data){
				//const dataMetadataTerkait = await this.resMetadataTerkait(res.data.id_metadata_terkait)
				const rai2 = await this.resRal(res.data.rak_level_1.split(' ')[0],2,res.data.rak_level_2)

				this.model.id					= res.data.id
				this.model.nama 				= res.data.nama
				this.model.tgl_mulai 			= res.data.tgl_mulai
				this.model.rai_level_2 			= rai2[0]
				
				//console.log(res.data.rak_level_2)
				//console.log(res.data.id_metadata_terkait)

				const metadata = res.data.id_metadata_terkait
				let split = metadata.split("; ")
				//console.log(split[1]);
				let isi = []
				for (let element of split) { // You can use `let` instead of `const` if you like
					//console.log(element)
					//isi.push(element)
					//this.model.id_metadata_terkait = this.optionsIdMetadataTerkait.find(data => data.kode === element)
					
					let a = this.optionsIdMetadataTerkait.find(data => data.kode === element)
					isi.push(a)
					//this.model.id_metadata_terkait = isi
					//nama = this.resNamaAplikasi(element)
					//isi.push(this.resNamaAplikasi(element))
					
					//isi.push(this.resNamaAplikasi(element))
					//console.log(isi)
					
					//nama = this.resNamaAplikasi(element)
					//isi.push({kode: element, kode_nama: nama})					
				}

				this.model.id_metadata_terkait = isi

				//console.log(isi[2])
				//this.model.id_metadata_terkait = this.optionsIdMetadataTerkait.find(data => data.kode === 'A1132', data => data.kode === 'A1144')
				//this.model.id_metadata_terkait = this.optionsIdMetadataTerkait.find(data => data.kode === 'A1144')
				//this.model.id_metadata_terkait = [{"kode": "A1532", "kode_nama": "APLIKASI E-KIR"}, {"kode": "A1147", "kode_nama": "CASH MANAGEMENT SYSTEM"}]
				//this.model.id_metadata_terkait = [{kode: "A1532", kode_nama: "APLIKASI E-KIR"}, {kode: "A1147", kode_nama: "CASH MANAGEMENT SYSTEM"}]
				//console.log(this.resNamaAplikasi('A1532'))
				//let tes = [{kode: "A1532", kode_nama: "APLIKASI E-KIR"}, {kode: "A1147", kode_nama: "CASH MANAGEMENT SYSTEM"}]
				//console.log(tes)
			}
		},		
		async resMetadataTerkait(id_metadata){
			const res = await this.$http.get(this.$app.route('aplikasi.get-data-by.get', {col:'nama_apl', id_metadata:id_metadata}))
			return res.data			
		},
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'rak'}))
			return res.data			
		},
		nameSelected({kode_nama}){
			return `${kode_nama}`
		},
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('standar-teknis-keamanan.get-metadata'))
			return res.data			
		},
		async resNamaAplikasi(id_aplikasi){
			const res = await this.$http.get(this.$app.route('standar-teknis-keamanan.get-nama-aplikasi', {id_aplikasi: id_aplikasi}))
			return res.data			
		}
	}
}
</script>

<style>
#app {
  margin: 20px;
}
</style>