<template>
	<div class="row">
		<div class="col-12">
			<section id="domain-layanan-form">						
				<b-card class="mb-4 mt-3 rounded">			
					<ValidationObserver v-slot="{ passes }" :slim="true">
						<form @submit.prevent="passes(onSubmit)">		
							<div class="panel">
								<div class="col-12">									
									<div class="panel-hdr mb-3">
										<h2  class="fs-xl">
											<div class="col-6">
												<i  class="fal fa-th-list mr-2"></i> 
												<i v-if="!isDetail" >Ubah <span class="fw-300">Layanan</span></i>
												<i v-else >Layanan</i>
											</div>
											<div class="col-6"  v-show="isDetail">
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
									</div>			
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
										<b-col 
											sm="6"
											v-if="!isDetail">
											<validation-provider 
												name="Referensi Arsitektur Layanan Level 1" 
												rules="required" 
												v-slot="{ errors, ariaMsg }">
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
										<b-col 
											sm="6"
											v-else>
											<b-form-input
												class="ml-2"
												v-model="model.ral_level_1.kode_nama"
												:readonly="true">
											</b-form-input>
										</b-col>
									</b-form-group>
									
									<b-form-group
										label-cols="2"
										label-cols-lg="2"
										label-for="ral-level_2"
										label="Referensi Arsitektur Layanan Level 2">
										<b-col 
											sm="6"
											v-if="!isDetail">
											<validation-provider 
												name="Referensi Arsitektur Layanan Level 2" 
												rules="required" 
												v-slot="{ errors, ariaMsg }">
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
										<b-col 
											sm="6"
											v-else>
											<b-form-input
												class="ml-2"
												v-model="model.ral_level_2.kode_nama"
												:readonly="true">
											</b-form-input>
										</b-col>
									</b-form-group>

									<b-form-group
										label-cols="2"
										label-cols-lg="2"
										label-for="ral-level_3"
										label="Referensi Arsitektur Layanan Level 3">
										<b-col 
											sm="6"
											v-if="!isDetail">
											<validation-provider 
												name="Referensi Arsitektur Layanan Level 3" 
												rules="required" 
												v-slot="{ errors, ariaMsg }">
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
										
										<b-col 
											sm="6"
											v-else>
											<b-form-input
												class="ml-2"
												v-model="model.ral_level_3.kode_nama"
												:readonly="true">
											</b-form-input>
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
													:state="isDetail ? null : errors[0] ? false : (valid ? true : null)"
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
													track-by="proses_id"
													placeholder=""
													:searchable="true"
													:limit="100"
													:options-limit="100"	
													:disabled="isDetail"
													:multiple="true"
													:close-on-select="false" 
													:clear-on-select="false" 
													:custom-label="nameProbis"
													:taggable="true">     

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
								</div>
							</div> 	
							<div class="text-right mt-4" v-show="!isDetail">
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
			<section class="domain-layanan-form-datatable">
				<data-tables
					:id="`${tableId}`"
					:ref="`${tableId}`"
					:fields="fields"
					:api-url="'domain.getLayananDetail'"
					:args-route="{'layanan_id': layanan_id}"
					:title="`Detail Layanan`"
					actions="SCL"
					:access="isDetail"
					row-action-width="10%"
					@onQuerySearch="handleQuerySearch"
					@add="handleAdd">  
					<template #cell(rowaction) = "{data}">
						<button
							v-show="isDetail"
							type="button"
							class="btn btn-info btn-xs rounded waves-effect waves-themed mr-lg-1"
							v-b-tooltip.hover.right="$t('general.datatable.body.update')"
							@click.prevent="handleUbah(data.item)">
							<i class="fal fa-pen-alt"></i> Ubah
						</button>

						<button
							v-show="isDetail"
							type="button"
							class="btn btn-danger btn-xs rounded waves-effect waves-themed"
							v-b-tooltip.hover.right="$t('general.datatable.body.delete')"
							@click.prevent="handleDelete(data.item)">
							<i class="fal fa-trash"></i> Hapus
						</button>
					</template>

					<template v-slot:cell(pelaksana_level1)="{ data }">
						<hide-more
							label="najabl"
							:items="data.item.pelaksana1"
							:highlight-text="querySearch"
							search-highligt/>
					</template>

					<template v-slot:cell(pelaksana_level2)="{ data }">
						<hide-more
							label="najabl"
							:items="data.item.pelaksana2"
							:highlight-text="querySearch"
							search-highligt/>
					</template>
					
					<template v-slot:cell(unit_delegasi)="{ data }">
						<hide-more
							label="akronim"
							:items="data.item.delegasi"
							:highlight-text="querySearch"
							search-highligt/>
					</template>
				</data-tables>
				
				<detil-domain-layanan-form
					:m-id="modal.id"
					:title="modal.title"
					:opd-id="model.opd_id"
					:is-status="modal.status"
					:layanan-id="model.layanan_id"
					:id-layanan-detail="model.id_layanan_detail"
					:klik-date="modal.klik_date">
				</detil-domain-layanan-form>
			</section>
		</div>
	</div>
