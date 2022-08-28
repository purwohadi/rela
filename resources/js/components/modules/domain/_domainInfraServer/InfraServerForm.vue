<template>
	<div class="row">
		<div class="col-12">
			<section id="domain-infra-server-form">						
				<b-card class="mb-4 mt-3 rounded">						
					<b-row>
						<b-col lg="12" md="12" sm="12" class="text-right"> 
							<button
								type="button"
								style="margin: 10px 0px 0px;"
								class="btn btn-danger btn-sm rounded waves-effect waves-themed"
								v-b-tooltip.hover.top="$t('general.button.back')"
								@click="onBack">
								<i class="fal fa-arrow-circle-left"></i> 
								{{ $t('general.button.back') }}
							</button>
							<!-- <button
								v-if="isDetail"
								type="button"
								style="margin: 10px 0px 0px;"
								class="btn btn-warning btn-sm rounded waves-effect waves-themed"
								v-b-tooltip.hover.top="$t('general.form.button_update')"
								@click="handleUpdate">
								<i class="fal fa-pen-alt"></i> 
								<strong>{{ $t('general.form.button_update') }}</strong>
							</button> -->
						</b-col>
					</b-row>
							
					<ValidationObserver v-slot="{ passes }" :slim="true">
						<form @submit.prevent="passes(onSubmit)">							
							<!-- label="nama_opd" -->
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="instansi"
								:label="$t('domaininfra.form.field.instansi.label')">
								<b-col sm="6">
									<validation-provider name="Instansi" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="instansi"
											ref="instansi"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsInstansi"
											label="nama_opd"
											v-model="instansi_selected"
											:placeholder="$t('domaininfra.form.field.instansi.placeholder')"
											track-by="opd_id"
											:searchable="true"			
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
													<span class="text-wrap">{{ option.opd_id }} - {{ option.nama_opd }}</span>
												</div>
											</template>
										</m-select>
										<b-form-input
											v-else
											v-model="model.instansi"
											:disabled="true">
										</b-form-input>
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
								label-for="rai_l1"
								:label="$t('domaininfra.form.field.rai_l1.label')">
								<b-col sm="5">
									<validation-provider name="RAI Level 1" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="rai_l1"
											ref="rai_l1"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel1"
											label="kode_nama"
											v-model="rai_l1_selected"
											:placeholder="$t('domaininfra.form.field.rai_l1.placeholder')"
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
											v-model="model.rai_level_1"
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
								label-for="rai_l2"
								:label="$t('domaininfra.form.field.rai_l2.label')">
								<b-col sm="5">
									<validation-provider name="RAI Level 2" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="rai_l2"
											ref="rai_l2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel2"
											v-model="rai_l2_selected"
											label="kode_nama"
											:placeholder="$t('domaininfra.form.field.rai_l2.placeholder')"
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
											v-model="model.rai_level_2"
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
								label-for="rai_l3"
								:label="$t('domaininfra.form.field.rai_l3.label')">
								<b-col sm="5">
									<validation-provider name="RAI Level 3" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="rai_l3"
											ref="rai_l3"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel3"
											v-model="rai_l3_selected"
											label="kode_nama"
											:placeholder="$t('domaininfra.form.field.rai_l3.placeholder')"
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
											v-model="model.rai_level_3"
											:disabled="true">
										</b-form-input>
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
											:readonly="true">
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
											:readonly="true">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai_level_3_fix"
								label="Referensi Arsitektur Keamanan Level 3">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Referensi Arsitektur Keamanan Level 3"
										:debounce="250">
										<b-form-input
											class="ml-2"
											v-model="model.rai_level_3_fix"
											maxlength="20"
											:id="'rai_level_3_fix'" 
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
								label-for="rai_l4"
								:label="$t('domaininfra.form.field.rai_l4.label')">
								<b-col sm="6">
									<validation-provider name="RAI Level 4" rules="" v-slot="{ errors, ariaMsg }">
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
											:placeholder="$t('domaininfra.form.field.rai_l4.placeholder')"
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
								:label="$t('domaininfra.form.field.name.label', {domain: 'Server'})">
								<b-col sm="6">
									<validation-provider name="Nama Server" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											v-model="model.nama"
											:placeholder="isDetail? '' :$t('domaininfra.form.field.name.placeholder', {domain: 'Server'})"
											:disabled="isDetail">
										</b-form-input>
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
								label-for="opd"
								label="Instansi">
								<b-col sm="6">
									<validation-provider name="Nama OPD" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="opd"
											ref="opd"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsOpd"
											v-model="model.opd"
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
							</b-form-group>
							-->

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="deskripsi"
								:label="$t('domaininfra.form.field.description.label', {domain: 'Server'})">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('domaininfra.form.field.description.label', {domain: 'Server'})"
										:debounce="250">				
										<b-form-textarea
											id="deskripsi" 
											v-model="model.deskripsi"
											:placeholder="isDetail? '' :$t('domaininfra.form.field.description.placeholder', {domain: 'Server'})"
											rows="3"
											max-rows="6"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!--
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="jenis-penggunaan"
								:label="$t('domaininfra.form.field.use_type.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Jenis Penggunaan"
										:debounce="250">
										<b-form-input
											v-model="model.jenis_penggunaan"
											id="jenis-penggunaan" 
											:placeholder="isDetail? '' : $t('domaininfra.form.field.use_type.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							-->

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="jenis-penggunaan"
								:label="$t('domaininfra.form.field.use_type.label')">
								<b-col sm="6">
									<validation-provider name="Jenis Penggunaan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="jenis-penggunaan"
											ref="jenis-penggunaan"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsJenisPenggunaan"
											v-model="model.jenis_penggunaan"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											:placeholder="$t('domaininfra.form.field.use_type.placeholder')"
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
								label-for="nama-owner"
								:label="$t('domaininfra.form.field.owner_name.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Pemilik"
										:debounce="250">
										<b-form-input
											v-model="model.nama_owner"
											id="nama-owner" 
											:placeholder="isDetail? '' : $t('domaininfra.form.field.owner_name.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!--
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="status-ownership"
								:label="$t('domaininfra.form.field.ownership_status.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Status Kepemilikan"
										:debounce="250">
										<b-form-input
											v-model="model.status_ownership"
											id="status-ownership" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.ownership_status.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							-->

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="status-ownership"
								:label="$t('domaininfra.form.field.ownership_status.label')">
								<b-col sm="6">
									<validation-provider name="Status Kepemilikan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="status-ownership"
											ref="status-ownership"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsStatusKepemilikan"
											v-model="model.status_ownership"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											:placeholder="$t('domaininfra.form.field.ownership_status.placeholder')"
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
								label-for="unit-pengelola"
								:label="$t('domaininfra.form.field.operation_unit.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Unit Pengelola"
										:debounce="250">
										<b-form-input
											v-model="model.unit_pengelola"
											id="unit-pengelola" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.operation_unit.placeholder')"
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
								label-for="lokasi"
								:label="$t('domaininfra.form.field.location.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Lokasi"
										:debounce="250">
										<b-form-input
											v-model="model.lokasi"
											id="lokasi" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.location.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!--
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="software-used"
								:label="$t('domaininfra.form.field.software_used.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Perangkat Lunak Digunakan"
										:debounce="250">
										<b-form-input
											v-model="model.software_used"
											id="software-used" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.software_used.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							-->

							<!-- :custom-label="nameSelected" -->
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="software-used"
								:label="$t('domaininfra.form.field.software_used.label')">
								<b-col sm="6">
									<validation-provider name="Perangkat Lunak Digunakan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="software-used"
											ref="software-used"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsSoftwareUsed"
											v-model="model.software_used"
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
											placeholder="Pilihan bisa lebih dari satu"
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
								label-for="kapasitas-memori"
								:label="$t('domaininfra.form.field.memory_capacity.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Kapasitas Memori"
										:debounce="250">
										<b-form-input
											v-model="model.kapasitas_memori"
											id="kapasitas-memori" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.memory_capacity.placeholder')"
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
								label-for="kapasitas-penyimpanan"
								:label="$t('domaininfra.form.field.storage_capacity.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Kapasitas Penyimpanan"
										:debounce="250">
										<b-form-input
											v-model="model.kapasitas_penyimpanan"
											id="kapasitas-penyimpanan" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.storage_capacity.placeholder')"
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
								label-for="kode-referensi-infra"
								:label="$t('domaininfra.form.field.infra_reference_code.label')">
								<b-col sm="6">
									<ValidationProvider
										rules=""
										v-slot="{ valid, errors }"
										name="Kode Referensi Infrastruktur"
										:debounce="250">
										<b-form-input
											v-model="model.kode_referensi_infra"
											id="kode-referensi-infra" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.infra_reference_code.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!--
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="teknik-penyimpanan"
								:label="$t('domaininfra.form.field.storage_technic.label')">
								<b-col sm="6">
									<ValidationProvider
										rules=""
										v-slot="{ valid, errors }"
										name="Teknik Penyimpanan"
										:debounce="250">
										<b-form-input
											v-model="model.teknik_penyimpanan"
											id="teknik-penyimpanan" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.storage_technic.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>
							-->

							<!-- :custom-label="nameSelected" -->
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="teknik-penyimpanan"
								:label="$t('domaininfra.form.field.storage_technic.label')">
								<b-col sm="6">
									<validation-provider name="Teknik Penyimpanan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="teknik-penyimpanan"
											ref="teknik-penyimpanan"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsTeknikPenyimpanan"
											v-model="model.teknik_penyimpanan"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											:placeholder="$t('domaininfra.form.field.storage_technic.placeholder')"
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
								label-for="jenis-prosesor"
								:label="$t('domaininfra.form.field.processor_type.label')">
								<b-col sm="6">
									<ValidationProvider
										rules=""
										v-slot="{ valid, errors }"
										name="Jenis Prosesor"
										:debounce="250">
										<b-form-input
											v-model="model.jenis_prosesor"
											id="jenis-prosesor" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.processor_type.placeholder')"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-input>
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
											placeholder="Pilihan bisa lebih dari satu"
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
								<b-button type="submit" variant="primary" v-show="!isDetail">
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
	name: 'InfraSoftwareForm',
	components: { 
	},
	data(){
		return{				
			model: {
				nama: null,
				opd_id: null,
				instansi: null,
				rai_level_1: null,
				rai_level_2: null,
				rai_level_3: null,
        		rai_level_4: null,
				rai_level_1_fix: '03 Platform',
				rai_level_2_fix: '03.01 Kerangka Infrastruktur dan Aplikasi',
				rai_level_3_fix: '03.01.01 Server',
				deskripsi: null,
				jenis_penggunaan: null,
				nama_owner: null,
				status_ownership: null,
				unit_pengelola: null,
				lokasi: null,
				software_used: [],
				kapasitas_memori: null,
				kapasitas_penyimpanan: null,
				kode_referensi_infra: null,
				teknik_penyimpanan: null,
				jenis_prosesor: '',
				id_metadata_terkait: [],
				id: this.$route?.params?.id,
				opd_add: this.$route?.params?.opd_id,
			},
			instansi_selected: null,
			rai_l1_selected: null,
			rai_l2_selected: null,
			rai_l3_selected: null,
			rai_l4_selected: null,
			optionsRaiLevel1: [],
			optionsRaiLevel2: [],
			optionsRaiLevel3: [],
			optionsRaiLevel4: [],
			optionsOpd: [],
			optionsIdMetadataTerkait:[],
			optionsSoftwareUsed:[],
			optionsInstansi: [],
			opd_id: this.$app.user.opd_id,
			optionsJenisPenggunaan:[
				{kode: "Web Server - Portal", kode_nama: "Web Server - Portal"},
				{kode: "Web Server - Web Based Application Server", kode_nama: "Web Server - Web Based Application Server"},
				{kode: "Application Client Server", kode_nama: "Application Client Server"},
				{kode: "Mail Server", kode_nama: "Mail Server"},
				{kode: "Database", kode_nama: "Database"},
				{kode: "File Server", kode_nama: "File Server"},
				{kode: "Active Directory", kode_nama: "Active Directory"},
				{kode: "Keamanan Informasi", kode_nama: "Keamanan Informasi"}
			],
			optionsStatusKepemilikan:[
				{kode: "Milik Sendiri", kode_nama: "Milik Sendiri"},
				{kode: "Milik Instansi Pemerintah Lain", kode_nama: "Milik Instansi Pemerintah Lain"},
				{kode: "Milik BUMN", kode_nama: "Milik BUMN"},
				{kode: "Milik Pihak Ketiga - Dalam Negeri", kode_nama: "Milik Pihak Ketiga - Dalam Negeri"},
				{kode: "Milik Pihak Ketiga - Luar Negeri", kode_nama: "Milik Pihak Ketiga - Luar Negeri"}
			],
			optionsTeknikPenyimpanan:[
				{kode: "RAID 0", kode_nama: "RAID 0"},
				{kode: "RAID 1", kode_nama: "RAID 1"},
				{kode: "RAID 3", kode_nama: "RAID 3"},
				{kode: "RAID 5", kode_nama: "RAID 5"},
				{kode: "non-RAID", kode_nama: "non-RAID"}
			],
			isDetail: false,
			isAdd: false,	
		}
	},
	computed: { 
		get_opd_id() {
      		return this.$route?.params?.opd_id
		}
	},
	watch: {
		'instansi_selected':{
			handler: function(data){
				if (data) {
					this.model.opd_id = data.opd_id
					this.model.instansi = data.nama_opd
				}
			},
		},
		/*	
		'rai_l1_selected':{
			handler: function(data){
				if (data) {
					this.loadRef(2, data.kode).then(result => this.optionsRaiLevel2 = result)
				}
			},
		},		
		'rai_l2_selected':{
			handler: function(data){
				if (data) {
					this.loadRef(3, data.kode).then(result => this.optionsRaiLevel3 = result)
				}
			},
		},
		'rai_l3_selected':{
			handler: function(data){
				if (data) {
					this.loadRef(4, data.kode).then(result => this.optionsRaiLevel4 = result)
				}
			},
		},
		'optionsRaiLevel1':{
			handler: function(data){
				if (data) {
					this.rai_l2_selected = null
					this.rai_l3_selected = null
					this.rai_l4_selected = null
					this.rai_l1_selected = this.model.rai_level_1 ? data.find(val => {
						return val.kode_nama.indexOf(this.model.rai_level_1) !== -1
					}) : null
				}
			},
		},	
		'optionsRaiLevel2':{
			handler: function(data){
				if (data) {
					this.rai_l3_selected = null
					this.rai_l4_selected = null
					this.rai_l2_selected = this.model.rai_level_2 ? data.find(val => val.kode_nama === this.model.rai_level_2) : null
				}
			},
		},
		'optionsRaiLevel3':{
			handler: function(data){
				if (data) {
					this.rai_l4_selected = null
					this.rai_l3_selected = this.model.rai_level_3 ? data.find(val => val.kode_nama === this.model.rai_level_3) : null
				}
			},
		},
		'optionsRaiLevel4':{
			handler: function(data){
				if (data) {
					this.rai_l4_selected = this.model.rai_level_4 ? data.find(val => val.kode_nama === this.model.rai_level_4) : null
				}
			},
		},
		*/		
		$route (to, from){
			this.initComponent()
		}
	},
	mounted:function(){ },
	created(){
		this.initComponent()		
		this.loadDomainInfraServer()
		this.resMetadata().then((data) => {this.optionsIdMetadataTerkait = data})
		this.resSoftwareUsed().then((data) => {this.optionsSoftwareUsed = data})
		this.loadRef(4, '03.01.01').then((data) => {this.optionsRaiLevel4 = data})
		//console.log(this.model.opd_add)
		//console.log(this.model.id)
		//console.dir(this.optionsInstansi)
	},
	methods :
	{	
		initComponent() {
			this.isDetail = this.$route.path.includes('detail')

			this.loadOpd().then(result => {
				this.optionsInstansi = result
				this.instansi_selected 	= this.optionsInstansi.find(data => data.opd_id === this.model.opd_add)
				if (this.$route.params.id) {
					this.loadDomainInfraServer().then(() => {
						if (!this.isDetail) {
							this.loadRef(1).then(result => {
								this.optionsRaiLevel1 = result
							})
						}
					})
				} else {
					this.loadRef(1).then(result => {
						this.optionsRaiLevel1 = result
					})
				}
			})
		},
		onBack() {
			this.$router.go(-1)
		},
		async loadDomainInfraServer(){
			const res = await this.$http.get(this.$app.route('domain-infra-server.show', {id: this.model.id}))
			
			if(res.data){
				let rai_lv1 = res.data.level_1
				let rai_lv2 = res.data.level_2
				//let rai_lv3 = res.data.level_3

				this.optionsRaiLevel2 = rai_lv1 ? await this.loadRef(2, rai_lv1.split(' ')[0]) : [];
				this.optionsRaiLevel3 = rai_lv2 ? await this.loadRef(3, rai_lv2.split(' ')[0]) : [];
				//this.optionsRaiLevel4 = rai_lv3 ? await this.loadRef(4, rai_lv3.split(' ')[0]) : []; 

				//this.model	= { ...res.data }
				this.instansi_selected 			= this.optionsInstansi.find(data => data.opd_id === res.data.opd_id)
				//this.rai_l1_selected 			= this.optionsRaiLevel1.find(data => data.kode_nama === res.data.rai_level_1)
				//this.rai_l2_selected 			= this.optionsRaiLevel2.find(data => data.kode_nama === res.data.rai_level_2)
				//this.rai_l3_selected 			= this.optionsRaiLevel3.find(data => data.kode_nama === res.data.rai_level_3)
				this.rai_l4_selected 			= this.optionsRaiLevel4.find(data => data.kode_nama === res.data.rai_level_4)
				//this.model.id_metadata_terkait 	= this.optionsIdMetadataTerkait.find(data => data.value === res.data.id_metadata_terkait)
				
				this.model.id						= res.data.id
				this.model.nama 					= res.data.nama
				this.model.deskripsi 				= res.data.deskripsi
				this.model.jenis_penggunaan			= this.optionsJenisPenggunaan.find(data => data.kode_nama === res.data.jenis_penggunaan)
				this.model.nama_owner 				= res.data.nama_owner
				this.model.status_ownership			= this.optionsStatusKepemilikan.find(data => data.kode_nama === res.data.status_ownership)
				this.model.unit_pengelola	 		= res.data.unit_pengelola
				this.model.lokasi 					= res.data.lokasi
				this.model.kapasitas_memori 		= res.data.kapasitas_memori
				this.model.kapasitas_penyimpanan 	= res.data.kapasitas_penyimpanan
				this.model.kode_referensi_infra 	= res.data.kode_referensi_infra
				this.model.teknik_penyimpanan 		= this.optionsTeknikPenyimpanan.find(data => data.kode_nama === res.data.teknik_penyimpanan)
				this.model.jenis_prosesor 			= res.data.jenis_prosesor

				//id metadata terkait
				const metadata = res.data.id_metadata_terkait
				let split = metadata.split("; ")
				let isi = []
				for (let element of split) {
					let a = this.optionsIdMetadataTerkait.find(data => data.kode === element)
					if (typeof a === 'undefined') {
						isi = null
					}else{
						isi.push(a)
					}					
				}
				this.model.id_metadata_terkait = isi

				//software used
				const res_software_used = res.data.software_used
				let split2 = res_software_used.split("; ")
				let isi2 = []
				for (let element2 of split2) {
					let b = this.optionsSoftwareUsed.find(data => data.kode_nama === element2)
					if (typeof b === 'undefined') {
						isi2 = null
					}else{
						isi2.push(b)
					}						
				}
				this.model.software_used = isi2
			} 
			else 
			{
				console.log('cant load data')
			}
		},

		setRAIId() {
			let vm = this
			vm.model.rai_level_1 = vm.rai_l1_selected ? vm.rai_l1_selected.kode_nama : ''
			vm.model.rai_level_4 = vm.rai_l4_selected ? vm.rai_l4_selected.kode_nama : ''
			vm.model.rai_level_3 = vm.rai_l3_selected ? vm.rai_l3_selected.kode_nama : ''
			vm.model.rai_level_2 = vm.rai_l2_selected ? vm.rai_l2_selected.kode_nama : ''
		},
		onSubmit(){
			this.setRAIId()
			let vm 			= this	
			let isEdit 		= this.$route.path.includes('edit') 
			let url 		= vm.$app.route(isEdit ? 'domain-infra-server.update' : 'domain-infra-server.save')
			let frm 		= new FormData()
			let formData 	= vm.$app.objectToFormData(vm.model, frm)

			let method = 'post'
			vm.$app.confirm({
				text: vm.$t('domaininfra.alert.confirm.add', {name: this.model.nama}),
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
					vm.$app.alert.fire('Sukses', 'Data Berhasil Disimpan' , 'success');
					this.$router.push({name: 'domain-infra-server'})
				}
			})
		},
		nameSelected({kode_nama}){
			return `${kode_nama}`
		},				
		async loadRef(tingkat, kode=''){
			const res = await this.$http.get(this.$app.route('domain.data-ref.get', {kode: kode, tingkat: tingkat, kategori: 'rai'}))
			return res.data
		},
		async loadOpd() {
			const res = await this.$http.get(this.$app.route('opd.all'))
			return res.data
		},
		handleUpdate(item, index, $el) {
			console.log('log', this.$route.params.id)
			this.$router.push({name: 'infra-server-edit', params: { id: this.$route.params.id }})
		},
		async resMetadata(){
			const res = await this.$http.get(this.$app.route('perangkat-keamanan.get-metadata'))
			return res.data			
		},
		async resSoftwareUsed(){
			const res = await this.$http.get(this.$app.route('domain-infra-software.get_used_software'))
			return res.data			
		},
		handleDelete(item, index, $el) {
			let vm = this
			let url 	=  vm.$app.route('domain-infra-server.delete')
			let method = 'post'
			vm.$app.confirm({
				text: vm.$t('domaininfra.alert.confirm.drop', {name: item.nama}),
				preConfirm: () => {
					return vm.$http
						[method](url, {id: item.id})
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
						vm.$app.alert.fire('Sukses', 'Data Berhasil Dihapus' , 'success');
						vm.$root.$emit('bv::refresh::table', this.resourceName)
					}
			})
		},
	}
}
</script>

<style>
#app {
  margin: 20px;
}
</style>