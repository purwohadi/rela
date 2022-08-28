<template>
	<div class="row">
		<div class="col-12">
			<section id="jaringan-intra-pemerintah-form">						
				<b-card class="mb-4 mt-3 rounded">		
					<div class="col-12 mt-4">				
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
												:custom-label="nameRaiLevel"
												select-label=""
												selected-label=""
												deselect-label=""
												track-by="kode_nama"
												placeholder=""
												:searchable="true"
												:limit="100"
												:options-limit="100"			
												:allow-empty="false">     

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
									label-for="nama_jip"
									label="Nama Jaringan Intra Pemerintah">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Nama Jaringan Intra Pemerintah"
											:debounce="250">
											<b-form-input
												class="ml-2"
												v-model="model.nama_jip"
												:id="'nama-jip'" 
												placeholder="Nama Jaringan Intra Pemerintah"
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
									label-for="instansi1"
									label="Instansi 1">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Instansi 1"
											:debounce="250">
											<b-form-input
												class="ml-2"
												v-model="model.instansi_1"
												:id="'instansi1'" 
												placeholder="Instansi 1"
												:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
												:readonly="true">
											</b-form-input>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="instansi2"
									label="Instansi 2">
									<b-col sm="6" v-if="!isDetail">
										<validation-provider name="Instansi 2" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="instansi2"
												ref="instansi2"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsInstansi2"
												v-model="model.instansi_2"
												label="akronim"
												select-label=""
												selected-label=""
												deselect-label=""
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
											v-model="model.instansi_2.akronim"
											placeholder="Instansi 2"
											:readonly="isDetail">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="other-instansi2"
									label="Nama Instansi 2 Lainnya"
									v-show="instansiShow">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Nama Instansi 2 Lainnya"
											:debounce="250"
											v-if="instansiShow">
											<b-form-input
												class="ml-2"
												v-model="model.other_instansi2"
												:id="'other-instansi2'" 
												placeholder="Nama Instansi 2 Lainnya"
												:state="errors[0] ? false : (valid ? true : null)"
												:readonly="isDetail">
											</b-form-input>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="deskripsi-jaringan"
									label="Deskripsi Jaringan">
									<b-col sm="6">		
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Deskripsi Jaringan"
											:debounce="250">					
											<b-form-textarea
												class="ml-2"
												:id="'deskripsi-jaringan'" 
												v-model="model.deskripsi"
												placeholder="Deskripsi Jaringan"
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
									label-for="jenis-jaringan"
									label="Jenis Jaringan">
									<b-col sm="6" v-if="!isDetail">
										<validation-provider name="Jenis Jaringan" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="jenis-jaringan"
												ref="jenis-jaringan"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsJenisJaringan"
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
												:allow-empty="false">     

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
											v-model="model.jenis.kode"
											:readonly="isDetail">
										</b-form-input>
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
												:custom-label="nameRaiLevel"
												select-label=""
												selected-label=""
												deselect-label=""
												track-by="kode_nama"
												placeholder=""
												:searchable="true"
												:limit="100"
												:options-limit="100"			
												:allow-empty="false">     

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
											v-model="model.ownership.kode_nama"
											:readonly="isDetail">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="nama-pemilik"
									label="Nama Pemilik">
									<b-col sm="6" v-if="namaPemilikShow && !isDetail">
										<validation-provider name="Nama Pemilik" 
											rules="required" 
											v-slot="{ errors, ariaMsg }" 
											v-if="namaPemilikShow">
											<m-select
												id="nama-pemilik"
												ref="nama-pemilik"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsNamaPemilik"
												v-model="model.owner_name_arr"
												label="akronim"
												select-label=""
												selected-label=""
												deselect-label=""
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
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Nama Pemilik"
											:debounce="250"
											v-if="!namaPemilikShow || isDetail"> 
											<b-form-input
												class="ml-2"
												v-model="model.owner_name"
												placeholder="Nama Pemilik"
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
									label-for="other-pemilik"
									label="Nama Pemilik Lainnya"
									v-show="namaPemilikLainnyaShow">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Nama Pemilik Lainnya"
											:debounce="250"
											v-if="namaPemilikLainnyaShow">
											<b-form-input
												class="ml-2"
												v-model="model.other_pemilik"
												:id="'other-pemilik'" 
												placeholder="Nama Pemilik Lainnya"
												:state="errors[0] ? false : (valid ? true : null)"
												:readonly="isDetail">
											</b-form-input>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="unit-kerja-pengelola"
									label="Unit Kerja Pengelola">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Unit Kerja Pengelola"
											:debounce="250">
											<b-form-input
												class="ml-2"
												v-model="model.unit_oper"
												:id="'unit-kerja-pengelola'" 
												placeholder="Isi Dengan format OPD - Bidang/UPT/Sudin"
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
									label-for="bandwith"
									label="Bandwith">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Bandwidth"
											:debounce="250">
											<b-form-input
												class="ml-2"
												v-model="model.bandwith"
												:id="'bandwith'" 
												placeholder="Bandwith"
												:state="isDetail ? null :errors[0] ? false : (valid ? true : null)"
												:readonly="isDetail">
											</b-form-input>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>
								
								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="tipe-media-jaringan"
									label="Tipe Media Jaringan">
									<b-col sm="6" v-if="!isDetail">
										<validation-provider name="Tipe Media Jaringan" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="tipe-media-jaringan"
												ref="tipe-media-jaringan"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsMediaType"
												v-model="model.media_type"
												:custom-label="nameRaiLevel"
												select-label=""
												selected-label=""
												deselect-label=""
												track-by="kode_nama"
												placeholder=""
												:searchable="true"
												:limit="100"
												:options-limit="100"			
												:allow-empty="false">     

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
											v-model="model.media_type.kode_nama"
											:readonly="isDetail">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="other-media"
									label="Nama Media Lainnya"
									v-show="mediaShow">
									<b-col sm="6">
										<ValidationProvider
											rules="required"
											v-slot="{ valid, errors }"
											name="Nama Media Lainnya"
											:debounce="250"
											v-if="mediaShow">
											<b-form-input
												class="ml-2"
												v-model="model.other_media"
												:id="'other-media'" 
												placeholder="Nama Media Lainnya"
												:state="(errors[0]) ? false : (valid ? true : null)"
												:readonly="isDetail">
											</b-form-input>
											<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
										</ValidationProvider>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="primary-backup"
									label="Primary/Backup">
									<b-col sm="6" v-if="!isDetail">
										<validation-provider name="Primary/Backup" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="primary-backup"
												ref="primary-backup"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsPrimaryBackup"
												v-model="model.primary_backup"
												:custom-label="nameRaiLevel"
												select-label=""
												selected-label=""
												deselect-label=""
												track-by="kode_nama"
												placeholder=""
												:searchable="true"
												:limit="100"
												:options-limit="100"			
												:allow-empty="false">     

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
											v-model="model.primary_backup.kode_nama"
											:readonly="isDetail">
										</b-form-input>
									</b-col>
								</b-form-group>

								<b-form-group
									label-cols="2"
									label-cols-lg="2"
									label-for="id-metadata-terkait"
									label="ID Metadata Terkait (Fasilitas Komputasi)">
									<b-col sm="6">
										<validation-provider name="ID Metadata (Fasilitas Komputasi)" rules="required" v-slot="{ errors, ariaMsg }">
											<m-select
												id="id-metadata-terkait"
												ref="id-metada-terkait"
												class="mb-2"
												:option-height="73"
												:tabindex="7"
												:options="optionsIdMetadataTerkait"
												v-model="model.id_metadata_terkait"
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
			mediaShow: false,
			instansiShow: false,
			namaPemilikShow: false,
			namaPemilikLainnyaShow: false,
			model: {				
				nama_jip: '',
				rai_level_1: [],
				rai_level_2: [],
				rai_level_3: [],
				rai_level_4: [],
				instansi_1: 'Pemerintah Provinsi DKI Jakarta',
				instansi_2: [],
				deskripsi: '',
				jenis: [],
				ownership: [],
				owner_name: '',
				owner_name_arr: [],	
				other_pemilik: '',
				unit_oper: '',
				bandwith: '',
				media_type: [],
				other_media: '',
				primary_backup: [],
				id_metadata_terkait: [],
				id: this.$route?.params?.id,
				other_instansi2 : '',
				status: (this.$route?.params?.status) ? this.$route.params.status: '',
			},
			optionsProsesBisnis: [],
			optionsNamaPemilik: [],
			// optionsRaiLevel1: [],
			// optionsRaiLevel2: [],
			// optionsRaiLevel3: [],
			optionsRaiLevel4: [],	
			optionsInstansi2: [],			
			optionsJenisJaringan:[
				{kode: "intranet", kode_nama: "Intranet"},
				{kode: "Internet", kode_nama: "Internet"},
				{kode: "SDWAN", kode_nama: "sdwan"}
			],
			optionsKepemilikan:[
				{kode: "Milik Sendiri", kode_nama: "Milik Sendiri"},
				{kode: "Milik Instansi Pemerintah Lain", kode_nama: "Milik Instansi Pemerintah Lain"},
				{kode: "Milik BUMN", kode_nama: "Milik BUMN"},
				{kode: "Milik Pihak Ketiga - Dalam Negeri", kode_nama: "Milik Pihak Ketiga - Dalam Negeri"},
				{kode: "Milik Pihak Ketiga - Luar Negeri", kode_nama: "Milik Pihak Ketiga - Luar Negeri"}
			],
			optionsMediaType:[
				{kode: "Fiber Optic", kode_nama: "Fiber Optic"},
				{kode: "Coaxial", kode_nama: "Coaxial"},
				{kode: "Wireless Microwave", kode_nama: "Wireless Microwave"},
				{kode: "VSAT", kode_nama: "VSAT"},					
				{kode: "Lainnya", kode_nama: "Lainnya"}
			],
			optionsPrimaryBackup:[
				{kode: "1", kode_nama: "1 (Primary)"},
				{kode: "2", kode_nama: "2 (Secondary)"}
			],
			optionsIdMetadataTerkait:[],
			isDetail: false,
		}
	},
	computed: { },
	watch: {	
		'model.owner_name_arr':{
			handler: function(data){	
				this.namaPemilikLainnyaShow = (data.akronim == 'Lainnya')?true:false
			},
		},			
		'model.ownership':{
			handler: function(data){	
				if(this.model.status == ''){
					this.namaPemilikShow 		= false
					this.namaPemilikLainnyaShow = false
					this.model.owner_name		= null
					this.optionsNamaPemilik 	= []
					this.model.owner_name_arr 	= []
					this.model.other_pemilik 	= null
				}
				
				if(data.kode == 'Milik Sendiri'){
					this.resPerangkatDaerahPemilik().then((dataPerangkat) => {
						this.optionsNamaPemilik 	= dataPerangkat
						// if(this.model.status == '') this.model.owner_name_arr 	= dataPerangkat[0]
					})					
					this.namaPemilikShow 			= true
				}
				else{
					this.namaPemilikShow 			= false
				}
			},
		},	
		'model.instansi_2':{
			handler: function(data){	
				this.instansiShow = (data.akronim == 'Lainnya')?true:false
			},
		},
		'model.media_type':{
			handler: function(data){	
				this.mediaShow = (data.kode == 'Lainnya')?true:false
			},
		},
	},
	mounted:function(){ },
	created(){	
		this.resPerangkatDaerah().then((data) => {
			this.optionsInstansi2	= data
			// this.model.instansi_2 	= data[0]
		})
		this.resPerangkatDaerahPemilik().then((data) => {
			this.optionsNamaPemilik	= data
			// this.model.owner_name_arr 	= data[0]
		})
		this.resRal('02',1).then((data) =>{this.model.rai_level_1 = data[0]})
		this.resRal('02.01',2).then((data) =>{this.model.rai_level_2 = data[0]})
		this.resRal('02.01.03',3).then((data) =>{this.model.rai_level_3 = data[0]})
		this.resRal('02.01.03',4).then((data) =>{this.optionsRaiLevel4 = data})			
		this.resFasilitas().then((data) => {this.optionsIdMetadataTerkait = data})
		if(this.model?.status){			
			this.resDomainInfraJip()
			this.isDetail = (this.model.status == 'detail')?true:false	
		}
	},
	methods :
	{				
		onBack() {
			this.$router.go(-1)
		},	
		onSubmit(){
			let vm 			= this			
      		let routeName 	= vm.model.status ? 'jaringan-intra-pemerintah.update-data-domain-infra-jip' : 'jaringan-intra-pemerintah.simpan-data-domain-infra-jip'
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
						})
						.then(response => {
							vm.$bvModal.hide(vm.modal)
							this.$router.go(-1)
						})
					}
				})
		},					
		async resDomainInfraJip(){
			const res = await this.$http.get(this.$app.route('jaringan-intra-pemerintah.search-intra-pemerintah.get', {id_intra: this.model.id}))
			if(res.data){			
				this.model.id					= res.data.id
				this.model.nama_jip 			= res.data.nama_jip
				const rai4 						= await this.resRal(res.data.rai_level_3.split(' ')[0],4,res.data.rai_level_4)
				this.model.rai_level_4 			= rai4[0] ? rai4[0]:{kode: '', kode_nama: ''}

				/**Instansi 2 */
				if(res.data.opd_id_2 === null ) 
				{
					this.instansiShow			= true
					this.model.instansi_2 		= {akronim:'Lainnya', nama_opd:'Lainnya', opd_id:'-', slug_path:'-'}					
					this.model.other_instansi2 = res.data.opd_2_lainnya
				}
				if(res.data.opd_id_2 !== null ) 
				{
					const resPerangkatDaerahByOpdId = await this.resPerangkatDaerahByOpdId(res.data.opd_id_2)				
					this.model.instansi_2 = resPerangkatDaerahByOpdId
				}
				/**end instansi 2 */

				this.model.deskripsi 			= res.data.deskripsi
				this.model.jenis 				= this.optionsJenisJaringan ? this.optionsJenisJaringan.find(data => data.kode === res.data.jenis) : {kode:'',kode_nama:''}

				this.model.ownership 			= this.optionsKepemilikan ? this.optionsKepemilikan.find(data => data.kode === res.data.ownership): {kode:'',kode_nama:''}

				/**Kepemilikan */
				if(res.data.ownership == 'Milik Sendiri'){
					const nama_kepemilikan		= this.optionsInstansi2.find(data => data.akronim === res.data.owner_name)
					
					if(nama_kepemilikan === undefined){
						this.namaPemilikLainnyaShow	= true
						this.model.other_pemilik 	= res.data.owner_name
						this.model.owner_name_arr 	= {akronim:'Lainnya', nama_opd:'Lainnya', opd_id:'-', slug_path:'-'}
						this.model.owner_name		= 'Lainnya'
						this.model.other_pemilik	= res.data.owner_name
					}				
					else{
						this.namaPemilikShow		= true
						this.model.owner_name 		= nama_kepemilikan.akronim
						this.model.owner_name_arr 	= nama_kepemilikan
					}	
				}
				if(res.data.ownership != 'Milik Sendiri'){
					this.model.owner_name 	= res.data.owner_name
				}
				/**end Kepemilikan */

				this.model.unit_oper 			= res.data.unit_oper
				this.model.bandwith 			= res.data.bandwith
				this.model.media_type 			= this.optionsMediaType.find(data => data.kode === res.data.media_type)
				this.model.other_media 			= res.data.other_media
				this.model.primary_backup 		= res.data.primary_backup? this.optionsPrimaryBackup.find(data => data.kode === res.data.primary_backup):{kode: '', kode_nama: ''}
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
		nameRaiLevel({kode_nama}){
			return `${kode_nama}`
		},
		async resPerangkatDaerah(){
			const res 				= await this.$http.get(this.$app.route('jaringan-intra-pemerintah.data-perangkat-daerah.get', {}))
			res.data.push({akronim:'Lainnya', nama_opd:'Lainnya', opd_id:'-', slug_path:'-'})
			return res.data 
		},				
		async resPerangkatDaerahPemilik(){
			const res 				= await this.$http.get(this.$app.route('jaringan-intra-pemerintah.data-perangkat-daerah-pemilik.get', {}))
			res.data.push({akronim:'Lainnya', nama_opd:'Lainnya', opd_id:'-', slug_path:'-'})
			return res.data 
		},	
		async resPerangkatDaerahByOpdId(dataOpdId){
			const res = await this.$http.get(this.$app.route('jaringan-intra-pemerintah.data-perangkat-daerah.get', {opd_id:dataOpdId}))
			return res.data[0]
		},			
		async resFasilitas(dataIdMetadataTerkait=null){
			const res = await this.$http.get(this.$app.route('jaringan-intra-pemerintah.get-domain-code.get', {col:'domain_code', id_metadata_terkait:dataIdMetadataTerkait}))
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