<template>
	<div class="row">
		<div class="col-12">
			<section id="perangkat-keamanan-form">						
				<b-card class="mb-4 mt-3 p-4 rounded">						
					<b-row>
						<b-col lg="12" md="12" sm="12" class="text-right" v-if="isDetail"> 
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
								label-for="rai_level_1"
								label="Referensi Arsitektur Keamanan Level 1">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Referensi Arsitektur Keamanan Level 1"
										:debounce="250">
										<b-form-input
											v-model="model.rai_level_1"
											maxlength="20"
											:id="'rai_level_1'" 
											placeholder="Referensi Arsitektur Keamanan Level 1"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="true">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai_level_2"
								label="Referensi Arsitektur Keamanan Level 2">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Referensi Arsitektur Keamanan Level 2"
										:debounce="250">
										<b-form-input
											v-model="model.rai_level_2"
											maxlength="20"
											:id="'rai_level_2'" 
											placeholder="Referensi Arsitektur Keamanan Level 2"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="true">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai_level_3"
								label="Referensi Arsitektur Keamanan Level 3">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Referensi Arsitektur Keamanan Level 3"
										:debounce="250">
										<b-form-input
											v-model="model.rai_level_3"
											maxlength="20"
											:id="'rai_level_3'" 
											placeholder="Referensi Arsitektur Keamanan Level 3"
											:state="errors[0] ? false : (valid ? true : null)"
											:readonly="true">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai_level_4"
								label="Referensi Arsitektur Keamanan Level 4">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Keamanan 4" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="rai_l4"
											ref="rai_l4"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel4"
											v-model="rai_l4_selected"
											label="kode_nama"
											placeholder="Referensi Arsitektur Keamanan Level 4"
											track-by="kode_nama"
											:searchable="true"			
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
										<b-form-input
											v-else
											v-model="model.rai_level_4"
											:disabled="true">
										</b-form-input>

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
								label="Nama Perangkat Keamanan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Perangkat Keamanan"
										:debounce="250">
										<b-form-input
											v-model="model.nama"
											:id="'nama'" 
											placeholder="Nama Perangkat Keamanan"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
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
								<b-col sm="6">
									<validation-provider name="Nama Instansi" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="instansi"
											v-model="model.opd"
											:disabled="true">
										</b-form-input>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>
							
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="jenis"
								label="Jenis Perangkat Keamanan">
								<b-col sm="6">
									<validation-provider name="Jenis Perangkat Keamanan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="jenis"
											ref="jenis"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsJenisPerangkat"
											v-model="model.jenis"
											select-label=""
											selected-label=""
											deselect-label=""
											placeholder="Pilih Jenis Perangkat Keamanan"
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
													<span class="text-wrap">{{ option }}</span>
												</div>
											</template>
										</m-select> 
										<b-form-input
											v-else
											v-model="model.jenis"
											:disabled="true">
										</b-form-input>  

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>

                            <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="tipe"
								label="Tipe Perangkat Keamanan">
								<b-col sm="6">
									<validation-provider name="Tipe Perangkat Keamanan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="tipe"
											ref="tipe"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsTipePerangkat"
											v-model="model.tipe"
											placeholder="Pilih Tipe Perangkat Keamanan"
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
													<span class="text-wrap">{{ option }}</span>
												</div>
											</template>
										</m-select>
										<b-form-input
											v-else
											v-model="model.tipe"
											:disabled="true">
										</b-form-input>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="deskripsi"
								label="Deskripsi Perangkat Keamanan">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Deskripsi Perangkat Keamanan"
										:debounce="250">					
										<b-form-textarea
											:id="'deskripsi'" 
											v-model="model.deskripsi"
											placeholder="Deskripsi Perangkat Keamanan"
											rows="3"
											max-rows="6"
            								:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
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
								<b-col sm="6">
									<validation-provider name="Kepemilikan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="kepemilikan"
											ref="kepemilikan"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsKepemilikan"
											v-model="model.kepemilikan"
											placeholder="Pilih Kepemilikan"
											:searchable="true"
											:allow-empty="false"
											:disabled="isDetail"
										> 
										</m-select>
										<b-form-input
											v-else
											v-model="model.kepemilikan"
											:disabled="true">
										</b-form-input>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="Pemilik"
								label="Nama Pemilik">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Pemilik"
										:debounce="250">
										<m-select
											v-if="model.kepemilikan == 'Milik Instansi Pemerintah Lain'"
											id="perangkat-daerah"
											ref="perangkat-daerah"
											:option-height="73"
											:tabindex="7"
											:placeholder="'--pilih perangkat daerah--'"
											:options="optionsPerangkatDaerah"
											v-model="perangkatDaerah"
											label="nama_opd"
											track-by="nama_opd"
											:searchable="true"
											:limit="100"
											:options-limit="100"
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
													<span class="text-wrap">{{ option.nama_opd }}</span>
												</div>
											</template>
										</m-select>
										<b-form-input
											v-else
											v-model="model.pemilik"
											:id="'pemilik'" 
											placeholder="Masukkan Nama Pemilik"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail || model.kepemilikan == 'Milik Sendiri'">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								v-if="model.kepemilikan == 'Milik Instansi Pemerintah Lain' && model.pemilik == 'Lainnya'"
								label-cols="2"
								label-cols-lg="2"
								label-for="other_pemilik"
								label="Nama Pemilik (Instansi Lainnya)">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Pemilik (Instansi Lainnya)"
										:debounce="250">
										<b-form-input
											v-model="model.other_instansi"
											:id="'other_pemilik'" 
											placeholder="Nama Pemilik (Instansi Lainnya)"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
														
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="pengelola"
								label="Unit Kerja Pengelola">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Unit Kerja Pengelola"
										:debounce="250">
										<b-form-textarea
											v-model="model.pengelola"
											:id="'pengelola'" 
											placeholder="Isi Dengan format OPD - Bidang/UPT/Sudin"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="keterangan"
								label="Keterangan Perangkat Keamanan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Keterangan Perangkat Keamanan"
										:debounce="250">
										<b-form-textarea
											v-model="model.keterangan"
											:id="'keterangan'" 
											placeholder="Keterangan Perangkat Keamanan"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="asal"
								label="Asal Perolehan">
								<b-col sm="6">
									<validation-provider name="Asal Perolehan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="asal"
											ref="asal"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsAsal"
											v-model="model.asal"
											placeholder="Pilih Asal Perolehan"
											:searchable="true"
											:allow-empty="false"
											:disabled="isDetail"
										> 
										</m-select>
										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>

							<b-form-group
								v-if="model.asal == 'Lainnya'"
								label-cols="2"
								label-cols-lg="2"
								label-for="deskripsi_asal"
								label="Deskripsi Asal"
							>
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Deskripsi Asal"
										:debounce="250">					
										<b-form-textarea
											:id="'deskripsi_asal'" 
											v-model="model.deskripsi_asal"
											placeholder="Deskripsi Asal"
											rows="3"
											max-rows="6"
            								:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!-- :custom-label="nameSelected" -->
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-terkait"
								label="ID Metadata Terkait (Fasilitas Komputasi)">
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
											placeholder="Pilih ID Metadata Terkait"
											:searchable="true"
											:limit="100"
											:options-limit="100"			
											:allow-empty="true"
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
													<span class="text-wrap">{{ option.kode }} - {{ option.kode_nama }}</span>
												</div>
											</template>
										</m-select>   

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>	
							</b-form-group>

							<div class="text-right mt-4 pt-3" v-if="!isDetail">
								<b-button type="submit" variant="primary" class="mr-2">
									<i class="fal fa-save"></i>
									{{ $t('general.form.button_add') }}
								</b-button>
								<b-button ref="closebtn" variant="default" @click="$router.go(-1)">
									{{ $t('general.form.button_cancel') }}
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
	name: 'PerangkatKeamananForm',
	components: { 
	},
	data(){
		return{				
			model: {		
				opd_id: null,		
				nama: '',
				deskripsi: '',
				deskripsi_asal: '',
				rai_level_1: '03 Platform',
				rai_level_2: '03.01 Kerangka Infrastruktur dan Aplikasi',
				rai_level_3: '03.01.04 Perangkat Keras Keamanan',
				rai_level_4: '',
				opd: null,
				opd_akronim: '',
				jenis: null,
				tipe: null,
				id_metadata_terkait: [],
				pemilik: '',
				kepemilikan: '',
				pengelola: '',
				keterangan: '',
				asal: null,
				deskripsi_asal: null,
				other_instansi: null,
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			optionsProsesBisnis: [],
			optionsIdMetadataTerkait:[],
			optionsRaiLevel4: [],
			rai_l4_selected: null,
			perangkatDaerah: null,
			optionsJenisPerangkat:['Perangkat Lunak', 'Perangkat Keras'],
            optionsTipePerangkat:["Firewall", "Intrusion Detection System", "Intrusion Prevention System",
			"Proxy", "Load Balancer", "Wireless intrusion prevention and detection system", "Unified Threat Management",
			"Network Access Control", "Antivirus", "WAF", "VPN"],
			optionsKepemilikan:[
				"Milik Sendiri", 
				"Milik Instansi Pemerintah Lain", 
				"Milik BUMN", 
				"Milik Pihak Ketiga - Dalam Negeri",
				"Milik Pihak Ketiga - Luar Negeri"
			],
			optionsAsal:["APBD", "APBN", "Lainnya"],
			isDetail: false,
			optionsPerangkatDaerah: [],

		}
	},
	computed: { },
	watch: {
		'rai_l4_selected':{
			handler: function(data){	
				if (data) {
					this.model.rai_level_4 = data.kode_nama
				}
			},
		},
		'model.kepemilikan':{
			handler: function(data){	
				if (data) {
					if(data == 'Milik Sendiri') {
						console.log('masuk sini', this.model.opd_akronim);
						this.model.pemilik = this.model.opd_akronim
					} else if (data == 'Milik Instansi Pemerintah Lain') {
						this.resPerangkatDaerah()
					}
				}
			},
		},
		'perangkatDaerah': {
			handler: function(n, o) {
				if (!_.isEmpty(n)) {
					this.model.pemilik = n.akronim				
				}
			},
		}
	},
	mounted (){ 
		let query_opd = this.$route.params.opd_id ? this.$route.params.opd_id : this.$app.user.opd_id
		this.model.opd_id = query_opd
		this.resPerangkatDaerahById().then(() => {
			this.resMetadata().then((data) => {
				this.optionsIdMetadataTerkait = data
				if (this.model.status != 'add') {
					this.resDomainInfraKeamanan()
				}
			})

			
		})
	},
	created(){
		this.isDetail = this.model.status == 'detail'
		
		if (this.model.status == 'add') {
			this.resRal(4).then((data) =>{this.optionsRaiLevel4 = data})
		}
	},
	methods :
	{				
		onBack() {
			this.$router.go(-1)
		},
		async resPerangkatDaerah(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {})).then((res) => {
				this.optionsPerangkatDaerah = res.data.filter((data) => {
					return data.opd_id != this.model.opd_id 
				})
				this.optionsPerangkatDaerah.push({
					akronim: 'Lainnya',
					nama_opd: 'Lainnya',
					opd_id: '',
					slug_path: ''
				})
				
			})
		},	
		async resPerangkatDaerahById(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.model.opd_id})).then((res) => {
				if (res.data[0]) {
					this.model.opd = res.data[0].nama_opd
					this.model.opd_akronim = res.data[0].akronim
				}
			})
		},
		onSubmit(){
			let vm 			= this			
      		let routeName 	= vm.model.status == 'edit' ? 'perangkat-keamanan.update-data-domain-infra-keamanan' : 'perangkat-keamanan.simpan-data-domain-infra-keamanan'
			let url 		= vm.$app.route(routeName)
			let frm 		= new FormData()
			let data = Object.assign({}, vm.model)

			data.pemilik = data.pemilik == 'Lainnya' ? data.other_instansi : data.pemilik
			data.rai_level_1 = data.rai_level_1.split(' ')[0]
			data.rai_level_2 = data.rai_level_2.split(' ')[0]
			data.rai_level_3 = data.rai_level_3.split(' ')[0]
			data.rai_level_4 = data.rai_level_4.split(' ')[0]

			let formData 	= vm.$app.objectToFormData(data, frm)

			///*
			let method ='post'
			vm.$app.confirm({
				text: `Apakah anda yakin akan menambah Perangkat Keamanan ${this.model.nama}?`,
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
			//*/
		},					
		async resDomainInfraKeamanan(){
			this.$http.get(this.$app.route('perangkat-keamanan.search-infra-keamanan.get', {id_infra: this.model.id})).then((res) => {
				if(res.data){
					this.model.id					= res.data.id //nama field tabel
					this.model.nama 				= res.data.nama
					this.model.rai_level_1 			= res.data.rai_level_1_nama
					this.model.rai_level_2 			= res.data.rai_level_2_nama
					this.model.rai_level_3 			= res.data.rai_level_3_nama
					this.model.rai_level_4 			= res.data.rai_level_4_nama

					this.resRal(4).then((data) =>{
						this.optionsRaiLevel4 = data
						this.rai_l4_selected = this.optionsRaiLevel4.find(data => data.kode === res.data.rai_level_4)

					})

					this.model.deskripsi 			= res.data.deskripsi
					this.model.deskripsi_asal 		= res.data.deskripsi_asal
					this.model.jenis 				= res.data.jenis
					this.model.kepemilikan 			= res.data.status_ownership
	
					
					if (this.model.kepemilikan == 'Milik Instansi Pemerintah Lain') {
						this.resPerangkatDaerah().then(() => {
							this.perangkatDaerah = this.optionsPerangkatDaerah.find(data => data.akronim === res.data.nama_owner)
							if (!this.perangkatDaerah) {
								this.perangkatDaerah = this.optionsPerangkatDaerah.find(data => data.opd_id === '')
								this.model.other_instansi = res.data.nama_owner
							}
						})
					} else {
						this.model.pemilik =  res.data.nama_owner
					}
					
					this.model.pengelola	 		= res.data.unit_pengelola
					this.model.tipe 				= res.data.tipe
					this.model.keterangan 			= res.data.keterangan
					this.model.asal			 		= res.data.asal

					let domain_code_arr = res.data.id_metadata_terkait.map(val => val.domain_terkait_code)

					this.model.id_metadata_terkait = this.optionsIdMetadataTerkait.filter((val) => {
						return domain_code_arr.includes(val.kode)
					})
	
				}
			})
		},		
		nameProsesBisnis ({proses_id}) {
			return `${proses_id}`
		},	
		async resRal(tingkat, kode_nama=''){
			let kode_lv3_infra_keamanan = '03.01.04'
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode_lv3_infra_keamanan, tingkat: tingkat, kode_nama:kode_nama, kategori:'rai'}))
			return res.data			
		},
		async resOpd(){
			const res = await this.$http.get(this.$app.route('opd.data'))
			return res.data
			/*
			
			//return opd
			//console.log(res.data[2]['opd_id'])
			
			$.each( res.data, function( kode, value ) {
				console.log(  " kode : " + value.opd_id);
			});

			*/
		},
		nameRaiLevel({kode_nama}){
			return `${kode_nama}`
		},
		nameSelected({kode, kode_nama}){
			return `${kode} - ${kode_nama}`
		},
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('perangkat-keamanan.get-metadata'))
			return res.data			
		},
	},
}

//console.log(resOpd())

</script>

<style>
#app {
  margin: 20px;
}
</style>