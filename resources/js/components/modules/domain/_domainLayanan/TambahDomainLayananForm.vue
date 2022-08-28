<template>
	<div class="row">
		<div class="col-12">
			<section id="tambah-domain-layanan-form">						
				<b-card class="mb-4 mt-3 rounded">	 				
					<ValidationObserver v-slot="{ passes }" :slim="true">
						<form @submit.prevent="passes(onSubmit)">									
							<div class="panel">
								<div class="col-12">									
									<!-- <div class="panel-hdr mb-3">
										<h2  class="fs-xl">
											<div class="col-6">
												<i  class="fal fa-th-list mr-2"></i> 
												<i >Tambah <span class="fw-300">Layanan</span></i>
											</div>
											<div class="col-6">
												<b-row>
													<b-col lg="12" md="12" sm="12" class="text-right"> 
														<button
															type="button"
															style="margin: 10px 15px 0px;"
															class="btn btn-danger btn-sm rounded waves-effect waves-themed mb-3"
															v-b-tooltip.hover.top="$t('general.button.back')"
															@click="onBack">
															<i class="fal fa-arrow-circle-left"></i> 
															{{ $t('general.button.back') }}
														</button>
													</b-col>
												</b-row>
											</div>
										</h2>
									</div> -->

									<template>	
										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="opd-id"
											label="OPD ID"
											v-show="false">
											<b-col sm="6">
												<b-form-input
													class="ml-2"
													v-model="model.opd_id"
													:id="'opd-id'" 
													placeholder="OPD ID"
													:readonly="true">
												</b-form-input>
											</b-col>
										</b-form-group>

										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="unit-kerja"
											label="Perangkat Daerah">
											<b-col sm="6">
												<b-form-input
													class="ml-2"
													v-model="model.unit_kerja"
													:id="'unit-kerja'" 
													placeholder="Perangkat Daerah"
													:readonly="true">
												</b-form-input>
											</b-col>
										</b-form-group>
										
										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="ral-level_1"
											label="Referensi Arsitektur Layanan Level 1">
											<b-col sm="6">
												<validation-provider name="Referensi Arsitektur Layanan Level 1" rules="required" v-slot="{ errors, ariaMsg }">
													<m-select
														id="ral-level_1"
														ref="ral-level_1"
														class="mb-2"
														:option-height="73"
														:tabindex="7"
														:options="optionsRalLevel1"
														v-model="model.ral_level_1"
														:custom-label="nameRalLevel"
														select-label=""
														selected-label=""
														deselect-label=""
														track-by="kode_nama"
														placeholder=""
														:searchable="true"
														:limit="100"
														:options-limit="100"			
														:allow-empty="false"
														:disabled="isDetail"
														@input="(val) => (resRal1(val))">     

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
											label-for="ral-level_2"
											label="Referensi Arsitektur Layanan Level 2">
											<b-col sm="6">
												<validation-provider name="Referensi Arsitektur Layanan Level 2" rules="required" v-slot="{ errors, ariaMsg }">
													<m-select
														id="ral-level_2"
														ref="ral-level_2"
														class="mb-2"
														:option-height="73"
														:tabindex="7"
														:options="optionsRalLevel2"
														v-model="model.ral_level_2"
														:custom-label="nameRalLevel"
														select-label=""
														selected-label=""
														deselect-label=""
														track-by="kode_nama"
														placeholder=""
														:searchable="true"
														:limit="100"
														:options-limit="100"			
														:allow-empty="false"
														:disabled="isDetail"
														@input="(val) => (resRal2(val))">     

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
											label-for="ral-level_3"
											label="Referensi Arsitektur Layanan Level 3">
											<b-col sm="6">
												<validation-provider name="Referensi Arsitektur Layanan Level 3" rules="required" v-slot="{ errors, ariaMsg }">
													<m-select
														id="ral-level_3"
														ref="ral-level_3"
														class="mb-2"
														:option-height="73"
														:tabindex="7"
														:options="optionsRalLevel3"
														v-model="model.ral_level_3"
														:custom-label="nameRalLevel"
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
										</b-form-group>

										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="nama_layanan"
											label="Nama Layanan">
											<b-col sm="6">
												<ValidationProvider
													rules="required"
													v-slot="{ valid, errors }"
													name="Nama Layanan"
													:debounce="250">
													<b-form-input
														class="ml-2"
														v-model="model.nama_layanan"
														:id="'nama-layanan'" 
														placeholder="Nama Layanan"
														:state="errors[0] ? false : (valid ? true : null)"
														:readonly="isDetail"
														@input="(val) => (model.nama_layanan = model.nama_layanan.toUpperCase())">
													</b-form-input>
													<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
												</ValidationProvider>
											</b-col>
										</b-form-group>

										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="tujuan-layanan"
											label="Tujuan Layanan">
											<b-col sm="6">		
												<ValidationProvider
													rules="required"
													v-slot="{ valid, errors }"
													name="Tujuan Layanan"
													:debounce="250">					
													<b-form-textarea
														class="ml-2"
														:id="'tujuan-layanan'" 
														v-model="model.tujuan_layanan"
														placeholder="Tujuan Layanan"
														rows="3"
														max-rows="6"
														:state="errors[0] ? false : (valid ? true : null)"
														:readonly="isDetail">
													</b-form-textarea>
													<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
												</ValidationProvider>
											</b-col>
										</b-form-group>
										
										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="proses-bisnis"
											label="Proses Bisnis">
											<b-col sm="6">
												<validation-provider name="Proses Bisnis" rules="required" v-slot="{ errors, ariaMsg }">
													<m-select
														id="proses-bisnis"
														ref="proses-bisnis"
														class="mb-2"
														:option-height="73"
														:tabindex="7"
														:options="optionsProsesBisnis"
														v-model="model.prosesBisnis"
														select-label=""
														selected-label=""
														deselect-label=""
														track-by="proses_id"
														placeholder=""
														:searchable="true"
														:limit="100"
														:options-limit="100"	
														:disabled="isDetail"
														:multiple="true"
														:custom-label="nameProbis"
														:taggable="true"										
														:close-on-select="false" 
														:clear-on-select="false" >     

														<template #noOptions>
															Tidak ada data
														</template>
														<template #noResult>
															Data tidak ditemukan
														</template>

														<template #option="{ option }">
															<div class="d-flex align-items-baseline mb-1">
																<i class="fal fa-laptop mr-2"></i>
																<span class="text-wrap">
																	<!-- {{ option.proses_id + ' ('+option.rab_level4+')'}} -->
																	{{ option.kode_lev4+' '+option.rab_level4}}
																</span>
															</div>
														</template>
													</m-select>  

													<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
														{{ errors[0] }}
													</small>
												</validation-provider>
											</b-col>	
										</b-form-group>
									</template>
								</div>
							</div> 	

							<div class="panel">
								<div class="col-12">
									<div class="panel-hdr mb-3">
										<h2  class="fs-xl">
											<i  class="fal fa-th-list mr-2"></i> 
											<i >Detail <span class="fw-300">Layanan</span></i>
										</h2>
									</div>
									
									<template>	
										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="fungsi-layanan"
											label="Fungsi Layanan">
											<b-col sm="6">		
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
														:state="errors[0] ? false : (valid ? true : null)"
														:readonly="isDetail">
													</b-form-textarea>
													<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
												</ValidationProvider>
											</b-col>
										</b-form-group>
										
										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="pelaksana-level1"
											label="Unit Pelaksana Level 1 (Eselon 3)">
											<b-col sm="6" v-if="!isDetail">
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
											<b-col sm="6" v-else>
												<b-form-input
													class="ml-2"	
													v-model="model.pelaksana_level1.najabl"
													placeholder="Unit Pelaksana Level 1 (Eselon 3)"
													:readonly="isDetail || !$app.user.is_admin">
												</b-form-input>
											</b-col>

											<!-- <b-col sm="6">		
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
														:state="errors[0] ? false : (valid ? true : null)"
														:readonly="isDetail">
													</b-form-textarea>
													<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
												</ValidationProvider>
											</b-col> -->
										</b-form-group>

										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="pelaksana-level2"
											label="Unit Pelaksana Level 2 (Eselon 4)">
											<b-col sm="6" v-if="!isDetail">
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
											<b-col sm="6" v-else>
												<b-form-input
													class="ml-2"	
													v-model="model.pelaksana_level2.najabl"
													placeholder="Unit Pelaksana Level 2 (Eselon 4)"
													:readonly="isDetail || !$app.user.is_admin">
												</b-form-input>
											</b-col>
											<!-- <b-col sm="6">		
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
														:state="errors[0] ? false : (valid ? true : null)"
														:readonly="isDetail">
													</b-form-textarea>
													<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
												</ValidationProvider>
											</b-col> -->
										</b-form-group>

										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="target-layanan"
											label="Target Layanan">
											<b-col sm="6">		
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
														:state="errors[0] ? false : (valid ? true : null)"
														:readonly="isDetail">
													</b-form-textarea>
													<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
												</ValidationProvider>
											</b-col>
										</b-form-group>
										
										<b-form-group
											label-cols="2"
											label-cols-lg="2"
											label-for="delegasi"
											label="Unit Pendelegasian Kewenangan">
											
											<b-col sm="6" v-if="!isDetail">
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
											<b-col sm="6" v-else>
												<b-form-input
													class="ml-2"	
													v-model="model.instansi"
													placeholder="Unit Pendelegasian Kewenangan"
													:readonly="isDetail || !$app.user.is_admin">
												</b-form-input>
											</b-col>
										</b-form-group>
									</template>
								</div>
							</div>
							<div class="text-right mt-4 mb-4">
								<b-col sm="7">	
									<b-button type="submit" variant="primary" v-show="!isDetail">
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
	name: 'TambahDomainLayananForm',
	components: { 
	},
	data(){
		return{				
			model: {
				prosesBisnis: [],
				opd_id: '',
				unit_kerja: '',
				ral_level_1: [],
				ral_level_2: [],
				ral_level_3: [],
				nama_layanan: '',
				tujuan_layanan: '',
				fungsi_layanan: '',
				// pelaksana_level1: '',				
				// pelaksana_level2: '',
				pelaksana_level1: [],
				pelaksana_level2: [],
				target_layanan: '',
				delegasi: [],	
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			optionsProsesBisnis: [],
			optionsRalLevel1: [],
			optionsRalLevel2: [],
			optionsRalLevel3: [],
			optionsDelegasi: [],	
			optionsPelaksanaLevel1: [{'kojab': '', 'najabl': '', 'kojab_atasan': ''}],
			optionsPelaksanaLevel2: [{'kojab': '', 'najabl': '', 'kojab_atasan': ''}],
			// opd_id: (this.$app.user.is_admin)?this.$route.params.opd_id:this.$app.user.opd_id,
			opd_id: this.$route.params.opd_id,
			isDetail:  (this.$route?.params?.status == 'lihat')?true:false,	
		}
	},
	computed: { },
	watch: {
		// 'model.ral_level_1':{
		// 	handler: function(data){
		// 		this.model.ral_level_2 = []
		// 		this.resRal(data?.kode,2).then((data) =>{this.optionsRalLevel2 = data})
		// 	},
		// },		
		// 'model.ral_level_2':{
		// 	handler: function(data){	
		// 		this.model.ral_level_3 = []
		// 		this.resRal(data?.kode,3).then((data) =>{this.optionsRalLevel3 = data})
		// 	},
		// },
	},
	mounted:function(){ },
	created(){
		// this.resDomainLayanan()
		// this.isDetail = (this.model.status == 'detail')?false:true		
		this.resPerangkatDaerahBySlug()
		this.resPerangkatDaerahOpd()
		this.resRal('',1).then((data) =>{this.optionsRalLevel1 = data})
		
	},
	methods :
	{				
		onBack() {
			// this.$router.go(-1)
			this.$router.push({name: 'domain.domain-layanan', params: {
				opd_id: this.model.opd_id
			}})
		},	
		onSubmit(){
			let vm 			= this			
      		let routeName 	= vm.model.status ? 'domain.update-data-domain-layanan' : 'domain.simpan-data-domain-layanan'
			let url 		= vm.$app.route(routeName)
			let frm 		= new FormData()
			let formData 	= vm.$app.objectToFormData(vm.model, frm)
			let method 		= 'post'
			vm.$app.confirm({
				text: vm.$t('Apakah Anda yakin untuk menambah data layanan ?'),
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
						// vm.$app.success(result.value.data.message)
						// .then(response => {
						// 	if (response.value === true) {								
						// 		this.$router.go(-1)
						// 	}
						// })
						// this.$router.go(-1)
						vm.$app.alert.fire({
							icon: result.value.data.status,
							title: result.value.data.status ? 'Sukses' : 'Info',
							text: result.value.data.message,
							showConfirmButton: false,
							timer: 1300
						}).then(response => {
							this.$router.push({name: 'domain.domain-layanan', params: {
								opd_id: this.model.opd_id
							}})
						})	
						
					}
				})
		},			
		async resDomainLayanan(){
			const res = await this.$http.get(this.$app.route('domain.data-domain-layanan.get', {id_layanan: this.model.id}) )
			if(res.data){
				const ral1 = await this.resRal('',1,res.data.ral_level_1)
				const ral2 = await this.resRal(res.data.ral_level_1.split(' ')[0],2,res.data.ral_level_2)
				const ral3 = await this.resRal(res.data.ral_level_2.split(' ')[0],3,res.data.ral_level_3)

				this.model.id				= res.data.id
				this.model.ral_level_1 		= ral1[0]
				this.model.ral_level_2 		= ral2[0]
				this.model.ral_level_3 		= ral3[0]
				this.model.nama_layanan 	= res.data.nama_layanan
				this.model.tujuan_layanan 	= res.data.tujuan_layanan
				this.model.fungsi_layanan 	= res.data.fungsi_layanan
				this.model.pelaksana_level1 = res.data.pelaksana_level1
				this.model.pelaksana_level2 = res.data.pelaksana_level2
				this.model.target_layanan 	= res.data.target_layanan
				this.model.delegasi 		= res.data.unit_delegasi
			}			
		},		
		nameProsesBisnis ({proses_id}) {
			return `${proses_id}`
		},	
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'ral'}))
			return res.data			
		},		
		async resProsesBisnis(){
			const res 					= await this.$http.get(this.$app.route('domain.data-proses-bisnis.get', {opd_id: this.model.opd_id}))
			this.optionsProsesBisnis 	= res.data 
			return res.data
		},	
		async resPerangkatDaerahBySlug(){
			const res 				= await this.$http.get(this.$app.route('domain.data-perangkat-daerah-byslug.get', {opd_id: this.opd_id}))
			this.model.opd_id 		= res.data.opd_id
			this.model.unit_kerja 	= res.data.nama_opd
			this.resProsesBisnis()
			this.resJabatanTropdEselon3()
		},			
		async resPerangkatDaerahOpd(dataOpdId = null){
			const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {}))
			this.optionsDelegasi = res.data 
			return res.data 
		},		
		nameRalLevel({kode_nama}){
			return `${kode_nama}`
		},		
		nameProbis({kode_lev4, rab_level4}){
			return `${kode_lev4+' '+rab_level4}`
		},	
		async resJabatanTropdEselon3(){
			const res 					= await this.$http.get(this.$app.route('domain.data-jabatan-tropd-eselon3', {opd_id: this.model.opd_id }))
			this.optionsPelaksanaLevel1 = res.data
		},		
		async resJabatanTropdEselon4(){
			this.model.pelaksana_level2 = []
			this.optionsPelaksanaLevel2 = []
			const res 					= await this.$http.get(this.$app.route('domain.data-jabatan-tropd-eselon4', {opd_id: this.model.opd_id,kojab_atasan: this.model.pelaksana_level1.kojab }))
			this.optionsPelaksanaLevel2	= res.data
		},
		resRal1(data){
			this.model.ral_level_2 	= []
			this.model.ral_level_3 	= []
			this.optionsRalLevel2	= []
			this.optionsRalLevel3	= []
			this.resRal(data?.kode,2).then((data) =>{this.optionsRalLevel2 = data})
		},
		resRal2(data){
			this.model.ral_level_3 	= []
			this.optionsRalLevel3	= []
			this.resRal(data?.kode,3).then((data) =>{this.optionsRalLevel3 = data})
		},
	},
}
</script>

<style>
#app {
  margin: 20px;
}
</style>