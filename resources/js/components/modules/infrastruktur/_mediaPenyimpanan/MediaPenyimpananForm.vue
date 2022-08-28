<template>
	<div class="row">
		<div class="col-12">
			<section id="media-penyimpanan-form">
				<b-card class="mb-4 mt-3 rounded">
					<b-row>
						<b-col lg="12" md="12" sm="12" class="text-right">
							<button
								type="button"
								style="margin: 10px 15px 0px;"
								class="btn btn-danger btn-sm rounded waves-effect waves-themed"
								v-b-tooltip.hover.top="$t('general.button.back')"
                v-show="!isDetail"
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
								label-for="rai-level_1"
                class="ml-2"
								label="Referensi Arsitektur Infrastruktur Level 1">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 1" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_1"
											ref="rai-level_1"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel1"
											v-model="model.rai_level_1"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="true"
											label="rail"
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

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_2"
                class="ml-2"
								label="Referensi Arsitektur Infrastruktur Level 2">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 2" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_2"
											ref="rai-level_2"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel2"
											v-model="model.rai_level_2"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="true"
											label="rail"
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

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_3"
                class="ml-2"
								label="Referensi Arsitektur Infrastruktur Level 3">
								<b-col sm="6">
									<validation-provider name="Referensi Arsitektur Infrastruktur Level 3" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="rai-level_3"
											ref="rai-level_3"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsRaiLevel3"
											v-model="model.rai_level_3"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="true"
											label="rail"
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

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="rai-level_4"
                class="ml-2"
								label="Referensi Arsitektur Infrastruktur Level 4">
								<b-col sm="6">
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
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:allow-empty="false"
											:disabled="!isDetail"
                      label="rail"
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

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
                class="ml-2"
								label-for="nama"
								label="Nama Media Storage">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Nama Media Storage"
										:debounce="250">
										<b-form-input
											v-model="model.nama"
											:id="'nama'"
											placeholder="Nama Media Storage"
											:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
                class="ml-2"
								label-for="deskripsi"
								label="Deskripsi Data Storage">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Deskripsi Data Storage"
										:debounce="250">
										<b-form-textarea
											:id="'deskripsi'"
											v-model="model.deskripsi"
											placeholder="Deskripsi Data Storage"
											rows="3"
											max-rows="6"
            								:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
                class="ml-2"
								label-for="instansi"
								label="Instansi">
								<b-col sm="6">
                  <input v-model="model.instansi" type="hidden">
                  <ValidationProvider
                    rules="required" v-slot="{ valid, errors }"
                    :name="$t('domain.form.field.instansi.label')" :debounce="250">
                    <m-select
                      id="instansi" v-model="model.instansi" :options="options.instansi" :multiple="false"
                      :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                      :placeholder="$t('domain.form.field.instansi.placeholder')" label="akronim" track-by="value" :disabled="true"
                      :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                    </m-select>
                    <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                  </ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
                class="ml-2"
								label-for="data-digunakan"
								label="Data Yang Digunakan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Data Yang Digunakan"
										:debounce="250">
										<b-form-textarea
											:id="'data-digunakan'"
											v-model="model.data_used"
											placeholder="Data Yang Digunakan"
											rows="3"
											max-rows="6"
            								:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-textarea>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="kepemilikan"
                class="ml-2"
								label="Kepemilikan">
								<b-col sm="6">
									<validation-provider name="Kepemilikan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="kepemilikan"
											ref="kepemilikan"
											:option-height="73"
											:tabindex="7"
											:options="optionsKepemilikan"
											v-model="model.ownership"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
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

              <div v-if="model.ownership.length == '0'">
              </div>
              <div v-else>
                <span v-if="model.ownership.kode == 'Milik Sendiri'">
                  <b-form-group
                  label-cols="2"
                  label-cols-lg="2"
                  label-for="own_name2" :label="$t('domain.form.field.own_name.label')"
                  class="ml-2">
                    <b-col sm="6">
                      <ValidationProvider
                      rules="required" v-slot="{ valid, errors }"
                      :name="$t('domain.form.field.own_name.label')" :debounce="250">
                      <m-select
                        id="own_name2" v-model="model.own_name2" :options="options.own_name2" :multiple="false"
                        :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                        :placeholder="$t('domain.form.field.own_name.placeholder')" label="akronim" track-by="value" :disabled="true"
                        :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                      </m-select>
                      <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                      </ValidationProvider>
                    </b-col>
                  </b-form-group>
                </span>
                <span v-else>
                  <span v-if="model.ownership.kode === 'Milik Instansi Pemerintah Lain'">
                    <b-form-group
                    label-cols="2"
                    label-cols-lg="2"
                    class="ml-2" label-for="own_name3"
                    :label="$t('domain.form.field.own_name.label')">
                      <b-col sm="6">
                        <input v-model="model.own_name3" type="hidden">
                        <ValidationProvider
                          rules="required" v-slot="{ valid, errors }"
                          :name="$t('domain.form.field.own_name.label')" :debounce="250">
                          <m-select
                            id="own_name3" v-model="model.own_name3" :options="options.own_name3" :multiple="false" :disabled="!isDetail"
                            :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                            :placeholder="$t('domain.form.field.own_name.placeholder')" label="akronim" track-by="value"
                            :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                          </m-select>
                          <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                        </ValidationProvider>
                      </b-col>
                    </b-form-group>
                  </span>
                  <span v-else>
                    <b-form-group
                      label-cols="2"
                      label-cols-lg="2"
                      class="ml-2"
                      label-for="nama-pemilik"
                      label="Nama Pemilik">
                      <b-col sm="6">
                        <ValidationProvider
                          rules="required"
                          v-slot="{ valid, errors }"
                          name="Nama Pemilik"
                          :debounce="250">
                          <b-form-input
                            v-model="model.nama_owner"
                            :id="'nama-pemilik'"
                            placeholder="Nama Pemilik"
                            :state="errors[0] ? false : (valid ? true : null)"
                            :disabled="!isDetail">
                          </b-form-input>
                          <b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
                        </ValidationProvider>
                      </b-col>
                    </b-form-group>
                  </span>
                </span>
                <br>
              </div>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
                				class="ml-2"
								label-for="unit-pengelola"
								label="Unit Pengelola">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Unit Pengelola"
										:debounce="250">
										<b-form-input
											v-model="model.unit_pengelola"
											:id="'unit-pengelola'"
											placeholder="Unit Pengelola"
											:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="lokasi"
								class="ml-2"
								label="Lokasi Storage">
								<b-col sm="6">
									<validation-provider name="Lokasi Storage" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="lokasi"
											ref="lokasi"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsLokasi"
											v-model="model.lokasi"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
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
								label-for="software-used"
                class="ml-2"
								label="Perangkat Lunak Yang Digunakan">
								<b-col sm="6">
									<validation-provider name="Perangkat Lunak Yang Digunakan" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="software-used"
											ref="software-used"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsSoftwareUsed"
											v-model="model.software_used"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
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
                class="ml-2"
								label-for="kapasitas-penyimpanan"
								label="Kapasitas Penyimpanan">
								<b-col sm="6">
									<ValidationProvider
										rules="required"
										v-slot="{ valid, errors }"
										name="Kapasitas Penyimpanan"
										:debounce="250">
										<b-form-input
											v-model="model.kapasitas_penyimpanan"
											:id="'kapasitas-penyimpanan'"
											placeholder="Masukkan Kapasitas dalam dalam satuan GigaByte - GB"
                      type="number"
											:state="errors[0] ? false : (valid ? null : null)"
											:disabled="!isDetail">
										</b-form-input>
										<b-form-invalid-feedback class="ml-2">{{ errors[0] }}</b-form-invalid-feedback>
									</ValidationProvider>
								</b-col>
							</b-form-group>

							<!-- <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="metode-akses-data"
                class="ml-2"
								label="Metode Akses Data Sharing">
								<b-col sm="6">
									<validation-provider name="Metode Akses Data Sharing" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="metode-akses-data"
											ref="metode-akses-data"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsMetodeAksesData"
											v-model="model.metode_akses_data"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
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
							</b-form-group> -->

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-security"
                class="ml-2"
								label="ID Metadata Terkait (Perangkat Keamanan)"
								v-show="false">
								<b-col sm="6">
									<!-- <validation-provider name="ID Metadata Terkait (Perangkat Keamanan)" rules="required" v-slot="{ errors, ariaMsg }"> -->
										<m-select
											id="id-metadata-security"
											ref="id-metadata-security"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsIdMetadataSecurity"
											v-model="model.id_metadata_security"
											:custom-label="nameSelected"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
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

										<!-- <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider> -->
								</b-col>
							</b-form-group>

              <b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-keamanan"
                class="ml-2"
								label="ID Metadata Terkait (Perangkat Keamanan)">
								<b-col sm="6">
									<validation-provider name="ID Metadata Terkait (Perangkat Keamanan)" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="id-metadata-keamanan"
											ref="id-metadata-keamanan"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsIdMetadataKeamanan"
											v-model="model.id_metadata_keamanan"
                      label = "kode_nama"
                      track-by="kode_nama"
                      :multiple="true"
                      :taggable="true"
                      :close-on-select="false"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:disabled="!isDetail"
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

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

              <!-- <b-form-group label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-keamanan"
                class="ml-2"
								label="ID Metadata Terkait (Perangkat Keamanan)">
								<b-col sm="6">
                  <ValidationProvider
                    rules="required" v-slot="{ valid, errors }"
                    :name="'ID Metadata Terkait (Perangkat Keamanan)'" :debounce="250">
                    <m-select
                      id="id-metadata-keamanan"
											ref="id-metadata-keamanan"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsIdMetadataKeamanan"
											v-model="model.id_metadata_keamanan"
                      :multiple="true"
                      :close-on-select="false"
                      :clear-on-select="false"
                      :preserve-search="true"
                      :preselect-first="false"
                      :placeholder="'-- silahkan pilih --'"
                      label="metadata"
                      track-by="metadata"
                      :disabled="!isDetail"
                      :searchable="true"
                      :state="errors[0] ? false : (valid ? true : null)">
                    </m-select>
                    <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                  </ValidationProvider>
                </b-col>
              </b-form-group> -->

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="id-metadata-splp"
                class="ml-2"
								label="ID Metadata Terkait (SPLP)">
								<b-col sm="6">
									<validation-provider name="ID Metadata Terkait (SPLP/API)" rules="required" v-slot="{ errors, ariaMsg }">
										<m-select
											id="id-metadata-splp"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsIdMetadataSplp"
											v-model="model.id_metadata_splp"
                      label = "kode_nama"
                      track-by="kode_nama"
                      :multiple="true"
                      :taggable="true"
                      :close-on-select="false"
											placeholder="-- silahkan pilih --"
											:searchable="true"
											:limit="100"
											:options-limit="100"
											:disabled="!isDetail"
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

										<small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider>
								</b-col>
							</b-form-group>

							<b-form-group
								label-cols="2"
								label-cols-lg="2"
								label-for="referensi-tab-splp"
								label="Referensi dari SPLP"
								v-show="false">
								<b-col sm="6">
									<!-- <validation-provider name="Referensi dari SPLP" rules="required" v-slot="{ errors, ariaMsg }"> -->
										<m-select
											id="id-metadata-splp"
											ref="id-metadata-splp"
											class="mb-2"
											:option-height="73"
											:tabindex="7"
											:options="optionsReferensiTabSplp"
											v-model="model.referensi_tab_splp"
											label="metadata"
											select-label=""
											selected-label=""
											deselect-label=""
											track-by="kode_nama"
											placeholder="-- silahkan pilih --"
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

										<!-- <small v-bind="ariaMsg" style="color: #fd3995; width: 100%; font-size: .6875rem; margin-top: 0.325rem;">
											{{ errors[0] }}
										</small>
									</validation-provider> -->
								</b-col>
							</b-form-group>

							<div class="text-right mt-4 pt-3">
                <div class="col-7">
                  <b-button type="submit" variant="primary" v-show="isDetail">
                    <i class="fal fa-save"></i>
                    {{ $t('general.form.button_add') }}
                  </b-button>
                  <b-button ref="closebtn" variant="default" @click="$router.go(-1)" v-show="isDetail">
                    {{ $t('general.form.button_cancel') }}
                  </b-button>
                </div>
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
	name: 'JaringanIntraPemerintahForm',
	components: {
	},
	data(){
		return{
			mediaShow: false,
      form: {
      },
			model: {
				rai_level_1: [],
				rai_level_2: [],
				rai_level_3: [],
				rai_level_4: [],
				nama: '',
				deskripsi: '',
				instansi: [],
				data_used: '',
				ownership: [],
				nama_owner: '',
				own_name2: [],
        own_name3: [],
				unit_pengelola: '',
				lokasi: [],
				software_used: [],
				kapasitas_penyimpanan: '',
				// metode_akses_data: [],
				id_metadata_security: [],
				id_metadata_splp: [],
				id_metadata_keamanan: [],
				referensi_tab_splp: [],
				id: this.$route?.params?.id,
				status: this.$route?.params?.status,
			},
			options: {
				instansi: [],
				own_name2: [],
				own_name3: [],
			},
			optionsRaiLevel1: [],
			optionsRaiLevel2: [],
			optionsRaiLevel3: [],
			optionsRaiLevel4: [],
			optionsKepemilikan:[
				{kode: "Milik Sendiri", kode_nama: "Milik Sendiri"},
				{kode: "Milik Instansi Pemerintah Lain", kode_nama: "Milik Instansi Pemerintah Lain"},
				{kode: "Milik BUMN", kode_nama: "Milik BUMN"},
				{kode: "Milik Pihak Ketiga - Dalam Negeri", kode_nama: "Milik Pihak Ketiga - Dalam Negeri"},
				{kode: "Milik Pihak Ketiga - Luar Negeri", kode_nama: "Milik Pihak Ketiga - Luar Negeri"}
			],
			optionsLokasi: [],
			optionsSoftwareUsed: [],
			// optionsMetodeAksesData: [
			// 	{kode: "Direct Attached Storage (DAS)", kode_nama: "Direct Attached Storage (DAS)"},
			// 	{kode: "Network Attached Storage (NAS)", kode_nama: "Network Attached Storage (NAS)"},
			// 	{kode: "Storage Area Network (SAN)", kode_nama: "Storage Area Network (SAN)"},
			// ],
			optionsIdMetadataSecurity: [],
			optionsIdMetadataKeamanan:[],
			optionsIdMetadataSplp:[],
			optionsReferensiTabSplp:[],
			isDetail: false,
		}
	},
	computed: { },
	watch: {
	},
	mounted:function(){ },
	created(){
		this.resRal('',1).then((data) =>{this.optionsRaiLevel1 = data})
    this.resRal('',2).then((data) =>{this.optionsRaiLevel2 = data})
    this.resRal('',3).then((data) =>{this.optionsRaiLevel3 = data})
    this.resRal('03.01.02',4).then((data) =>{this.optionsRaiLevel4 = data})
		this.resFasilitas().then((data) => {this.optionsLokasi = data})
		this.resSoftware().then((data) => {this.optionsSoftwareUsed = data})
		this.resMetadataKeamanan().then((data) => {this.optionsIdMetadataKeamanan = data})
		this.resMetadataSplp().then((data) => {this.optionsIdMetadataSplp = data})
    this.getRail1Def();
    this.getOwnerName();
    if(this.$route.params.status == 'edit' || this.$route.params.status == 'detail'){
      this.resDomainInfraStorage()
    }
		this.isDetail = (this.model.status == 'detail')?false:true
	},
	methods :
	{
		onBack() {
			this.$router.push({ name: 'infrastruktur.media-penyimpanan',
      params: {
        'opd_id' : this.$route.params.opd_id
      }
      })
		},
		onSubmit(){
			let vm 			= this
      		let routeName 	= vm.model.status ? 'media-penyimpanan.update-data-domain-infra-storage' : 'media-penyimpanan.simpan-data-domain-infra-storage'
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
		async resDomainInfraStorage(){
      const res = await this.$http.get(this.$app.route('media-penyimpanan.search-intra-storage.get', {id_storage: this.model.id}))
			if(res.data){
        console.log(res.data)
				this.model.id					= res.data.id
        let rail4 = _.find(this.optionsRaiLevel4, function(o) { return o.rail = res.data.rai_level_4 })
        this.$set(this.model, 'rai_level_4', rail4)
				this.model.nama 				= res.data.nama
				this.model.deskripsi 			= res.data.deskripsi
				this.model.data_used 			= res.data.data_used
				this.model.ownership 			= this.optionsKepemilikan.find(data => data.kode === res.data.ownership);
        if(res.data['ownership'] === 'Milik Sendiri'){
          this.resMilikOPD()
        }else{
          if(res.data['ownership'] === 'Milik Instansi Pemerintah Lain'){
            let own_name3 = _.find(this.options.own_name3, function(o) { return o.akronim = res.data['nama_owner'] ; })
            this.model.own_name3 = own_name3
          }else{
            this.model.nama_owner = res.data.nama_owner
          }
        }
				this.model.nama_owner 			= res.data.nama_owner
				this.model.unit_pengelola 		= res.data.unit_pengelola
				this.model.lokasi 				= this.optionsLokasi.find(data => data.kode === res.data.lokasi);
				this.model.software_used 		= this.optionsSoftwareUsed.find(data => data.kode === res.data.software_used);
				this.model.kapasitas_penyimpanan = res.data.kapasitas_penyimpanan;
				// this.model.metode_akses_data 	= this.optionsMetodeAksesData.find(data => data.kode === res.data.metode_akses_data);
				this.model.referensi_tab_splp 	= this.optionsReferensiTabSplp.find(data => data.kode === res.data.referensi_tab_splp);
        this.resInstansi(res.data.opd_id)
        this.resMetadataKeamananDetail(res.data.id)
        this.resMetadataSplpDetail(res.data.id)
			}
		},
    async resInstansi(opd_id){
			const res = await this.$http.get(this.$app.route('media-penyimpanan.get_detail_instansi', {opd_id : opd_id}))
      let result = res.data[0]
      let instansi = _.find(this.options.instansi, function(o) { return o.akronim = result['akronim'] ; })
      this.$set(this.model, 'instansi', instansi)
		},
    nameSelected({kode_nama}){
      return `${kode_nama}`
    },
    async resMetadataKeamananDetail(id){
			const res = await this.$http.get(this.$app.route('media-penyimpanan.metadata_keamanan.get', {id_storage: id}))
      let result = res.data
      let metadata_id = [];

      result.map(function (value, key) {
        metadata_id.push({ kode_nama: value.kode_nama });
      });

      this.model.id_metadata_keamanan = metadata_id
		},
    async resMetadataSplpDetail(id){
			const res = await this.$http.get(this.$app.route('media-penyimpanan.metadata_splp.get', {id_storage: id}))
      let result = res.data
      let metadata_id = [];

      result.map(function (value, key) {
        metadata_id.push({ kode_nama: value.kode_nama });
      });
      this.model.id_metadata_splp = metadata_id
		},
		async resRal(kode, tingkat, kode_nama=''){
			const res = await this.$http.get(this.$app.route('domain.data-ral.get', {kode: kode, tingkat: tingkat, kode_nama:kode_nama, kategori:'rai'}))
			return res.data
		},
    async getRail1Def() {
      const res = await this.$http.get(this.$app.route('media-penyimpanan.get_rail1'))
      let result = res.data.data[0]
      let rail1 = _.find(this.optionsRaiLevel1, function(o) { return o.rail = result['rail'] ; })
      this.$set(this.model, 'rai_level_1', rail1)
      this.getRail2Def();
    },
    async getRail2Def() {
      const res = await this.$http.get(this.$app.route('media-penyimpanan.get_rail2'))
      let result = res.data.data[0]
      let rail2 = _.find(this.optionsRaiLevel2, function(o) { return o.rail = result['rail'] ; })
      this.$set(this.model, 'rai_level_2', rail2)
      this.getRail3Def();
    },
    async getRail3Def() {
      const res = await this.$http.get(this.$app.route('media-penyimpanan.get_rail3'))
      let result = res.data.data[0]
      let txt = 'rail'
      let rail3 = _.find(this.optionsRaiLevel3, function(o) { return o.rail = result[txt] ; })
      this.$set(this.model, 'rai_level_3', rail3)
    },
		async resFasilitas(){
			const res = await this.$http.get(this.$app.route('fasilitas.get-domain-code.get', {col:'nama'}))
			return res.data
		},
		async resSoftware(){
			const res = await this.$http.get(this.$app.route('perangkat-lunak.get-data-by.get', {col:'nama'}))
			return res.data
		},
		async resMetadataSplp(){
      let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('perangkat-lunak.get-metadata-splp-by.get'), {
        params: {}
      }).then(response => {
        const optionsSplp = [];
        response.data.map(function (value, key) {
          optionsSplp.push({ value: value.kode, kode_nama: value.kode_nama });
        });
        vm.optionsIdMetadataSplp = optionsSplp
      })
		},
		async resMetadataKeamanan(){
			let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('perangkat-lunak.get-metadata-keamanan-by.get'), {
        params: {}
      }).then(response => {
        const optionsKeamanan = [];
        response.data.map(function (value, key) {
          optionsKeamanan.push({ value: value.kode, kode_nama: value.kode_nama });
        });
        vm.optionsIdMetadataKeamanan = optionsKeamanan
      })
		},
    getOwnerName(){
			let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('sistem-penghubung-layanan-pemerintah.get_owner'), {
        params: {opd_id : this.$route.params.opd_id}
      }).then(response => {
        const own3Option = [];
        response.data.map(function (value, key) {
          own3Option.push({ value: [value.opd_id, value.akronim], akronim: value.akronim });
        });
        own3Option.push({ value: ['Lainnya', 'Lainnya'], akronim: 'Lainnya'});
        vm.options.own_name3 = own3Option
        this.getInstansi()
      })
		},
    getInstansi(){
			let vm = this
      vm.groupLoading = true
      vm.$http.get(vm.$app.route('perangkat-jaringan.data-perangkat-daerah.get'), {
        params: {opd_id : this.$route.params.opd_id}
      }).then(response => {
        const own2Option = [];
        response.data.map(function (value, key) {
          own2Option.push({ value: [value.opd_id, value.akronim], akronim: value.akronim });
        });
        vm.options.own_name2 =own2Option
        vm.options.instansi = own2Option
        this.resMilikOPD()
      })
		},
    async resMilikOPD() {
	    const res = await this.$http.get(this.$app.route('perangkat-jaringan.data-perangkat-daerah.get', {opd_id : this.$route.params.opd_id}))
      let result = res.data[0]
      let instansi = _.find(this.options.own_name2, function(o) { return o.akronim = result['akronim'] ; })
      this.$set(this.model, 'own_name2', instansi)
      this.$set(this.model, 'instansi', instansi)
    },
	},
}
</script>

<style>
#app {
  margin: 20px;
}
</style>
