<template>
	<div class="row">
		<div class="col-12">
			<section id="domain-infra-software-form">						
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
											:disabled="true"
										>     
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
											:disabled="true"
										>
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
											:allow-empty="false"
										>     
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
											:disabled="true"
										>
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
								:label="$t('domaininfra.form.field.name.label', {domain: 'Perangkat Lunak'})">
								<b-col sm="6">
									<validation-provider name="Nama Perangkat Lunak" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											v-model="model.nama"
											:placeholder="isDetail? '' :$t('domaininfra.form.field.name.placeholder', {domain: 'Perangkat Lunak'})"
											:disabled="isDetail"
										>
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
								label-for="tipe-pl"
								:label="$t('domaininfra.form.field.tipe_pl.label')">
								<b-col sm="6">
									<validation-provider name="Tipe Perangkat Lunak" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="tipe-pl"
											ref="tipe-pl"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsTipe"
											v-model="model.tipe_pl"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											:placeholder="$t('domaininfra.form.field.tipe_pl.placeholder')"
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
											:allow-empty="false"
										>     
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
											:disabled="true"
										>
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
											:allow-empty="false"
										>     
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
											:disabled="true"
										>
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
											:allow-empty="false"
										>     
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
											:disabled="true"
										>
										</b-form-input>
										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>
							-->
							
							<!--
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="nama-os"
								:label="$t('domaininfra.form.field.os_name.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Sistem Operasi"
										:debounce="250">
										<b-form-input
											v-model="model.nama_os"
											id="nama-os" 
											:placeholder="isDetail? '' : $t('domaininfra.form.field.os_name.placeholder')"
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
								label-for="nama-os"
								:label="$t('domaininfra.form.field.os_name.label')"
								v-show="OSShow">
								<b-col sm="6">
									<validation-provider name="Nama Sistem Operasi" rules="required" v-slot="{ errors, ariaMsg }" v-if="OSShow">
										<m-select
											id="nama-os"
											ref="nama-os"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsSO"
											v-model="model.nama_os"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											:placeholder="$t('domaininfra.form.field.os_name.placeholder')"
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
								label-for="nama-sistem-utilitas"
								:label="$t('domaininfra.form.field.utility_system_name.label')"
								v-show="UtilitasShow">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Sistem Utilitas"
										:debounce="250"
										v-if="UtilitasShow">
										<b-form-input
											v-model="model.nama_sistem_utilitas"
											id="nama-sistem-utilitas" 
											:placeholder="isDetail? '' : $t('domaininfra.form.field.utility_system_name.placeholder')"
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
								label-for="nama-sistem-db"
								:label="$t('domaininfra.form.field.db_system_name.label')">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Jenis Database"
										:debounce="250">
										<b-form-input
											v-model="model.nama_sistem_db"
											id="nama-sistem-db" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.db_system_name.placeholder')"
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
								label-for="nama-sistem-db"
								:label="$t('domaininfra.form.field.db_system_name.label')"
								v-show="DBShow">
								<b-col sm="6">
									<validation-provider name="Jenis Database" rules="required" v-slot="{ errors, ariaMsg }" v-if="DBShow">
										<m-select
											id="nama-sistem-db"
											ref="nama-sistem-db"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsDB"
											v-model="model.nama_sistem_db"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											:placeholder="$t('domaininfra.form.field.db_system_name.placeholder')"
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
								label-for="deskripsi"
								:label="$t('domaininfra.form.field.description.label', {domain: 'Perangkat Lunak'})"
								v-show="DeskripsiShow">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('domaininfra.form.field.description.label',  {domain: 'Perangkat Lunak'})"
										:debounce="250"
										v-if="DeskripsiShow">				
										<b-form-textarea
											id="deskripsi" 
											v-model="model.deskripsi"
											:placeholder="isDetail? '' :$t('domaininfra.form.field.description.placeholder', {domain: 'Perangkat Lunak'})"
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
								label-for="jenis-lisensi"
								:label="$t('domaininfra.form.field.license_type.label')">
								<b-col sm="6">
									<ValidationProvider
										rules=""
										v-slot="{ valid, errors }"
										name="Jenis Lisensi"
										:debounce="250">
										<b-form-input
											v-model="model.jenis_lisensi"
											id="jenis-lisensi" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.license_type.placeholder')"
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
								label-for="jenis-lisensi"
								:label="$t('domaininfra.form.field.license_type.label')">
								<b-col sm="6">
									<validation-provider name="Jenis Lisensi" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="jenis-lisensi"
											ref="jenis-lisensi"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsLisensi"
											v-model="model.jenis_lisensi"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											:placeholder="$t('domaininfra.form.field.license_type.placeholder')"
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
								label-for="owner-lisensi"
								:label="$t('domaininfra.form.field.license_owner.label')">
								<b-col sm="6">
									<ValidationProvider
										rules=""
										v-slot="{ valid, errors }"
										name="Pemilik Lisensi"
										:debounce="250">
										<b-form-input
											v-model="model.owner_lisensi"
											id="owner-lisensi" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.license_owner.placeholder')"
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
								label-for="validitas-lisensi"
								:label="$t('domaininfra.form.field.license_validity.label')">
								<b-col sm="6">
									<ValidationProvider
										rules=""
										v-slot="{ valid, errors }"
										name="Validitas Lisensi"
										:debounce="250">
										<b-form-input
											v-model="model.validitas_lisensi"
											id="validitas-lisensi" 
											:placeholder="isDetail? '' :$t('domaininfra.form.field.license_validity.placeholder')"
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
								label-for="id-metadata-terkait" 
								:label="`ID Metadata Terkait (Fasilitas Komputasi)`">
								<b-col sm="6">
									<ValidationProvider
										rules="required" v-slot="{ errors, ariaMsg }"
										:name="`ID Metadata Terkait (Fasilitas Komputasi)`" 
										:debounce="250">
										<m-select
											v-if="!isDetail"
											id="id-metadata-terkait" 
											v-model="model.id_metadata_terkait" 
											:options="optionIdMetadataTerkait" 
											:multiple="true"
											:close-on-select="true" 
											:clear-on-select="false" 
											:preserve-search="true" 
											:preselect-first="true"
											placeholder="Pilihan bisa lebih dari satu" 
											label="label" 
											track-by="value"
											:searchable="true" 
											:disabled="isDetail">
										</m-select>
										<b-form-input
											v-else
											v-model="model.id_metadata_terkait.label"
											:disabled="true"
										>
										</b-form-input>
										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</ValidationProvider>
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
			DeskripsiShow: false,
			OSShow: false,
			UtilitasShow: false,
			DBShow: false,				
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
				rai_level_3_fix: '03.01.07 Perangkat Lunak Platform',
				tipe_pl: null,
				nama_os: null,
				deskripsi: null,
				nama_sistem_utilitas: null,
				nama_sistem_db: null,
				jenis_lisensi: null,
				owner_lisensi: null,
				validitas_lisensi: null,	
				id_metadata_terkait: null,
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
			optionsInstansi: [],
			optionIdMetadataTerkait: [],
			opd_id: this.$app.user.opd_id,
			/*
			optionsTipe:[
				{kode: "Sistem Operasi", kode_nama: "Sistem Operasi"},
				{kode: "Sistem Database", kode_nama: "Sistem Database"},
				{kode: "Sistem Utilitas", kode_nama: "Sistem Utilitas"}
			],*/
			optionsDB:[
				{kode: "Relational DB", kode_nama: "Relational DB"},
				{kode: "NoSQL DB", kode_nama: "NoSQL DB"},
				{kode: "Memory Stored", kode_nama: "Memory Stored"},
				{kode: "Lainnya", kode_nama: "Lainnya"}
			],
			optionsSO:[
				{kode: "Dos", kode_nama: "Dos"},
				{kode: "Unix", kode_nama: "Unix"},
				{kode: "MacOS", kode_nama: "MacOS"},
				{kode: "Windows", kode_nama: "Windows"},
				{kode: "Networking OS", kode_nama: "Networking OS"},
				{kode: "Linux", kode_nama: "Linux"},
				{kode: "Mainframe OS", kode_nama: "Mainframe OS"},
				{kode: "Lainnya", kode_nama: "Lainnya"}
			],
			optionsLisensi:[
				{kode: "Lisensi seumur hidup", kode_nama: "Lisensi seumur hidup"},
				{kode: "Lisensi periodik", kode_nama: "Lisensi periodik"},
				{kode: "Open Source", kode_nama: "Open Source"}
			],
			isDetail: false,	
		}
	},
	computed: { },
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
					this.rai_l1_selected = this.model.rai_level_1 ? data.find(val => val.kode_nama === this.model.rai_level_1) : null
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
		},
		
		'rai_l4_selected':{
			handler: function(data){	
				if(data.kode == '03.01.07.02'){ //Sistem Operasi
					this.OSShow = true
					this.UtilitasShow = false
					this.DBShow = false
					this.DeskripsiShow = false
					
					//isi parameter yang tidak dipilih
					this.model.nama_sistem_db = '-'
					this.model.nama_sistem_utilitas = '-'
					this.model.deskripsi = '-'
				}
				if(data.kode == '03.01.07.03'){ // Sistem Utilitas
					this.OSShow = false
					this.UtilitasShow = true
					this.DBShow = false
					this.DeskripsiShow = true

					//isi parameter yang tidak dipilih
					this.model.nama_sistem_db = '-'
					this.model.nama_os = '-'
					this.model.deskripsi = '-'
				}
				if(data.kode == '03.01.07.01'){ // Sistem Database
					this.OSShow = false
					this.UtilitasShow = false
					this.DBShow = true
					this.DeskripsiShow = false
					this.model.deskripsi = '-'

					//isi parameter yang tidak dipilih
					this.model.nama_sistem_utilitas = '-'
					this.model.nama_os = '-'
					this.model.deskripsi = '-'
				}
			},
		},
		'model.nama_os':{
			handler: function(data){	
				this.DeskripsiShow = (data.kode == 'Lainnya')?true:false
			},
		},
		'model.nama_sistem_db':{
			handler: function(data){	
				this.DeskripsiShow = (data.kode == 'Lainnya')?true:false
			},
		},
	},
	mounted:function(){ },
	created(){
		this.initComponent()		
		this.getIdMetadataTerkait();
		console.log(this.$route?.params?.id)
		this.loadRef(4, '03.01.07').then((data) => {this.optionsRaiLevel4 = data})
	},
	methods :
	{	
		initComponent() {
			this.isDetail = this.$route.path.includes('detail')

			this.loadOpd().then(result => {
				this.optionsInstansi = result
				this.instansi_selected 	= this.optionsInstansi.find(data => data.opd_id === this.model.opd_add)
				if (this.$route.params.id) {
					this.loadDomainInfraSoftware().then(() => {
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
		async loadDomainInfraSoftware(){
			const res = await this.$http.get(this.$app.route('domain-infra-software.show', {id: this.model.id}))
			if(res.data){
				let rai_lv1 = res.data.level_1
				let rai_lv2 = res.data.level_2
				//let rai_lv3 = res.data.level_3

				this.optionsRaiLevel2 = rai_lv1 ? await this.loadRef(2, rai_lv1.split(' ')[0]) : [];
				this.optionsRaiLevel3 = rai_lv2 ? await this.loadRef(3, rai_lv2.split(' ')[0]) : [];
				//this.optionsRaiLevel4 = rai_lv3 ? await this.loadRef(4, rai_lv3.split(' ')[0]) : [];

				//this.model	= { ...res.data }
				this.model.id					= res.data.id
				this.model.nama 				= res.data.nama
				this.model.deskripsi 			= res.data.deskripsi
				//this.model.nama_os 				= this.optionsSO.find(data => data.kode_nama === res.data.nama_os)
				this.model.nama_sistem_utilitas	= res.data.nama_sistem_utilitas
				//this.model.nama_sistem_db 		= this.optionsDB.find(data => data.kode_nama === res.data.nama_sistem_db)
				this.model.jenis_lisensi 		= this.optionsLisensi.find(data => data.kode_nama === res.data.jenis_lisensi)
				this.model.owner_lisensi		= res.data.owner_lisensi
				this.model.validitas_lisensi	= res.data.validitas_lisensi

				let os_nama = this.optionsSO.find(data => data.kode_nama === res.data.nama_os)
				if (typeof os_nama === 'undefined'){
						this.model.nama_os = null
				}else{
						this.model.nama_os = this.optionsSO.find(data => data.kode_nama === res.data.nama_os)
				}

				let db_nama = this.optionsDB.find(data => data.kode_nama === res.data.nama_sistem_db)
				if (typeof db_nama === 'undefined'){
						this.model.nama_sistem_db = null
				}else{
						this.model.nama_sistem_db = this.optionsDB.find(data => data.kode_nama === res.data.nama_sistem_db)
				}


				this.instansi_selected 			= this.optionsInstansi.find(data => data.opd_id === res.data.opd_id)
				//this.rai_l1_selected 			= this.optionsRaiLevel1.find(data => data.kode_nama === res.data.rai_level_1)
				//this.rai_l2_selected 			= this.optionsRaiLevel2.find(data => data.kode_nama === res.data.rai_level_2)
				//this.rai_l3_selected 			= this.optionsRaiLevel3.find(data => data.kode_nama === res.data.rai_level_3)
				this.rai_l4_selected 			= this.optionsRaiLevel4.find(data => data.kode_nama === res.data.rai_level_4)

				const metadata = res.data.id_metadata_terkait
				let split = metadata.split("; ")

				let isi = []
				for (let element of split) { // You can use `let` instead of `const` if you like
					let a = this.optionIdMetadataTerkait.find(data => data.value === element)
					if (typeof a === 'undefined') {
						isi = null
					}else{
						isi.push(a)
					}					
				}
				this.model.id_metadata_terkait = isi

				console.log(split);
				console.log(isi);
			
			} else {
				console.log('cant load data');
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
			let vm 			= this	
			this.setRAIId()
			let isEdit = this.$route.path.includes('edit') 
      		let url 	=  isEdit ? '/domain-infra-software/update/' + this.model.id : '/domain-infra-software/save'
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
						this.$router.push({name: 'domain-infra-software'})
					}
				})
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
			this.$router.push({name: 'infra-software-edit', params: { id: this.$route.params.id }})
		},
		nameSelected({kode_nama}){
			return `${kode_nama}`
		},
		getIdMetadataTerkait(){
			let vm = this
			vm.groupLoading = true
			vm.$http.get(vm.$app.route('fasilitas.get-data-by.get'), {
				params: {col: 'domain_code'}
			}).then(response => {
				const idMetadataTerkaitOption = [];
				response.data.map(function (value, key) {
					idMetadataTerkaitOption.push({ value: value.kode, label: value.kode_nama });
				});

				vm.optionIdMetadataTerkait = idMetadataTerkaitOption
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