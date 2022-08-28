<template>
	<div class="row">
		<div class="col-12">
			<section id="fasilitas-komputasi-form">						
				<b-card class="mb-4 mt-3 rounded">						
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
								<b-col sm="6" v-if="!isDetail">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 2" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_2"
											ref="rai-level_2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel2"
											v-model="model.rai_level_2"
											label="kode_nama"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"
											@input="(val) => (resRai2(val))">     

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
								<b-col sm="6" v-else>
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
								<b-col sm="6" v-if="!isDetail">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 3" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_3"
											ref="rai-level_3"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel3"
											v-model="model.rai_level_3"
											label="kode_nama"
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
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
								<b-col sm="6" v-else>
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
								label-for="rai-level-4"
								label="Referensi Arsitektur Infrastruktur Level 4"
								v-if="isDetail">
								<b-col sm="6">
									<b-form-input
										class="ml-2"
										v-model="model.rai_level_4"
										:id="'rai-level-4'" 
										placeholder="Referensi Arsitektur Infrastruktur Level 4"
										:readonly="true">
									</b-form-input>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="nama"
								label="Nama Fasilitas Komputasi">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Fasilitas Komputasi"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.nama"
											:id="'nama'" 
											placeholder="Nama Fasilitas Komputasi"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="instansi"
								label="Instansi">
								<b-col sm="6" v-if="!isDetail && !$app.user.is_admin">
									<validation-provider name="Instansi" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="instansi2"
											ref="instansi2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsInstansi"
											v-model="model.instansi"
											label="akronim"
											track-by="akronim"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"
											@input="onChangeKepemilikan">     

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
								<b-col sm="6" v-else>
									<b-form-input
										class="ml-2"	
										v-model="model.instansi.akronim"
										placeholder="Instansi"
										:readonly="isDetail || $app.user.is_admin">
									</b-form-input>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="kode-model-referensi"
								label="Kode Model Referensi Fasilitas">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Kode Model Referensi Fasilitas"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.kode_model_referensi"
											:id="'kode-model-referensi'" 
											placeholder="Kode Model Referensi Fasilitas"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="bandwidth-intranet"
								label="Bandwidth Intranet">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Bandwidth Intranet"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.bandwidth_intranet"
											:id="'bandwidth-intranet'" 
											placeholder="Bandwidth Intranet"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="bandwidth-internet"
								label="Bandwidth Internet">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Bandwidth Internet"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.bandwidth_internet"
											:id="'bandwidth-internet'" 
											placeholder="Bandwidth Internet"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
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
										<b-form-textarea
											class="ml-2"
											:id="'lokasi'" 
											v-model="model.lokasi"
											placeholder="Lokasi"
											rows="3"
											max-rows="6"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="kepemilikan"
								label="Kepemilikan">
								<b-col sm="6" v-if="!isDetail">
									<validation-provider name="Kepemilikan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="kepemilikan"
											ref="kepemilikan"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsKepemilikan"
											v-model="model.ownership"
											label="kode_nama"
											track-by="kode_nama"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"
											@input="onChangeKepemilikan">     

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
								<b-col sm="6" v-else>
									<b-form-input
										class="ml-2"
										v-model="model.ownership.kode_nama"
										:readonly="true">
									</b-form-input>
								</b-col>
							</b-form-group>
														
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="nama-owner"
								label="Nama Pemilik">
								<b-col sm="6" v-if="isKepemilikanLain && !isDetail ">
									<validation-provider name="Nama Pemilik" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="nama-owner"
											ref="nama-owner"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsNamaPemilik"
											v-model="model.nama_pemilik"
											label="akronim"
											track-by="akronim"
											placeholder=""
											:searchable="true"
											:limit="100"
											:options-limit="100"
											@input="onChangeNamaPemilikan">     

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
								<b-col sm="6" v-else>
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Pemilik"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.nama_pemilik"
											:id="'nama-owner'" 
											placeholder="Nama Pemilik"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail || isMilikSendiri">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="other-pemilik"
								label="Nama Pemilik Lainnya"
								v-show="isNamaMilikLain">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Pemilik Lainnya"
										:debounce="250"
										v-if="isNamaMilikLain">
										<b-form-input
											class="ml-2"
											v-model="model.other_pemilik"
											:id="'other-pemilik'" 
											placeholder="Nama Pemilik Lainnya"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="unit-pj"
								label="Unit Kerja Penanggung jawab">
								<b-col sm="6" v-if="!isDetail">
									<validation-provider name="Unit Kerja Penanggung jawab" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="unit-pj"
											ref="unit-pj"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsPj"
											v-model="model.unit_pj"
											label="akronim"
											track-by="akronim"
											placeholder=""
											:searchable="true"
											:limit="100"
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
								<b-col sm="6" v-else>
									<b-form-input
										class="ml-2"	
										v-model="model.unit_pj.akronim"
										placeholder="Unit Kerja Penanggung jawab"
										:readonly="isDetail || !$app.user.is_admin">
									</b-form-input>
								</b-col>

								<!-- <b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Unit Kerja Penanggung jawab"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.unit_pj"
											:id="'unit-pj'" 
											placeholder="Unit Kerja Penanggung jawab"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col> -->
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="klasifikasi-tier"
								label="Klasifikasi Tier">
								<b-col sm="6" v-if="!isDetail">
									<validation-provider name="Klasifikasi Tier" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="klasifikasi-tier"
											ref="klasifikasi-tier"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsKlasifikasiTier"
											v-model="model.klasifikasi_tier"
											label="kode_nama"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder=""
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
										v-model="model.klasifikasi_tier.kode_nama"
										:readonly="true">
									</b-form-input>
								</b-col>	
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tipe-pengamanan"
								label="Sistem/Tipe Pengamanan">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Sistem/Tipe Pengamanan"
										:debounce="250">					
										<b-form-textarea
											class="ml-2"
											:id="'tipe-pengamanan'" 
											v-model="model.tipe_pengamanan"
											placeholder="Sistem/Tipe Pengamanan"
											rows="3"
											max-rows="6"
											:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
											:readonly="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-jip"
								label="ID Metadata terkait (JIP)">
								<b-col sm="6">
									<validation-provider name="ID Metadata terkait (JIP)" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="id-metadata-jip"
											ref="id-metadata-jip"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsIdMetadataJip"
											v-model="model.id_metadata_jip"
											label="kode_nama"
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
										</m-select>   
										<div class="mt-1">ID Metadata dapat diisi lebih dari 1</div>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }} <br>
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
				</b-card>
			</section>
		</div>
	</div>