</template>

<script>
import DetilDomainLayananForm from './DetilDomainLayananForm'

export default
{
	name: 'DomainLayananForm',
	components: { 
		DetilDomainLayananForm
	},
	data(){
		return{			
			tableId: 'domain-layanan-form',	
			tempOpdId: '',
			querySearch: '',
			model: {
				prosesBisnis: [],
				opd_id: '',
				unit_kerja: '',
				ral_level_1: [],
				ral_level_2: [],
				ral_level_3: [],
				nama_layanan: '',
				tujuan_layanan: '',
				layanan_id:'',
				id_layanan_detail: '',
				status: this.$route?.params?.status,
			},
			modal: {
				id: 'modal-detil-domain-layanan-form',
				title: 'Detil Layanan',
				status: '',
				probis_id: '',
				klik_date: ''
			},
			layanan_id: this.$route?.params?.id,
			fields: [
				{
					key: 'rowaction',
					label: '',
					sortable: false,
					class: 'text-center',
				},
				{
					key: 'fungsi_layanan',
					label: 'Fungsi Layanan',
					sortable: true,
				},
				{
					key: 'pelaksana_level1',
					label: 'Unit Pelaksana Level 1 (Eselon 3)',
					sortable: true,
				},
				{
					key: 'pelaksana_level2',
					label: 'Unit Pelaksana Level 2 (Eselon 4)',
					sortable: true,
				},
				{
					key: 'target_layanan',
					label: 'Target Layanan',
					sortable: true,
				},
				{
					key: 'unit_delegasi',
					label: 'Unit Pendelegasian Kewenangan',
					sortable: true,
				},
			],
			optionsProsesBisnis: [],
			optionsRalLevel1: [],
			optionsRalLevel2: [],
			optionsRalLevel3: [],
			opd_id: this.$app.user.opd_id,
			isDetail: false,	
		}
	},
	computed: { },
	watch: {
		'model.prosesBisnis':{
			handler: function(data){
				this.model.opd_id 		= data.opd_id
				this.model.unit_kerja 	= data.nama_opd
				this.resRal('',1).then((data) =>{this.optionsRalLevel1 = data})
			},
		},
		// 'model.ral_level_1':{
		// 	handler: function(data){
		// 		this.model.ral_level_2 = []
		// 		this.model.ral_level_3 = []
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
		this.resDomainLayanan()
		this.isDetail = (this.model.status == 'detail')?true:false
	},
	methods :
	{				
		onBack() {
			// this.$router.go(-1)
			this.$router.push({name: 'domain.domain-layanan', params: {
				opd_id: this.tempOpdId
			}})
		},	
		onSubmit(){
			let vm 			= this			
      		let routeName 	= 'domain.update-data-domain-layanan'
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
							this.$router.push({name: 'domain.domain-layanan', params: {
								opd_id: this.tempOpdId
							}})
						})	
					}
				})
		},				
		async resDomainLayanan(){
			const res = await this.$http.get(this.$app.route('domain.data-domain-layanan.get', {id_layanan: this.layanan_id}))
			if(res.data){
				const optionsRalLevel1 	= await this.resRal('',1)
				const optionsRalLevel2 	= await this.resRal(res.data.ral_level_1,2)
				const optionsRalLevel3 	= await this.resRal(res.data.ral_level_2,3)
				this.optionsRalLevel1 	= optionsRalLevel1
				this.optionsRalLevel2 	= optionsRalLevel2
				this.optionsRalLevel3 	= optionsRalLevel3

				this.model.layanan_id		= res.data.layanan_id
				this.model.opd_id			= res.data.opd_id
				this.tempOpdId				= res.data.opd_id
				
				this.model.ral_level_1 		= this.optionsRalLevel1.find(data => data.kode === res.data.ral_level_1)
				this.model.ral_level_2 		= this.optionsRalLevel2.find(data => data.kode === res.data.ral_level_2)
				this.model.ral_level_3 		= this.optionsRalLevel3.find(data => data.kode === res.data.ral_level_3)
				this.model.nama_layanan 	= res.data.nama_layanan
				this.model.tujuan_layanan 	= res.data.tujuan_layanan	
				this.model.prosesBisnis 	= res.data.layanan_proses		
				this.resPerangkatDaerahById()
				this.resProsesBisnis()
			}			
		},		
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'ral'}))
			return res.data			
		},
		nameRalLevel({kode_nama}){
			return `${kode_nama}`
		},
		show(data){
			if((data.opd_id==this.$app.user.opd_id) || this.$app.user.is_admin){
				return true
			}
			else{
				return false
			}
		},
		async resPerangkatDaerahById(){
			const res = await this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.model.opd_id}))
			this.model.opd_id		= res.data[0].opd_id
			this.model.unit_kerja 	= res.data[0].akronim
		},			
		handleAdd() {
			this.modal.status = 'tambah'
			this.modal.klik_date = new Date().toLocaleString()
			this.$bvModal.show(this.modal.id)
		},	
		handleUbah(data) {
			this.modal.status 				= 'ubah'
			this.modal.klik_date 			= new Date().toLocaleString()
			this.model.id_layanan_detail 	= data.idlayanandetail
			this.modal.probis_id			= data.proses_id
			this.$bvModal.show(this.modal.id)
		},		
		handleDelete(data){
			let vm 			= this
			vm.$app.confirm({
				text: 'Apakah yakin akan menghapus data',
				preConfirm: () => {
					return vm.$http
					.post(vm.$app.route('domain.delete-data-domain-layanan-detail'), {
						data: { idlayanandetail: data.idlayanandetail, idlaydetailproses: data.idproses}
					})
					.then(response => {
						if (response.data.status == "error") {
						let errors = response.data.message
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
				if (result.isDismissed) {
					return
				}
				if (result.value.data.status == "success") {
					// vm.$app.success(result.value.data.message)
					// .then(response => {
					// 	if (response.value === true) {
					// 		this.$root.$emit('bv::refresh::table', this.tableId)
					// 	}
					// })
					this.$root.$emit('bv::refresh::table', this.tableId)
				}
			})   
		},			
		nameProbis({kode_lev4, rab_level4}){
			return `${kode_lev4+' '+rab_level4}`
		},	
		async resProsesBisnis(){
			const res 					= await this.$http.get(this.$app.route('domain.data-proses-bisnis.get', {opd_id: this.model.opd_id}))
			this.optionsProsesBisnis 	= res.data 
			return res.data
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
		handleQuerySearch(q) {
			this.querySearch = q
		},
	},
}
</script>

<style>
#app {
  margin: 20px;
}

</style>