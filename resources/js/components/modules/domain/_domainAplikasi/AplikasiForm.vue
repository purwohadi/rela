<template>
	<div class="row">
		<div class="col-12">
			<section id="aplikasi-form">						
				<b-card class="mb-4 mt-3 p-4 rounded">						
					<b-row v-if="isDetail">
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
								label-for="opd_input"
								:label="$t('aplikasi.form.field.opd_input.label')">
								<b-col sm="6">
									<validation-provider name="OPD Input" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="opd_input"
											v-model="model.opd"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.opd_input.placeholder')"
											:disabled="true">
										</b-form-input>
										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group 
								:label="$t('aplikasi.form.field.app_ownership.label')" 
								label-cols="2"
								label-cols-lg="2"
							>
								<b-col sm="6">		
									<validation-provider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('aplikasi.form.field.app_ownership.label')"
										:debounce="250"
									>
										<b-form-radio-group
											v-model="model.app_ownership"
											:options="optionsAppOwnership"
											name="app_ownership"
											id="app_ownership"
        									stacked
											plain
											:disabled="isDetail"
										></b-form-radio-group>
										<b-form-invalid-feedback :state="errors[0] ? false : (valid ? true : null)">
										{{errors[0]}}
										</b-form-invalid-feedback>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="nama_select"
								:label="$t('aplikasi.form.field.name.label')">
								<b-col sm="6">
									<input type="hidden" name="apl_id" class="form-control" :value="model.apl_id">

									<validation-provider name="Nama Aplikasi" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail && model.app_ownership == 'Internal'"
											id="nama_select"
											ref="nama_select"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsAplikasi"
											v-model="model.aplikasi_selected"
											label="nama_apl"
											:placeholder="'Pilih Aplikasi'"
											track-by="apl_id"
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
													<span class="text-wrap">{{ option.nama_apl }}</span>
												</div>
											</template>
										</m-select>
										<b-form-input
											v-else-if="!isDetail && model.app_ownership != 'Internal'"
											id="nama"
											v-model="model.nama_apl"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.name.placeholder')"
											:disabled="isDetail">
										</b-form-input>
										<b-form-input
											v-else
											v-model="model.nama_apl"
											:disabled="true">
										</b-form-input>
										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								v-if="model.app_ownership == 'User'"
								label-cols="2"
								label-cols-lg="2"
								label-for="pemilik"
								:label="$t('aplikasi.form.field.pemilik.label')">
								<b-col sm="6">
									<validation-provider name="Pemilik Aplikasi" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="pemilik"
											v-model="model.app_external"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.pemilik.placeholder')"
											:disabled="isDetail">
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
								label-for="description"
								:label="$t('aplikasi.form.field.description.label')">
								<b-col sm="6">
									<validation-provider name="Uraian" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-textarea
											id="description"
											v-model="model.deskripsi"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.description.placeholder')"
											rows="3"
											max-rows="6"
											:disabled="isDetail">
										</b-form-textarea>
										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>
										
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="raa_l1"
								:label="$t('aplikasi.form.field.raa_l1.label')">
								<b-col sm="6">
									<validation-provider name="RAA Level 1" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="raa_l1"
											ref="raa_l1"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaaLevel1"
											label="kode_nama"
											v-model="raa_l1_selected"
											:placeholder="$t('aplikasi.form.field.raa_l1.placeholder')"
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
											v-model="model.raa_level_1_nama"
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
								label-for="raa_l2"
								:label="$t('aplikasi.form.field.raa_l2.label')">
								<b-col sm="6">
									<validation-provider name="RAA Level 2" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="raa_l2"
											ref="raa_l2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaaLevel2"
											v-model="raa_l2_selected"
											label="kode_nama"
											:placeholder="$t('aplikasi.form.field.raa_l2.placeholder')"
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
											v-model="model.raa_level_2_nama"
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
								label-for="raa_l3"
								:label="$t('aplikasi.form.field.raa_l3.label')">
								<b-col sm="6">
									<validation-provider name="RAA Level 3" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="raa_l3"
											ref="raa_l3"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaaLevel3"
											v-model="raa_l3_selected"
											label="kode_nama"
											:placeholder="$t('aplikasi.form.field.raa_l3.placeholder')"
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
											v-model="model.raa_level_3_nama"
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
								label-for="raa_l4"
								:label="$t('aplikasi.form.field.raa_l4.label')">
								<b-col sm="6">
									<validation-provider name="RAA Level 4" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="raa_l4"
											ref="raa_l4"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaaLevel4"
											v-model="raa_l4_selected"
											label="kode_nama"
											:placeholder="$t('aplikasi.form.field.raa_l4.placeholder')"
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
											v-model="model.raa_level_4_nama"
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
								label-for="fungsi"
								:label="$t('aplikasi.form.field.function.label')">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('aplikasi.form.field.function.label')"
										:debounce="250">				
										<b-form-textarea
											id="fungsi"
											v-model="model.fungsi"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.function.placeholder')"
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
								label-for="layanan"
								:label="$t('aplikasi.form.field.lay_supported.label')">
								<b-col sm="6">
									<validation-provider name="Layanan yang Didukung" rules="" v-slot="{ errors, ariaMsg }">
										<m-select
											id="layanan"
											ref="layanan"
											:multiple="true" 
											:close-on-select="false" 
											:clear-on-select="false"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsLayanan"
											v-model="layanan_selected"
											:custom-label="labelLayanan"
											:placeholder="$t('aplikasi.form.field.lay_supported.placeholder')"
											track-by="layanan_id"
											:searchable="true"	
											:disabled="isDetail"		
										>     

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

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="data"
								:label="$t('aplikasi.form.field.data_used.label')">
								<b-col sm="6">
									<validation-provider name="Data yang Digunakan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="data"
											ref="data"
											class="mb-2"
											:multiple="true" 
											:close-on-select="false" 
											:clear-on-select="false"
											:option-height="73"
											:tabindex="7"
											:options="optionsData"
											v-model="data_selected"
											:custom-label="labelData"
											:placeholder="$t('aplikasi.form.field.data_used.placeholder')"
											track-by="info_id"
											:searchable="true"	
											:disabled="isDetail"		
										>     
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

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="luaran"
								:label="$t('aplikasi.form.field.output.label')">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ ariaMsg, errors }"
										:name="$t('aplikasi.form.field.output.label')"
										:debounce="250">				
										<m-select
											id="data"
											ref="data"
											class="mb-2"
											:multiple="true" 
											:close-on-select="false" 
											:clear-on-select="false"
											:option-height="73"
											:tabindex="7"
											:options="optionsData"
											v-model="luaran_selected"
											:custom-label="labelData"
											:placeholder="$t('aplikasi.form.field.output.placeholder')"
											track-by="info_id"
											:searchable="true"	
											:disabled="isDetail"		
										>     
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
									</ValidationProvider>
								</b-col>
							</b-form-group>
							
							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="basis_aplikasi"
								:label="$t('aplikasi.form.field.app_base_primary.label')">
								<b-col sm="12">
									<b-row>
										<b-col sm="6">
											<validation-provider name="Basis Aplikasi Utama" rules="required" v-slot="{ errors, ariaMsg }">
												<m-select
													v-if="!isDetail"
													id="basis_aplikasi"
													ref="basis_aplikasi"
													class="mb-2"
													:options="optionsJenisAkses"
													v-model="model.jenis_akses"
													:placeholder="$t('aplikasi.form.field.app_base_primary.placeholder')"
													:allow-empty="false">
												</m-select>
												<b-form-input
													v-else
													v-model="model.jenis_akses"
													:disabled="true">
												</b-form-input>
												<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
													{{ errors[0] }}
												</small>
											</validation-provider>
										</b-col>
										<b-col v-if="model.jenis_akses == 'Web' || model.jenis_akses == 'Mobile Web'">
											<validation-provider name="URL" :rules="model.jenis_akses == 'Web' || model.jenis_akses == 'Mobile Web' ? 'required' : ''" v-slot="{ errors, ariaMsg }">
												<b-input-group prepend="http://">
													<b-form-input
														id="url"
														v-model="model.url"
														:placeholder="isDetail? '' :$t('aplikasi.form.field.url.placeholder')"
														:disabled="isDetail">
													</b-form-input>
												</b-input-group>
												<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
													{{ errors[0] }}
												</small>
											</validation-provider>
										</b-col>
									</b-row>
								</b-col>
							</b-form-group>

							<b-form-group
								v-if="model.jenis_akses"
								label-cols="2"
								label-cols-lg="2"
								label-for="basis_aplikasi_secondary"
								:label="$t('aplikasi.form.field.app_base_secondary.label')"
								v-slot="{ ariaDescribedby }"
							>
								<b-col sm="6">
									<validation-provider name="Basis Aplikasi Sekunder" rules="required" v-slot="{ errors, ariaMsg }">
										<div>
											<b-form-checkbox
												v-for="option in optionsJenisAkses2"
												v-model="model.jenis_akses_2"
												:key="option"
												:value="option"
												:aria-describedby="ariaDescribedby"
												:disabled="isDetail"
											>
												{{ option }}
												<validation-provider 
													v-if="option == 'Web'" name="URL Web" :rules="model.jenis_akses == 'Web' ? 'required' : ''" v-slot="{ errors, ariaMsg }"
												>
													<b-input-group prepend="http://">
														<b-form-input
															v-model="model.url_2_web"
															:placeholder="isDetail? '' :$t('aplikasi.form.field.url.placeholder')"
															:disabled="isDetail || !isWeb">
														</b-form-input>
													</b-input-group>
													<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
														{{ errors[0] }}
													</small>
												</validation-provider>
												<validation-provider v-if="option == 'Mobile Web'" name="URL Mobile Web" :rules="model.jenis_akses == 'Mobile Web' ? 'required' : ''" v-slot="{ errors, ariaMsg }">
													<b-input-group prepend="http://">
														<b-form-input
															v-model="model.url_2_mobile_web"
															:placeholder="isDetail? '' :$t('aplikasi.form.field.url.placeholder')"
															:disabled="isDetail || !isMobileWeb"
															>
														</b-form-input>
													</b-input-group>
													<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
														{{ errors[0] }}
													</small>
												</validation-provider>
											</b-form-checkbox>
										</div>
										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="license_type"
								:label="$t('aplikasi.form.field.license_type.label')">
								<b-col sm="6">
									<validation-provider name="Tioe Lisensi Bahasa Pemrograman" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="license_type"
											ref="license_type"
											class="mb-2"
											:options="optionsLicenseType"
											v-model="model.license"
											:placeholder="$t('aplikasi.form.field.license_type.placeholder')"
											:allow-empty="false">     
										</m-select>
										<b-form-input
											v-else
											v-model="model.license"
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
								label-for="prog_lang"
								:label="$t('aplikasi.form.field.prog_lang.label')">
								<b-col sm="6">
									<validation-provider name="Bahasa Pemrograman" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="prog_lang"
											v-model="model.prog_lang"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.prog_lang.placeholder')"
											:disabled="isDetail">
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
								label-for="dev_framework"
								:label="$t('aplikasi.form.field.dev_framework.label')">
								<b-col sm="6">
									<validation-provider name="Kerangka Pengembangan/Framework" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="dev_framework"
											v-model="model.dev_framework"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.dev_framework.placeholder')"
											:disabled="isDetail">
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
								label-for="database"
								:label="$t('aplikasi.form.field.database.label')">
								<b-col sm="6">
									<validation-provider name="Basis Data" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="database"
											v-model="model.database"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.database.placeholder')"
											:disabled="isDetail">
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
								label-for="dev_unit"
								:label="$t('aplikasi.form.field.dev_unit.label')">
								<b-col sm="6">
									<validation-provider name="Unit Pengembang" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="dev_unit"
											:options="optionsPerangkatDaerah"
											v-model="unit_dev_selected"
											label="nama_opd"
											track-by="opd_id"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.dev_unit.placeholder')"
										>
										</m-select>
										<b-form-input
											v-else
											id="dev_unit"
											:value="unit_dev_selected ? unit_dev_selected.nama_opd : ''"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.dev_unit.placeholder')"
											:disabled="isDetail">
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
								label-for="oper_unit"
								:label="$t('aplikasi.form.field.oper_unit.label')">
								<b-col sm="6">
									<validation-provider name="Unit Operasional Teknologi" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="oper_unit"
											:options="optionsPerangkatDaerah"
											v-model="unit_oper_selected"
											label="nama_opd"
											track-by="opd_id"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.oper_unit.placeholder')"
										>
										</m-select>
										<b-form-input
											v-else
											id="oper_unit"
											:value="unit_oper_selected ? unit_oper_selected.nama_opd : ''"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.oper_unit.placeholder')"
											:disabled="isDetail">
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
								label-for="oper_status"
								:label="$t('aplikasi.form.field.oper_status.label')">
								<b-col sm="6">
									<validation-provider name="Status Operasional Aplikasi" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="oper_status"
											ref="oper_status"
											class="mb-2"
											:options="optionsOperStatus"
											v-model="model.status_oper"
											:placeholder="$t('aplikasi.form.field.oper_status.placeholder')"
											:allow-empty="false">     
										</m-select>
										<b-form-input
											v-else
											v-model="model.status_oper"
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
								label-for="dev_type"
								:label="$t('aplikasi.form.field.dev_type.label')">
								<b-col sm="6">
									<validation-provider name="Tipe Pengembangan Sistem Aplikasi" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="dev_type"
											ref="dev_type"
											class="mb-2"
											:options="optionsDevType"
											v-model="model.dev_type"
											:placeholder="$t('aplikasi.form.field.dev_type.placeholder')"
											:allow-empty="false">     
										</m-select>
										<b-form-input
											v-else
											v-model="model.dev_type"
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
								label-for="ots_name"
								:label="$t('aplikasi.form.field.comm_package.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.comm_package.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="ots_name"
											v-model="model.ots_name"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.comm_package.placeholder')"
											:disabled="isDetail">
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
								label-for="user_num"
								:label="$t('aplikasi.form.field.user_num.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.user_num.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="user_num"
											type="number"
											v-model="model.num_user"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.user_num.placeholder')"
											:disabled="isDetail">
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
								label-for="user_need_num"
								:label="$t('aplikasi.form.field.user_need_num.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.user_need_num.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="user_need_num"
											v-model="model.num_user_add"
											type="number"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.user_need_num.placeholder')"
											:disabled="isDetail">
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
								label-for="storage_capacity"
								:label="$t('aplikasi.form.field.storage_capacity.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.storage_capacity.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="storage_capacity"
											v-model="model.storage_need"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.storage_capacity.placeholder')"
											:disabled="isDetail">
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
								label-for="cpu_need"
								:label="$t('aplikasi.form.field.cpu_need.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.cpu_need.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="cpu_need"
											v-model="model.cpu_need"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.cpu_need.placeholder')"
											:disabled="isDetail">
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
								label-for="ram_need"
								:label="$t('aplikasi.form.field.ram_need.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.ram_need.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="ram_need"
											v-model="model.ram_need"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.ram_need.placeholder')"
											:disabled="isDetail">
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
								label-for="legal_basis"
								:label="$t('aplikasi.form.field.legal_basis.label')">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('aplikasi.form.field.legal_basis.label')"
										:debounce="250">				
										<b-form-textarea
											id="legal_basis"
											v-model="model.dasar_hukum"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.legal_basis.placeholder')"
											rows="3"
											max-rows="6"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!-- <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="conn_app"
								:label="$t('aplikasi.form.field.conn_app.label')">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('aplikasi.form.field.conn_app.label')"
										:debounce="250">				
										<b-form-textarea
											id="conn_app"
											v-model="model.rel_apl"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.conn_app.placeholder')"
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
								label-for="conn_data"
								:label="$t('aplikasi.form.field.conn_data.label')">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('aplikasi.form.field.conn_data.label')"
										:debounce="250">				
										<b-form-textarea
											id="conn_data"
											v-model="model.rel_data"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.conn_data.placeholder')"
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
								label-for="pj_conn_app"
								:label="$t('aplikasi.form.field.pj_conn_app.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.pj_conn_app.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<b-form-input
											id="pj_conn_app"
											v-model="model.unit_rel_ext"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.pj_conn_app.placeholder')"
											:disabled="isDetail">
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
								label-for="com_type"
								:label="$t('aplikasi.form.field.com_type.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.com_type.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="com_type"
											ref="com_type"
											class="mb-2"
											:options="optionsComType"
											v-model="model.kom_type"
											:placeholder="$t('aplikasi.form.field.com_type.placeholder')"
											:allow-empty="false">     
										</m-select>
										<b-form-input
											v-else
											v-model="model.kom_type"
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
								label-for="frequency"
								:label="$t('aplikasi.form.field.frequency.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.frequency.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail"
											id="frequency"
											ref="frequency"
											class="mb-2"
											:options="optionsFrequency"
											v-model="model.frekuensi"
											:placeholder="$t('aplikasi.form.field.frequency.placeholder')"
											:allow-empty="false">     
										</m-select>
										<b-form-input
											v-else
											v-model="model.frekuensi"
											:disabled="true">
										</b-form-input>

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group> -->

							<!-- <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="issue"
								:label="$t('aplikasi.form.field.issue.label')">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('aplikasi.form.field.issue.label')"
										:debounce="250">				
										<b-form-textarea
											id="issue"
											v-model="model.issues"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.issue.placeholder')"
											rows="3"
											max-rows="6"
											:state="errors[0] ? false : (valid ? true : null)"
											:disabled="isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group> -->

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="dev_plan"
								:label="$t('aplikasi.form.field.dev_plan.label')">
								<b-col sm="6">		
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										:name="$t('aplikasi.form.field.dev_plan.label')"
										:debounce="250">				
										<b-form-textarea
											id="dev_plan"
											v-model="model.dev_plan"
											:placeholder="isDetail? '' :$t('aplikasi.form.field.dev_plan.placeholder')"
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
								:label="$t('aplikasi.form.field.is_proper.label')" 
								label-cols="2"
								label-cols-lg="2"
							>
								<b-col sm="6">		
									<validation-provider
										rules="required"
										v-slot="{ valid, errors }"
										:name="'Apakah Merupakan Proyek Perubahan'"
										:debounce="250"
									>
										<b-form-radio-group
											v-model="model.proper"
											:options="['YA', 'TIDAK']"
											name="is_proper"
											id="is_proper"
											plain
											:disabled="isDetail"
										></b-form-radio-group>
										<b-form-invalid-feedback :state="errors[0] ? false : (valid ? true : null)">
										{{errors[0]}}
										</b-form-invalid-feedback>
									</validation-provider>
								</b-col>
							</b-form-group>
							
							<b-form-group
								v-if="isDetail || $app.user.is_admin"
								label-cols="2"
								label-cols-lg="2"
								label-for="tl_type"
								:label="$t('aplikasi.form.field.tl_type.label')">
								<b-col sm="6">
									<validation-provider :name="$t('aplikasi.form.field.tl_type.label')" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											v-if="!isDetail && $app.user.v_userid == 'admin'"
											id="tl_type"
											ref="tl_type"
											class="mb-2"
											:options="optionsTLType"
											v-model="model.jenis_tl"
											:placeholder="$t('aplikasi.form.field.tl_type.placeholder')"
											:allow-empty="false">     
										</m-select>
										<b-form-input
											v-else
											v-model="model.jenis_tl"
											:disabled="true">
										</b-form-input>

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
	name: 'AplikasiForm',
	data(){
		return{
			resourceName: 'aplikasi-detail-list',
			model: {
				apl_id: null,
				app_external: null,
				opd_input: null,
				opd: null,
				opd_id: null,
				url: null,
				app_ownership: null,
				raa_level_1: null,
				raa_level_2: null,
				raa_level_3: null,
       			raa_level_4: null,
				raa_level_1_nama: null,
				raa_level_2_nama: null,
				raa_level_3_nama: null,
       			raa_level_4_nama: null,
				nama_apl: null,
				deskripsi: null,
				fungsi: null,
				layanan: null,
				data: null,
				luaran: null,
				license: null,
				ots_name: null, 
				prog_lang: null,
				dev_framework: null,
				database: null,
				unit_dev: null,
				unit_oper: null,
				status_oper: null,
				dev_type: null,
				jenis_akses: null,
				jenis_akses_2: [],
				url:'',
				url_2_web: '',
				url_2_mobile_web: '',
				num_user: null,
				num_user_add: null,
				storage_need: null,
				ram_need: null,
				cpu_need: null,
				dasar_hukum: null,
				rel_apl: null,
				rel_data: null,
				unit_rel_ext: null,
				kom_type: null,
				frekuensi: null,
				issues: null,
				dev_plan: null,
				proper: null,
				jenis_tl: null,
				slug: this.$route?.params?.id,
			},
			instansi_selected: null,
			raa_l1_selected: null,
			raa_l2_selected: null,
			raa_l3_selected: null,
			raa_l4_selected: null,
			layanan_selected: null,
			unit_dev_selected: {},
			unit_oper_selected: {},
			data_selected: null,
			luaran_selected: null,
			ownership_selected: null,
			aplikasi_selected: null,
			optionsPerangkatDaerah: [],
			optionsRaaLevel1: [],
			optionsRaaLevel2: [],
			optionsRaaLevel3: [],
			optionsRaaLevel4: [],
			optionsAplikasi: [],
			optionsLicenseType: ['Open Source', 'Proprietary'],
			optionsAppOwnership: [
				{
					text: 'Pemilik Aplikasi',
					value: 'Pemilik'
				},
				{
					text: 'Pengguna Aplikasi Milik Eksternal',
					value: 'User'
				}
			],
			optionsJenisAkses: ['Web', 'Mobile Web', 'Mobile App', 'Desktop'],

			optionsLayanan: [],
			optionsData: [],
			optionsOperStatus: ['Dalam Pengembangan', 'Dalam Pengoperasian', 'Diam (Idle)'],
			optionsDevType: [
				'In-House - Dengan Pengembangan Sendiri', 
				'In-House - Menggunakan Source Code Lain', 
				'Outsourcing - Dengan Pengembangan Outsourcing', 
				'Outsourcing - Dengan Paket Komersil'
			],
			optionsComType: ['Mengirim', 'Menerima', 'Mengirim/Menerima'],
			optionsFrequency: ['Harian', 'Mingguan', 'Bulanan', 'Triwulanan', 'Tengah Tahunan', 'Tahunan', 'Berdasarkan Permintaan', 'Realtime'],
			optionsTLType: ['Consolidate', 'Develop', 'Enchance','Maintain', 'Replace', 'Sunset'],
			isDetail: false,
			title: 'Kendala Aplikasi',
			fields: [
				{
					key: 'rowaction',
					label: '',
					sortable: false,
					class: 'text-left'
				},
				{
					key: 'rownum',
					label: this.$t('domain.datatable.column.v_number'),
					sortable: false,
					class: 'text-left'
				},
				{
					key: 'nama_opd',
					label: 'OPD',
					sortable: false,
					class: 'text-left'
				},
				{
					key: 'app_ownership',
					label: 'Status Kepemilikan',
					sortable: false,
					class: 'text-left'
				},
				{
					key: 'issues',
					label: 'Kendala',
					sortable: false,
					class: 'text-left'
				}
			],
		}
	},
	computed: { 
		fieldsWithoutAction() {
			return this.fields.filter(item => item.key !== 'rowaction')
		},
		optionsJenisAkses2() {
			return this.optionsJenisAkses.filter(item => item !== this.model.jenis_akses)
		},
		isWeb() {
			return this.model.jenis_akses_2.find(item => item == 'Web')
		},
		isMobileWeb() {
			return this.model.jenis_akses_2.find(item => item == 'Mobile Web')
		}
	},
	watch: {	
		'model.app_ownership':{
			handler: function(data){
				if (data) {
					if (data == 'Internal') {
						this.loadDataAplikasi()
						this.loadDataLayanan()
					}
				}
			},
		},
		'model.jenis_akses' : {
			handler: function(data, o){
				if (data && o) {
					console.log('data', data, o);
					this.model.jenis_akses_2 = []
					this.model.url_2_web = ''
					this.model.url_2_mobile_web = ''
				}
			},
		},
		'raa_l1_selected':{
			handler: function(data){
				if (data) {
					this.loadRef(2, data.kode).then(result => this.optionsRaaLevel2 = result)
				}
			},
		},
		'raa_l2_selected':{
			handler: function(data){
				if (data) {
					this.loadRef(3, data.kode).then(result => this.optionsRaaLevel3 = result)
				}
			},
		},
		'raa_l3_selected':{
			handler: function(data){
				if (data) {
					this.loadRef(4, data.kode).then(result => this.optionsRaaLevel4 = result)
				}
			},
		},
		'optionsRaaLevel1':{
			handler: function(data){
				if (data) {
					this.raa_l2_selected = null
					this.raa_l3_selected = null
					this.raa_l4_selected = null
					this.raa_l1_selected = this.model.raa_level_1 ? data.find(val => {
						return val.kode.indexOf(this.model.raa_level_1) !== -1
					}) : null
				}
			},
		},	
		'optionsRaaLevel2':{
			handler: function(data){
				if (data) {
					this.raa_l3_selected = null
					this.raa_l4_selected = null
					this.raa_l2_selected = this.model.raa_level_2 ? data.find(val => val.kode === this.model.raa_level_2) : null
				}
			},
		},
		'optionsRaaLevel3':{
			handler: function(data){
				if (data) {
					this.raa_l4_selected = null
					this.raa_l3_selected = this.model.raa_level_3 ? data.find(val => val.kode === this.model.raa_level_3) : null
				}
			},
		},
		'optionsRaaLevel4':{
			handler: function(data){
				if (data) {
					this.raa_l4_selected = this.model.raa_level_4 ? data.find(val => val.kode === this.model.raa_level_4) : null
				}
			},
		},		
		$route (to, from){
			this.initComponent()
		}
	},
	mounted (){
		let query_opd = this.$route.params.opd_id ? this.$route.params.opd_id : this.$app.user.opd_id
		let isAdd = this.$route.path.includes('add')
		this.resPerangkatDaerah()

		if (isAdd && !query_opd) {
			this.$app.alert.fire('Perhatian', 'Perangkat Daerah Belum Dipilih.' , 'warning').then(() => {
				this.$router.go(-1)
			})
		} else {
			this.model.opd_id = query_opd
			this.model.opd_input = query_opd
			this.resPerangkatDaerahById()
		}
	},
	created(){		
		this.initComponent()
	},
	methods :
	{	
		initComponent() {
			this.isDetail = this.$route.path.includes('detail')

			if (!this.isDetail) {
				this.loadDataLayanan()
				this.loadDataInformasi()
			}
			
			if (this.$route.params.id) {
				this.loadDomainAplikasi().then(() => {
					if (!this.isDetail) {
						this.loadRef(1).then(result => {
							this.optionsRaaLevel1 = result
						})
					}
				})
			} else {
				this.loadRef(1).then(result => {
					this.optionsRaaLevel1 = result
				})
			}
		},
		async resPerangkatDaerah(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {})).then((res) => {
				this.optionsPerangkatDaerah = res.data
			})
		},
		async loadDataAplikasi(){

			return this.$http.get(this.$app.route('domain-aplikasi.data-aplikasi', {})).then((res) => {
				this.optionsAplikasi = res.data
				// this.model.aplikasi_selected = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
		async loadDataLayanan(){
			let data = this.model.app_ownership == 'Eksternal' ? {opd_id:  this.model.opd_id} : {}
			return this.$http.get(this.$app.route('domain.data-layanan.get', data)).then((res) => {
				this.optionsLayanan = res.data
				// this.model.aplikasi_selected = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
		labelLayanan ({nama_layanan, akronim}) {
			return `${akronim} - ${nama_layanan}`
		},
		labelData ({nama_data, akronim}) {
			return `${akronim} - ${nama_data}`
		},
		// getLabelData({nama_data})
		async loadDataInformasi(){
			return this.$http.get(this.$app.route('domain-data-informasi.get-data-master', {})).then((res) => {
				this.optionsData = res.data
				// this.model.aplikasi_selected = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
		async resPerangkatDaerahById(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.model.opd_id})).then((res) => {
				this.model.opd = res.data[0] ? res.data[0].nama_opd : ''
			})
		},
		onBack() {
			this.$router.go(-1)
		},
		async loadDomainAplikasi(){
			const res = await this.$http.get(this.$app.route('domain-aplikasi.show', {id: this.model.slug}))
			
			if(res.data){
				let raa_lv1 = res.data.level_1
				let raa_lv2 = res.data.level_2
				let raa_lv3 = res.data.level_3

				this.optionsRaaLevel2 = raa_lv1 ? await this.loadRef(2, raa_lv1.split(' ')[0]) : [];
				this.optionsRaaLevel3 = raa_lv2 ? await this.loadRef(3, raa_lv2.split(' ')[0]) : [];
				this.optionsRaaLevel4 = raa_lv3 ? await this.loadRef(4, raa_lv3.split(' ')[0]) : []; 

				this.model	= { ...this.model, ...res.data }
				this.model.app_ownership = res.data.detail ? res.data.detail.app_ownership : null
				this.model.issues = res.data.detail ? res.data.detail.issues : null
					
				this.model.jenis_akses = res.data.url && res.data.url.includes('.') > 0 ? 'Web' : this.model.jenis_akses
				this.unit_dev_selected = this.model.unit_dev ? this.optionsPerangkatDaerah.find(val => val.opd_id === this.model.unit_dev) : null
				this.unit_oper_selected = this.model.unit_oper ? this.optionsPerangkatDaerah.find(val => val.opd_id === this.model.unit_oper) : null

				this.layanan_selected = res.data.layanan.map((item) => {
					return {...item, akronim: item.opd.akronim}
				})
				this.data_selected = res.data.data.map((item) => {
					return {...item, akronim: item.opd.akronim}
				})
				this.luaran_selected = res.data.luaran.map((item) => {
					return {...item, akronim: item.opd.akronim}
				})
				this.unit_dev_selected = res.data.unit_dev_opd
				this.unit_oper_selected = res.data.unit_oper_opd

				this.model.jenis_akses_2 = []
				res.data.aplikasi_basis.forEach(element => {
					this.model.jenis_akses_2.push(element.basis_aplikasi)

					if (element.basis_aplikasi == 'Web') {
						this.model.url_2_web = element.url
					} else if (element.basis_aplikasi == 'Mobile Web') {
						this.model.url_2_mobile_web = element.url
					}
				})
				console.log(this.model.jenis_akses_2);

				this.$root.$emit('bv::refresh::table', this.resourceName)
				this.raa_l1_selected 			= this.optionsRaaLevel1.find(data => data.kode_nama === res.data.raa_level_1)
				this.raa_l2_selected 			= this.optionsRaaLevel2.find(data => data.kode_nama === res.data.raa_level_2)
				this.raa_l3_selected 			= this.optionsRaaLevel3.find(data => data.kode_nama === res.data.raa_level_3)
				this.raa_l4_selected 			= this.optionsRaaLevel4.find(data => data.kode_nama === res.data.raa_level_4)
			} 
			else 
			{
				console.log('cant load data');
			}
		},

		setData() {
			let vm = this
			vm.model.raa_level_1 = vm.raa_l1_selected ? vm.raa_l1_selected.kode : ''
			vm.model.raa_level_4 = vm.raa_l4_selected ? vm.raa_l4_selected.kode : ''
			vm.model.raa_level_3 = vm.raa_l3_selected ? vm.raa_l3_selected.kode : ''
			vm.model.raa_level_2 = vm.raa_l2_selected ? vm.raa_l2_selected.kode : ''
			vm.model.layanan = vm.layanan_selected.length ? vm.layanan_selected.map(item=>item.layanan_id) : null
			vm.model.data = vm.data_selected.length ? vm.data_selected.map(item=>item.info_id) : null
			vm.model.luaran = vm.luaran_selected.length ? vm.luaran_selected.map(item=>item.info_id) : null
			vm.model.unit_dev = vm.unit_dev_selected ? vm.unit_dev_selected.opd_id : ''
			vm.model.unit_oper = vm.unit_oper_selected ? vm.unit_oper_selected.opd_id : ''
		},
		onSubmit(){
			this.setData()
			let vm 			= this	
			let isEdit 		= this.$route.path.includes('edit') 
			let url 		= vm.$app.route(isEdit ? 'domain-aplikasi.update' : 'domain-aplikasi.save')
			let frm 		= new FormData()
			let formData 	= vm.$app.objectToFormData(vm.model, frm)
			let method = 'post'
			vm.$app.confirm({
				text: vm.$t(`aplikasi.alert.confirm.${isEdit ? 'edit' : 'add'}`, {name: this.model.nama_apl}),
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
					vm.$app.alert.fire('Sukses', vm.$t(`aplikasi.alert.actions.${isEdit ? 'update' : 'store'}.success`), 'success');
					this.onBack()
				}
			})
		},				
		async loadRef(tingkat, kode=''){
			const res = await this.$http.get(this.$app.route('domain.data-ref.get', {kode: kode, tingkat: tingkat, kategori: 'raa'}))
			return res.data
		},
		async loadOpd() {
			const res = await this.$http.get(this.$app.route('opd.all'))
			return res.data
		},
		handleUpdate(item, index, $el) {
			this.$router.push({name: 'aplikasi-edit', params: { id: this.slug_path, opd_id: this.opd_id }})
		},
		getIdMetadataTerkait(){
			let vm = this
			vm.groupLoading = true
			vm.$http.get(vm.$app.route('infra-keamanan.get-data-by.get'), {
				params: {col: 'domain_code'}
			}).then(response => {
				const idMetadataTerkaitOption = [];
				response.data.map(function (value, key) {
					idMetadataTerkaitOption.push({ value: value.kode, label: value.kode_nama });
				});

				vm.optionsIdMetadataTerkait = idMetadataTerkaitOption
			})
		},
		handleDelete(item, index, $el) {
			let vm = this
			let url 	=  vm.$app.route('aplikasi.delete')
			let method = 'post'
			vm.$app.confirm({
				text: vm.$t('aplikasi.alert.confirm.drop', {name: item.nama}),
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

#is_proper .form-check {
	margin-right: 8px;
}

#app_ownership .form-check {
	margin-bottom: 8px;
}

</style>