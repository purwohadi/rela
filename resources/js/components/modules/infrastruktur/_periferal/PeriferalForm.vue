<template>
	<div class="row">
		<div class="col-12">
			<section id="jaringan-intra-pemerintah-form">						
				<b-card class="mb-4 mt-3 rounded">		
					<div class="col-12 mt-4 ml-4">					
						<b-row>
							<b-col lg="12" md="12" sm="12" class="text-right"> 
								<button
									type="button"
									style="margin: 10px 15px 0px;"
									class="btn btn-danger btn-sm rounded waves-effect waves-themed"
									v-b-tooltip.hover.top="$t('general.button.back')"
									@click="onBack"
									v-if="isDetail">
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
									label-for="rai-level_1"
									label="Referensi Arsitektur Infrastruktur Level 1">									
									<b-col sm="6">
										<b-form-input
											class="ml-2"
											v-model="model.rai_level_1.kode_nama"
											:readonly="true">
										</b-form-input>
									</b-col>
								</b-form-group>
								
								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="rai-level_2"
									label="Referensi Arsitektur Infrastruktur Level 2">									
									<b-col sm="6">
										<b-form-input
											class="ml-2"
											v-model="model.rai_level_2.kode_nama"
											:readonly="true">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="rai-level_3"
									label="Referensi Arsitektur Infrastruktur Level 3">									
									<b-col sm="6">
										<b-form-input
											class="ml-2"
											v-model="model.rai_level_3.kode_nama"
											:readonly="true">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="rai-level_4"
									label="Referensi Arsitektur Infrastruktur Level 4">
									<b-col sm="6" v-if="!isDetail">
										<validation-provider name="Referensi Arsitektur Infrastruktur Level 4" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="rai-level_4"
												ref="rai-level_4"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsRaiLevel4"
												v-model="model.rai_level_4"
												:custom-label="nameSelected"
												track-by="kode_nama"
												:searchable="true"
												:limit="100"
												:options-limit="100">     

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
									<b-col sm="6" v-else>
										<b-form-input
											class="ml-2"
											v-model="model.rai_level_4.kode_nama"
											:readonly="isDetail">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="nama"
									label="Nama Perangkat Periferal">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Nama Perangkat Periferal"
											:debounce="250">
											<b-form-input
												class="ml-2"
												v-model="model.nama"
												:id="'nama'" 
												placeholder="Nama Perangkat Periferal"
												:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
												:disabled="isDetail">
											</b-form-input>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="deskripsi-periferal"
									label="Deskripsi Periferal">
									<b-col sm="6">		
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Deskripsi Periferal"
											:debounce="250">					
											<b-form-textarea
												class="ml-2"
												:id="'deskripsi-periferal'" 
												v-model="model.deskripsi"
												placeholder="Deskripsi Periferal"
												rows="3"
												max-rows="6"
												:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
												:disabled="isDetail">
											</b-form-textarea>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="instansi"
									label="Instansi">									
									<b-col sm="6">
										<b-form-input
											class="ml-2"	
											v-model="model.instansi.akronim"
											placeholder="Instansi"
											:readonly="true">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="tipe"
									label="Tipe">
									<b-col sm="6" v-if="!isDetail">
										<validation-provider name="Tipe" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="tipe"
												ref="tipe"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsTipe"
												v-model="model.tipe"
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
												:disabled="isDetail">     

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
									<b-col sm="6" v-else>
										<b-form-input
											class="ml-2"
											v-model="model.tipe.kode_nama"
											:readonly="isDetail">
										</b-form-input>
									</b-col>
								</b-form-group>
		
								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="lokasi"
									label="Lokasi">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Lokasi"
											:debounce="250">
											<b-form-input
												class="ml-2"
												v-model="model.lokasi"
												:id="'lokasi'" 
												placeholder="Lokasi"
												:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
												:disabled="isDetail">
											</b-form-input>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="unit-pengelola"
									label="Unit Pengelola">
									<b-col sm="6" v-if="!isDetail">
										<validation-provider name="Unit Pengelola" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="unit-pengelola"
												ref="unit-pengelola"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsUnitPengelola"
												v-model="model.unit_pengelola"
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
												:disabled="isDetail">     

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
									<b-col sm="6" v-else>
										<b-form-input
											class="ml-2"
											v-model="model.unit_pengelola.kode_nama"
											:readonly="isDetail">
										</b-form-input>
									</b-col>
								</b-form-group>
								
								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="id_metadata"
									label="ID Metadata (Fasilitas Komputasi) (dapat diisi lebih dari satu pilihan)">
									<b-col sm="6">
										<validation-provider name="ID Metadata (Fasilitas Komputasi) (dapat diisi lebih dari satu pilihan)" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="id_metadata"
												ref="id_metadata"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsIdMetadataTerkait"
												v-model="model.id_metadata_terkait"
												:custom-label="nameSelected"
												track-by="kode_nama"
												placeholder=""
												:searchable="true"
												:limit="100"
												:options-limit="100"	
												:multiple="true"											
												:close-on-select="false" 
												:clear-on-select="false" 
												:disabled="isDetail">     

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

								<div class="text-right mt-4 mb-4" v-show="!isDetail">
									<b-col sm="7">	
										<b-button type="submit" variant="primary" class="mr-2">
											<i class="fal fa-save"></i>
											{{ $t('general.form.button_add') }}
										</b-button>
										
										<b-button ref="closebtn" variant="default" @click="onBack" class="mr-2">
											<i class="fal fa-times"></i>
											{{ $t('general.form.button_cancel') }}
										</b-button>
									</b-col>
								</div>
							</form>	
						</ValidationObserver>
					</div>
				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default
{
	name: 'JaringanIntraPemerintahForm',
	components: { 
	},
	data(){
		return{				
			tempOpdId: '',
			mediaShow: false,
			model: {				
				rai_level_1: [],
				rai_level_2: [],
				rai_level_3: [],
				rai_level_4: [],
				nama: '',
				deskripsi: '',
				instansi: [],
				tipe: [],
				lokasi: '',
				unit_pengelola: [],
				id_metadata_terkait: [],
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			optionsInstansi: [],
			optionsRaiLevel1: [],
			optionsRaiLevel2: [],
			optionsRaiLevel3: [],
			optionsRaiLevel4: [],		
			optionsTipe: [],
			optionsTipe1:[
				{kode: "1.1 Pusat Data - Pembangkit Kelistrikan", kode_nama: "1.1 Pusat Data - Pembangkit Kelistrikan"},
				{kode: "1.2 Pusat Data - Distribusi Kelistrikan", kode_nama: "1.2 Pusat Data - Distribusi Kelistrikan"},
				{kode: "1.3 Pusat Data - Sistem Pencahayaan", kode_nama: "1.3 Pusat Data - Sistem Pencahayaan"},
				{kode: "1.4 Pusat Data - Pencegah/Pemadam Kebakaran", kode_nama: "1.4 Pusat Data - Pencegah/Pemadam Kebakaran"},
				{kode: "1.5 Pusat Data - Pendinginan", kode_nama: "1.5 Pusat Data - Pendinginan"}
			],
			optionsTipe2:[
				{kode: "2.1 Non Pusat Data - Pemantauan Lingkungan", kode_nama: "2.1 Non Pusat Data - Pemantauan Lingkungan"},
				{kode: "2.2 Non Pusat Data - Keamanan Fisik", kode_nama: "2.2 Non Pusat Data - Keamanan Fisik"},
				{kode: "2.3 Non Pusat Data - Komputer/Server", kode_nama: "2.3 Non Pusat Data - Komputer/Server"},
				{kode: "2.4 Non Pusat Data - Telco & Network", kode_nama: "2.4 Non Pusat Data - Telco & Network"},
				{kode: "2.5 Non Pusat Data - Storage", kode_nama: "2.5 Non Pusat Data - Storage"},
				{kode: "2.6 Non Pusat Data - Software", kode_nama: "2.6 Non Pusat Data - Software"}
			],
			optionsUnitPengelola:[
				{kode: "OPD Sendiri", kode_nama: "OPD Sendiri"},
				{kode: "Diskominfotik", kode_nama: "Diskominfotik"},
				{kode: "Pihak Lain", kode_nama: "Pihak Lain"}
			],
			optionsIdMetadataTerkait:[],
			// opd_id: (this.$app.user.is_admin)?this.$route.params.opd_id:this.$app.user.opd_id,
			opd_id: this.$route.params.opd_id,
			isDetail: false,
		}
	},
	computed: { },
	watch: {
		'model.rai_level_4':{
			handler: function(data){			
				this.optionsTipe = this.optionsTipe2
				if(data.kode.substr(-2) == '01'){
					this.optionsTipe = this.optionsTipe1
				}
				this.model.tipe = this.model.tipe ? this.optionsTipe.find(data => data.kode === this.model.tipe.kode	) : {kode:'',kode_nama:''}; 
			},
		},	
		'model.media_type':{
			handler: function(data){	
				this.model.other_media = ''
				this.mediaShow = (data.kode == 'Lainnya')?true:false
			},
		},
	},
	mounted:function(){ },
	created(){
		// this.resPerangkatDaerah().then((data) => {
		// 	this.optionsInstansi	= data
		// 	// this.model.instansi 	= data[0]
		// })
		this.resPerangkatDaerahBySlug()
		if(this.model?.status){		
			this.resDomainInfraPeriferal()
			this.isDetail = (this.model.status == 'detail')?true:false		
		}
		
		this.resRal('03',1).then((data) =>{this.model.rai_level_1 = data[0]})
		this.resRal('03.01',2).then((data) =>{this.model.rai_level_2 = data[0]})
		this.resRal('03.01.05',3).then((data) =>{this.model.rai_level_3 = data[0]})
		this.resRal('03.01.05',4).then((data) =>{this.optionsRaiLevel4 = data})		

		this.resMetadata().then((data) =>{this.optionsIdMetadataTerkait = data})
	},
	methods :
	{				
		onBack() {
			this.$router.push({name: 'infrastruktur.periferal', params: {
				opd_id: this.tempOpdId
			}})
		},	
		onSubmit(){
			let vm 			= this			
      		let routeName 	= vm.model.status ? 'periferal.update-data-domain-infra-pheri' : 'periferal.simpan-data-domain-infra-pheri'
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
						// vm.$app.success(result.value.data.message)
						// .then(response => {
						// 	if (response.value === true) {								
						// 		this.$router.go(-1)
						// 	}
						// })
						vm.$app.alert.fire({
							icon: result.value.data.status,
							title: result.value.data.status ? 'Sukses' : 'Info',
							text: result.value.data.message,
							showConfirmButton: false,
							timer: 1300
						}).then(response => {
							this.$router.push({name: 'infrastruktur.periferal', params: {
								opd_id: this.tempOpdId
							}})
						})						
					}
				})
		},					
		async resDomainInfraPeriferal(){
			const res = await this.$http.get(this.$app.route('periferal.search-intra-periferal.get', {id_pheri: this.model.id}))
			if(res.data){			
				const rai4 						= await this.resRal(res.data.rai_level_3.split(' ')[0],4,res.data.rai_level_4)
				const perangkatDaerah 			= await this.resPerangkatDaerahById(res.data.opd_id);

				this.model.id					= res.data.id				
				this.tempOpdId					= res.data.opd_id

				this.model.rai_level_4 			= rai4[0] ? rai4[0]:{kode: '', kode_nama: ''}
				this.model.nama					= res.data.nama
				this.model.deskripsi 			= res.data.deskripsi
				this.model.instansi 			= perangkatDaerah[0]

				/**Tipe	 */
				this.model.tipe 				= res.data.tipe ? this.optionsTipe1.find(data => data.kode === res.data.tipe) : {kode:'',kode_nama:''}; 
				if(res.data.rai_level_4.substr(-2) == '02'){
					this.model.tipe 				= res.data.tipe ? this.optionsTipe2.find(data => data.kode === res.data.tipe) : {kode:'',kode_nama:''}; 
				}
				
				this.model.lokasi 				= res.data.lokasi
				this.model.unit_pengelola 		= res.data.unit_pengelola ? this.optionsUnitPengelola.find(data => data.kode === res.data.unit_pengelola) : {kode:'',kode_nama:''}
				this.model.id_metadata_terkait 	= res.data.metadata_terkait
			}
		},		
		nameProsesBisnis ({proses_id}) {
			return `${proses_id}`
		},	
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'rai'}))
			return res.data			
		},		
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('jaringan-intra-pemerintah.get-domain-code.get', {col:'domain_code',domain_name:'DOMAIN_INFRA_PHERI'}))
			return res.data			
		},
		nameSelected({kode_nama}){
			return `${kode_nama}`
		},		
		async resPerangkatDaerahById(opd_id){
			const res 				= await this.$http.get(this.$app.route('periferal.data-perangkat-daerah.get', {opd_id: opd_id}))
			return res.data 
		},	
		async resPerangkatDaerahBySlug(){
			const res 				= await this.$http.get(this.$app.route('domain.data-perangkat-daerah-byslug.get', {opd_id: this.opd_id}))
			this.tempOpdId			= res.data.opd_id
			// this.model.opd_id 		= res.data.opd_id
			// this.model.unit_kerja 	= res.data.nama_opd
			this.model.instansi		= res.data
		},	
	},
}
</script>

<style>
#app {
  margin: 20px;
}
</style>