</template>

<script>
export default
{
	name: 'FasilitasKomputasiForm',
	components: { 
	},
	data(){
		return{			
			model: {				
				rai_level_1: [],
				rai_level_2: [],
				rai_level_3: [],
				rai_level_4: '',
				nama: '',
				deskripsi: '',
				instansi: [],
				kode_model_referensi: '',
				bandwidth_intranet: '',
				bandwidth_internet: '',
				lokasi: '',
				ownership: [],
				nama_pemilik: '',
				unit_pj: [],
				klasifikasi_tier: [],
				tipe_pengamanan: '',
				id_metadata_jip: [],
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,				
				other_pemilik : '',
			},
			optionsRaiLevel1: [],
			optionsRaiLevel2: [],
			optionsRaiLevel3: [],			
			optionsInstansi: [],	
			optionsPj: [],
			optionsKepemilikan:[
				{kode: "Milik Sendiri", kode_nama: "Milik Sendiri"},
				{kode: "Milik Instansi Pemerintah Lain", kode_nama: "Milik Instansi Pemerintah Lain"},
				{kode: "Milik BUMN", kode_nama: "Milik BUMN"},
				{kode: "Milik Pihak Ketiga - Dalam Negeri", kode_nama: "Milik Pihak Ketiga - Dalam Negeri"},
				{kode: "Milik Pihak Ketiga - Luar Negeri", kode_nama: "Milik Pihak Ketiga - Luar Negeri"}
			],		
			optionsKlasifikasiTier: [
				{kode: "Tier 1", kode_nama: "Tier 1"},
				{kode: "Tier 2", kode_nama: "Tier 2"},
				{kode: "Tier 3", kode_nama: "Tier 3"},
				{kode: "Tier 4", kode_nama: "Tier 4"},
			],
			optionsIdMetadataJip:[],
			optionsNamaPemilik: [],
			isDetail: false,
			isMilikSendiri: false,
			isKepemilikanLain: false,
			isNamaMilikLain: false,
			tempOpdId: this.$route?.params?.opd_id
		}
	},
	computed: { },
	watch: {
		// 'model.rai_level_1':{
		// 	handler: function(data){
		// 		this.resRal(data.kode,2).then((data) =>{this.optionsRaiLevel2 = data})
		// 	},
		// },		
		// 'model.rai_level_2':{
		// 	handler: function(data){	
		// 		this.resRal(data.kode,3).then((data) =>{this.optionsRaiLevel3 = data})
		// 	},
		// },
	},
	mounted:function(){ },
	created(){
		this.isDetail 		= (this.model.status == 'detail')?true:false
		this.resPerangkatDaerahOpd()

		this.resPerangkatDaerah().then((data) => {
			this.optionsInstansi= data
			this.model.instansi = (this.$app.user.is_admin && !this.model.status ) ? data.find(data => data.opd_id === this.tempOpdId) : this.isDetail ? '' : []
		})		

		/**Referensi Arsitektur Infrastruktur Level 1 */
		this.resRal('01',1).then((data) =>{
			this.optionsRaiLevel1 = data
			this.model.rai_level_1 = data[0]
		})

		/**Referensi Arsitektur Infrastruktur Level 2 */
		this.resRal('01',2).then((data) =>{this.optionsRaiLevel2 = data})

		this.resMetadata().then((data) =>{this.optionsIdMetadataJip = data})
		this.resDomainInfraNetdev()
	},
	methods :
	{				
		onBack() {
			this.$router.push({name: 'infrastruktur.fasilitas-komputasi', params: {
				opd_id: this.tempOpdId
			}})
		},	
		onSubmit(){
			let vm 			= this			
      		let routeName 	= vm.model.status ? 'fasilitas.update-data-domain-infra-fasilitas' : 'fasilitas.simpan-data-domain-infra-fasilitas'
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
							this.$router.push({name: 'infrastruktur.fasilitas-komputasi', params: {
								opd_id: this.tempOpdId
							}})
						})						
					}
				})
		},					
		async resDomainInfraNetdev(){
			const res = await this.$http.get(this.$app.route('fasilitas.search-intra-fasilitas.get', {id_fasilitas: this.model.id}))
			if(res.data){
				const rai2 = await this.resRal(res.data.kode_l01.split(' ')[0],2,res.data.kode_l02)
				const rai3 = await this.resRal(res.data.kode_l02.split(' ')[0],3,res.data.kode_l03)			

				this.model.id					= res.data.id
				this.tempOpdId					= res.data.opd_id
				this.model.rai_level_2 			= rai2[0]
				this.model.rai_level_3 			= rai3[0]
				this.model.rai_level_4			= res.data.kode_l04+' '+res.data.nama
				this.model.nama					= res.data.nama
				this.model.deskripsi 			= res.data.deskripsi
				this.model.instansi 			= this.optionsInstansi.find(data => data.opd_id === res.data.opd_id)
				this.model.kode_model_referensi = res.data.kode_model_referensi
				this.model.bandwidth_internet 	= res.data.bandwidth_internet
				this.model.bandwidth_intranet 	= res.data.bandwidth_intranet
				this.model.lokasi 				= res.data.lokasi
				this.model.ownership 			= res.data.ownership ? this.optionsKepemilikan.find(data => data.kode === res.data.ownership):({kode:'', kode_nama:''})

				if(this.model.ownership.kode != 'Milik Sendiri')
				{
					this.model.nama_pemilik 	= res.data.nama_pemilik	
				}
				if(this.model.ownership.kode == 'Milik Sendiri'){
					this.isMilikSendiri			= true
					this.model.nama_pemilik 	= res.data.nama_pemilik	
				}

				if(this.model.ownership.kode == 'Milik Instansi Pemerintah Lain'){	
					this.isKepemilikanLain		= true
					this.optionsNamaPemilik 	= await this.resPemlikInstansiLain()					
					const pemilikLain 			= this.optionsNamaPemilik.find(data => data.akronim === res.data.nama_pemilik)					

					if(typeof pemilikLain !== 'undefined'){
						this.model.nama_pemilik 	= this.isDetail? res.data.nama_pemilik : pemilikLain
						this.model.other_pemilik 	= ''
					}
					else{
						this.isNamaMilikLain		= true						
						this.model.nama_pemilik 	= this.isDetail? 'Lainnya' : this.optionsNamaPemilik.find(data => data.akronim === 'Lainnya')
						this.model.other_pemilik 	= res.data.nama_pemilik	
					}					
				}

				this.model.unit_pj 				= this.optionsPj.find(data => data.opd_id === res.data.unit_pj)	
				this.model.klasifikasi_tier 	= res.data.klasifikasi_tier ? this.optionsKlasifikasiTier.find(data => data.kode === res.data.klasifikasi_tier) : []
				this.model.tipe_pengamanan 		= res.data.tipe_pengamanan
				this.model.id_metadata_jip		= res.data.metadata_terkait
			}
		},	
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'rai'}))
			return res.data			
		},		
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('jaringan-intra-pemerintah.get-data-by.get', {col:'domain_code'}))
			return res.data			
		},	
		async resPerangkatDaerah(){
			const res 	= await this.$http.get(this.$app.route('jaringan-intra-pemerintah.data-perangkat-daerah-pemilik.get'))
			return res.data 
		},		
		async resPemlikInstansiLain(){
			const res 	= await this.$http.get(this.$app.route('fasilitas.data-perangkat-daerah-instansi-lain',{
				notOpdId : this.model.instansi.opd_id
			}))
			res.data.push({akronim:'Lainnya', nama_opd:'Lainnya', opd_id:'-', slug_path:'-'})
			return res.data 
		},	
		onChangeNamaPemilikan(){
			const data  			= this.model.nama_pemilik
			this.isNamaMilikLain 	= false

			if(this.model.nama_pemilik.akronim == 'Lainnya'){
				this.isNamaMilikLain 	= true
			}
		},
		onChangeKepemilikan(){
			const data 					= this.model.ownership
			this.isMilikSendiri 		= false
			this.isKepemilikanLain 		= false
			this.isNamaMilikLain 		= false
			this.model.nama_pemilik 	= ''
			this.model.other_pemilik	= ''
			this.tempOpdId				= this.model.instansi.opd_id

			console.log('data.kode : '+data.kode);
			if(data.kode == 'Milik Sendiri'	)
			{
				this.isMilikSendiri = true
				this.model.nama_pemilik = this.model.instansi.akronim
			}

			if(data.kode == 'Milik Instansi Pemerintah Lain')
			{
				this.isKepemilikanLain 	= true
				this.isMilikSendiri 	= false
				this.resPemlikInstansiLain().then((result) => {
					this.optionsNamaPemilik = result
				})
			}
		},				
		async resPerangkatDaerahOpd(dataOpdId = null){
			const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {}))
			this.optionsPj = res.data 
			return res.data 
		},	
		resRai2(data){
			this.model.rai_level_3 	= []
			this.optionsRaiLevel3	= []
			this.resRal(data?.kode,3).then((data) =>{this.optionsRaiLevel3 = data})
		},
	},
}
</script>

<style>
#app {
  margin: 20px;
}
</style>