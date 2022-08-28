<template>
  <b-card class="p-3">
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <template>
          <div v-if="$route.params.status == 'update'">
            <b-form-group label-for="unit" :label="$t('domain.form.field.unit.label')">
              <input v-model="form.opd_id" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.unit.label')" :debounce="250">
                <b-form-input
                  :id="'unit'"
                  v-model="form.nama_opd"
                  :disabled="true"
                  :placeholder="$t('domain.form.field.data_name.placeholder')">
                </b-form-input>
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="radl1" :label="$t('domain.form.field.radl1.label')">
              <input v-model="form.radl1" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.radl1.label')" :debounce="250">
                <m-select
                  id="radl1" v-model="form.radl1" :options="options.radl1" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.radl1.placeholder')" label="kode_nama" track-by="kode"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="radl2" :label="$t('domain.form.field.radl2.label')">
              <input v-model="form.radl2" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.radl2.label')" :debounce="250">
                <m-select
                  id="radl2" v-model="form.radl2" :options="options.radl2" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.radl2.placeholder')" label="kode_nama" track-by="kode"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="radl3" :label="$t('domain.form.field.radl3.label')">
              <input v-model="form.radl3" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.radl2.label')" :debounce="250">
                <m-select
                  id="radl3" v-model="form.radl3" :options="options.radl3" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.radl2.placeholder')" label="kode_nama" track-by="kode"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group
              label-for="nama_data"
              :label="$t('domain.form.field.data_name.label')">
              <ValidationProvider
                rules="required" v-slot="{errors }"
                :name="$t('domain.form.field.data_name.label')" :debounce="250">
                <b-form-input
                  :id="'nama_data'"
                  v-model="form.nama_data"
                  :placeholder="$t('domain.form.field.data_name.placeholder')">
                </b-form-input>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            
            <b-form-group label-for="probis_terkait" :label="$t('domain.form.field.probis_terkait.label')">
              <input v-model="form.probis_terkait" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.probis_terkait.label')" :debounce="250">
                <m-select
                  id="probis_terkait" v-model="form.probis_terkait" :options="options.probis_terkait" :multiple="true"
                  :close-on-select="false" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.probis_terkait.placeholder')" label="probis" track-by="key"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
          </div>
          <div v-else>
            <b-form-group label-for="unit" :label="$t('domain.form.field.unit.label')">
              <input v-model="form.opd_id" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.unit.label')" :debounce="250">
                <b-form-input
                  :id="'unit'"
                  :disabled="true"
                  v-model="form.nama_opd"
                  :placeholder="$t('domain.form.field.data_name.placeholder')">
                </b-form-input>
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="radl1" :label="$t('domain.form.field.radl1.label')">
              <input v-model="form.radl1" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.radl1.label')" :debounce="250">
                <m-select
                  id="radl1" v-model="form.radl1" :options="options.radl1" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.radl1.placeholder')" label="kode_nama" track-by="kode"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="radl2" :label="$t('domain.form.field.radl2.label')">
              <input v-model="form.radl2" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.radl2.label')" :debounce="250">
                <m-select
                  id="radl2" v-model="form.radl2" :options="options.radl2" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.radl2.placeholder')" label="kode_nama" track-by="kode"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="radl3" :label="$t('domain.form.field.radl3.label')">
              <input v-model="form.radl3" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.radl2.label')" :debounce="250">
                <m-select
                  id="radl3" v-model="form.radl3" :options="options.radl3" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.radl2.placeholder')" label="kode_nama" track-by="kode"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
            
            <b-form-group
              label-for="nama_data"
              :label="$t('domain.form.field.data_name.label')">
              <ValidationProvider
                rules="required" v-slot="{errors }"
                :name="$t('domain.form.field.data_name.label')" :debounce="250">
                <b-form-input
                  :id="'nama_data'"
                  v-model="form.nama_data"
                  :placeholder="$t('domain.form.field.data_name.placeholder')">
                </b-form-input>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="probis_terkait" :label="$t('domain.form.field.probis_terkait.label')">
              <input v-model="form.probis_terkait" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.probis_terkait.label')" :debounce="250">
                <m-select
                  id="probis_terkait" v-model="form.probis_terkait" :options="options.probis_terkait" :multiple="true"
                  :close-on-select="false" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                  :placeholder="$t('domain.form.field.probis_terkait.placeholder')" label="probis" track-by="key"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <br>

            <h4>Detail Data dan Informasi</h4>

            <br>
            <b-form-group b-form-group
              label-for="desc_data"
              :label="$t('domain.form.field.desc_data.label')">
              <ValidationProvider
                rules="required" v-slot="{ errors }"
                :name="$t('domain.form.field.desc_data.label')" :debounce="250">
                <b-form-textarea
                  :id="'desc_data'"
                  v-model="form.desc_data"
                  rows="3"
                  max-rows="6"
                  :placeholder="$t('domain.form.field.desc_data.placeholder')">
                </b-form-textarea>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group b-form-group
              label-for="dest_data"
              :label="$t('domain.form.field.dest_data.label')">
              <ValidationProvider
                rules="required" v-slot="{ errors }"
                :name="$t('domain.form.field.dest_data.label')" :debounce="250">
                <b-form-textarea
                  :id="'dest_data'"
                  v-model="form.dest_data"
                  rows="3"
                  max-rows="6"
                  :placeholder="$t('domain.form.field.dest_data.placeholder')">
                </b-form-textarea>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group b-form-group
              label-for="comp_data"
              :label="$t('domain.form.field.comp_data.label')">
              <ValidationProvider
                rules="required" v-slot="{ errors }"
                :name="$t('domain.form.field.comp_data.label')" :debounce="250">
                <b-form-textarea
                  :id="'comp_data'"
                  v-model="form.comp_data"
                  rows="3"
                  max-rows="6"
                  :placeholder="$t('domain.form.field.comp_data.placeholder')">
                </b-form-textarea>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="prop_data" :label="$t('domain.form.field.prop_data.label')">
              <input v-model="form.prop_data" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.prop_data.label')" :debounce="250">
                <m-select
                  id="prop_data" v-model="form.prop_data" :options="options.prop_data" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                  :placeholder="$t('domain.form.field.prop_data.placeholder')" label="value" track-by="value"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="type_data1" :label="$t('domain.form.field.type_data1.label')">
              <input v-model="selected.type_data1" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.type_data1.label')" :debounce="250">
                <m-select
                  id="type_data1" v-model="selected.type_data1" :options="options.type_data1" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                  :placeholder="$t('domain.form.field.type_data1.placeholder')" label="value" track-by="value"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <div v-if="selected.type_data1 !== null">
              <div v-if="selected.type_data1.label === 'Unstructured'">
                <b-form-group label-for="format_unstruct" :label="$t('domain.form.field.format_unstruct.label')">
                  <input v-model="selected.format_unstruct" type="hidden">
                  <ValidationProvider
                    rules="required" v-slot="{ valid, errors }"
                    :name="$t('domain.form.field.format_unstruct.label')" :debounce="250">
                    <m-select
                      id="format_unstruct" v-model="selected.format_unstruct" :options="options.format_unstruct" :multiple="false"
                      :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                      :placeholder="$t('domain.form.field.format_unstruct.placeholder')" label="value" track-by="value"
                      :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                    </m-select>
                    <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                  </ValidationProvider>
                </b-form-group>
              </div>
              <div v-else>
                <b-form-group label-for="format_struct" :label="$t('domain.form.field.format_struct.label')">
                  <input v-model="selected.format_struct" type="hidden">
                  <ValidationProvider
                    rules="required" v-slot="{ valid, errors }"
                    :name="$t('domain.form.field.format_struct.label')" :debounce="250">
                    <m-select
                      id="format_struct" v-model="selected.format_struct" :options="options.format_struct" :multiple="false"
                      :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                      :placeholder="$t('domain.form.field.format_struct.placeholder')" label="value" track-by="value"
                      :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                    </m-select>
                    <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                  </ValidationProvider>
                </b-form-group>
              </div>
            </div>

            <div v-if="selected.format_struct !== null">
              <div v-if="selected.format_struct.label === 'Lainnya'" class="mb-4">
                <b-form-group
                  label-for="format"
                  :label="$t('domain.form.field.format.label')">
                  <ValidationProvider
                    rules="required" v-slot="{errors }"
                    :name="$t('domain.form.field.format.label')" :debounce="250">
                    <b-form-input
                      :id="'format'"
                      v-model="form.format"
                      :placeholder="$t('domain.form.field.format.placeholder')">
                    </b-form-input>
                    <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                  </ValidationProvider>
                </b-form-group>
              </div>
            </div>

            <div v-if="selected.format_unstruct !== null">
              <div v-if="selected.format_unstruct.label === 'Lainnya'" class="mb-4">
                <b-form-group
                  label-for="format"
                  :label="$t('domain.form.field.format.label')">
                  <ValidationProvider
                    rules="required" v-slot="{errors }"
                    :name="$t('domain.form.field.format.label')" :debounce="250">
                    <b-form-input
                      :id="'format'"
                      v-model="form.format"
                      :placeholder="$t('domain.form.field.format.placeholder')">
                    </b-form-input>
                    <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                  </ValidationProvider>
                </b-form-group>
              </div>
            </div>

            <b-form-group label-for="type_data2" :label="$t('domain.form.field.type_data2.label')">
              <input v-model="selected.type_data2" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.type_data2.label')" :debounce="250">
                <m-select
                  id="type_data2" v-model="selected.type_data2" :options="options.type_data2" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                  :placeholder="$t('domain.form.field.type_data2.placeholder')" label="value" track-by="value"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <div v-if="selected.type_data2 !== null">
              <div v-if="selected.type_data2.label === 'Data Induk Lainnya'" class="mb-4">
                <b-form-group
                  label-for="type_data2_other"
                  :label="$t('domain.form.field.type_data2_other.label')">
                  <ValidationProvider
                    rules="required" v-slot="{errors }"
                    :name="$t('domain.form.field.type_data2_other.label')" :debounce="250">
                    <b-form-input
                      :id="'type_data2_other'"
                      v-model="form.type_data2_other"
                      :placeholder="$t('domain.form.field.type_data2_other.placeholder')">
                    </b-form-input>
                    <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                  </ValidationProvider>
                </b-form-group>
              </div>
            </div>

            <b-form-group
              label-for="validitas_data"
              :label="$t('domain.form.field.validitas_data.label')">
              <ValidationProvider
                rules="required" v-slot="{errors }"
                :name="$t('domain.form.field.validitas_data.label')" :debounce="250">
                <b-form-input
                  :id="'validitas_data'"
                  v-model="form.validitas_data"
                  :placeholder="$t('domain.form.field.validitas_data.placeholder')">
                </b-form-input>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group
              label-for="penanggung_jawab"
              :label="$t('domain.form.field.penanggung_jawab.label')">
              <ValidationProvider
                rules="required" v-slot="{errors }"
                :name="$t('domain.form.field.penanggung_jawab.label')" :debounce="250">
                <b-form-input
                  :id="'penanggung_jawab'"
                  v-model="form.penanggung_jawab"
                  :placeholder="$t('domain.form.field.penanggung_jawab.placeholder')">
                </b-form-input>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group
              label-for="interoperabilitas"
              :label="$t('domain.form.field.interoperabilitas.label')">
              <validation-provider name="Interoperabilitas Data" rules="required" v-slot="{ errors, ariaMsg }">
                <m-select
                  id="data"
                  ref="data"
                  class="mb-2"
                  :multiple="true" 
                  :close-on-select="false" 
                  :clear-on-select="false"
                  :option-height="73"
                  :tabindex="7"
                  :options="options.data"
                  v-model="selected.interoperabilitas"
                  :custom-label="labelData"
                  :placeholder="$t('domain.form.field.interoperabilitas.placeholder')"
                  track-by="info_id"
                  :searchable="true"	
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
            </b-form-group>

            <b-form-group label-for="resiko" :label="$t('domain.form.field.resiko.label')">
              <input v-model="form.resiko" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.resiko.label')" :debounce="250">
                <m-select
                  id="resiko" v-model="form.resiko" :options="options.resiko" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                  :placeholder="$t('domain.form.field.resiko.placeholder')" label="value" track-by="value"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="level_data" :label="$t('domain.form.field.level_data.label')">
              <input v-model="form.level_data" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.level_data.label')" :debounce="250">
                <m-select
                  id="level_data" v-model="form.level_data" :options="options.level_data" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                  :placeholder="$t('domain.form.field.level_data.placeholder')" label="value" track-by="value"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group label-for="pengambilan_data" :label="$t('domain.form.field.pengambilan_data.label')">
              <input v-model="form.pengambilan_data" type="hidden">
              <ValidationProvider
                rules="required" v-slot="{ valid, errors }"
                :name="$t('domain.form.field.pengambilan_data.label')" :debounce="250">
                <m-select
                  id="pengambilan_data" v-model="form.pengambilan_data" :options="options.pengambilan_data" :multiple="false"
                  :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="false"
                  :placeholder="$t('domain.form.field.pengambilan_data.placeholder')" label="value" track-by="value"
                  :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
                </m-select>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>

            <b-form-group
              label-for="jml_record"
              :label="$t('domain.form.field.jml_record.label')">
              <ValidationProvider
                rules="required" v-slot="{errors }"
                :name="$t('domain.form.field.jml_record.label')" :debounce="250">
                <b-form-input
                  :id="'jml_record'"
                  v-model="form.jml_record"
                  type="number"
                  :placeholder="$t('domain.form.field.jml_record.placeholder')">
                </b-form-input>
                <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
              </ValidationProvider>
            </b-form-group>
          </div>

        </template>

        <div class="text-right mt-4 pt-3">
          <b-button type="submit" variant="primary">
            {{ $t('general.form.button_add') }}
          </b-button>
          <b-button ref="closebtn" variant="default" @click="$router.go(-1)">
            {{ $t('general.form.button_cancel') }}
          </b-button>
        </div>
      </form>
    </validation-observer>
    <div v-if="this.$route.params.status == 'update'">
      <data-tables style="margin-top:50px"
        id="datainfotable" :fields="fields2"
        api-url="domain-data-informasi.get_detail_data" :title="'Daftar Data Informasi'"
        :args-route="{'info_id': this.$route.params.info_id}"
        :actions="!(isUpdate && canModify)? 'SL' : 'SCRLUD'"
        @detail="handleDetail"
        row-action-width="10%">
      </data-tables>
    </div>
    <div v-else>

    </div>
  </b-card>
</template>

<script>
export default {
  name: 'DomainDataInformasiForm',
  props: {
    props: ['info_id', 'opd_id', 'status'],
  },
  data() {
    let resourceName = 'domain-data-informasi';
    return {
      fields2: [
        {
          key: 'rowaction',
          label: '',
          sortable: false,
          class: 'text-center',
        },
        {
          key: 'rad_level_1',
          label: "RAD Level 1",
          sortable: true,
        },
        {
          key: 'rad_level_2',
          label: 'RAD Level 2',
          sortable: true,
        },
        {
          key: 'uraian_data',
          label: "Uraian Data",
          sortable: true,
        },
        {
          key: 'tujuan_data',
          label: 'Tujuan Data',
          sortable: true,
        },
        {
          key: 'sifat_data',
          label: "Sifat Data",
          sortable: true,
        },
        {
          key: 'komponen_data',
          label: 'Komponen Data',
          sortable: true,
        },
        {
          key: 'jenis_data1',
          label: "Jenis Data 1",
          sortable: true,
        },
        {
          key: 'jenis_data2',
          label: 'Jenis Data 2',
          sortable: true,
        },
        {
          key: 'data_owner',
          label: "Penanggung Jawab",
          sortable: true,
        },
      ],
      form: {
        nama_data: null,
      },
      show: true,
      title: '',
      querySearch: '',
      rulesForPassword: '',
      rulesForPasswordConfirmed: '',
      resourceName: resourceName,
      routeName: `${resourceName}`,
      model: {
        proses_id : null,
      },
      checkedNodes: [],
      form: {
        opd_id: null,
        nama_opd: null,
        radl1: null,
        radl2: null,
        radl3: null,
        selected: null,
        id_opd: null,
        nama_data: null,
        desc_data: null,
        dest_data: null,
        comp_data: null,
        format: null,
        type_data2_other: null,
        validitas_data: null,
        penanggung_jawab: null,
        probis_terkait: null,

      },
      statusOptions: [
        { id: 1, name: 'Aktif' },
        { id: 0, name: 'Tidak Aktif' },
      ],
      fieldTypePasword: 'password',
      iconPassword: 'fa-eye-slash',
      fieldTypePaswordConfirm: 'password',
      iconPasswordConfirm: 'fa-eye-slash',
      selected: {
        radl1: null,
        radl2: null,
        radl3: null,
        prop_data: null,
        type_data1: null,
        format_struct: null,
        format_unstruct: null,
        type_data2: null,
        resiko: null,
        level_data: null,
        pengambilan_data: null,
        interoperabilitas: null
      },
      options: {
        unit: [],
        radl1: [],
        radl2: [],
        radl3: [],
        probis_terkait: [],
        data: [],
        prop_data: [
          { value: 'Sangat Rahasia', label: 'Sangat Rahasia' },
          { value: 'Rahasia', label: 'Rahasia' },
          { value: 'Terbatas', label: 'Terbatas' },
          { value: 'Publik/Umum', label: 'Publik/Umum'}
        ],
        type_data1: [
          { value: 'Structured', label: 'Structured' },
          { value: 'Unstructured', label: 'Unstructured' }
        ],
        format_struct: [
          { value: 'Database', label: 'Database' },
          { value: 'Spreadsheet', label: 'Spreadsheet' },
          { value: 'Lainnya', label: 'Lainnya' }
        ],
        format_unstruct: [
          { value: 'Gambar', label: 'Gambar' },
          { value: 'Video', label: 'Video' },
          { value: 'Dokumen', label: 'Dokumen' },
          { value: 'Geospasial', label: 'Geospasial' },
          { value: 'Text', label: 'Text' },
          { value: 'Lainnya', label: 'Lainnya' }
        ],
        type_data2: [
          { value: 'Data Induk Statistik', label: 'Data Induk Statistik' },
          { value: 'Data Induk Geospasial', label: 'Data Induk Geospasial' },
          { value: 'Data Induk Keuangan', label: 'Data Induk Keuangan' },
          { value: 'Data Induk Lainnya', label: 'Data Induk Lainnya' },
        ],
        resiko: [
          { value: 'Finansial', label: 'Finansial' },
          { value: 'Reputasi', label: 'Reputasi' },
          { value: 'Kinerja', label: 'Kinerja' },
          { value: 'Layanan Organisasi', label: 'Layanan Organisasi' },
          { value: 'Operasional dan Aset TIK', label: 'Operasional dan Aset TIK' },
          { value: 'Hukum dan Regulasi', label: 'Hukum dan Regulasi' },
          { value: 'Sumber Daya Manusia', label: 'Sumber Daya Manusia' },
        ],
        level_data: [
          { value: 'Nasional', label: 'Nasional' },
          { value: 'Daerah', label: 'Daerah' },
          { value: 'OPD', label: 'OPD' },
          { value: 'Bidang', label: 'Bidang' },
          { value: 'Seksi', label: 'Seksi' },
        ],
        pengambilan_data: [
          { value: 'Antarmuka dengan sistem lain', label: 'Antarmuka dengan sistem lain' },
          { value: 'Direct Input', label: 'Direct Input' },
        ],
      },
    }
  },
  computed: {
    canModify() {
      return (this.form.opd_id==this.$app.user?.opd_id) || this.$app.user.is_admin
    },
    isNew() {
      return this.$route.params.info_id === undefined ? true : false
    }
  },
  watch: {
    'form.radl1':{
			handler: function(data, old){
				if (data && (data !== old)) {
					this.getRadl2(data.kode)
				}
			},
		},
    'form.radl2':{
			handler: function(data, old){
				if (data && (data !== old)) {
					this.getRadl3(data.kode)
				}
			},
		},
	},
  created() {
    let query_opd = this.$route.params.opd_id ? this.$route.params.opd_id : this.$app.user.opd_id
    this.form.opd_id = query_opd
    this.resPerangkatDaerahById()

    
    this.isUpdate = (this.$route.params.status == 'update')?false:true
    if(this.$route.params.status == 'update'){
      this.resDataInformasi();
    }
    this.getRadl1();
    this.getProbis();
    this.fetchProbis()
    this.getUnit();
    this.loadDataInformasi()
    },
  methods: {
    labelData ({nama_data, akronim}) {
			return `${akronim} - ${nama_data}`
		},
    handleDetail(item) {
      this.$router.push({ name: 'domain-data-informasi-detail-detail', params: {
        'opd_id' : this.$route.params.opd_id,
        'info_id' : this.$route.params.info_id,
        'id' : item.id,
        'status' : 'detail'
      }})
    },
    async fetchProbis(){
			return this.$http.get(this.$app.route('domain-data-informasi.get_probis_data', {id: this.$route.params.info_id})).then((res) => {
        let result = res.data.data
        let probis_id = []
  
        probis_id = result.map(value => {
          return { key: value.key, probis: value.probis, proses_id: value.proses_id }
        })
  
        this.form.probis_terkait = probis_id

      }).catch(error => {
        return console.error(error);
      })
		},
    async resPerangkatDaerahById(){
			return this.$http.get(this.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.form.opd_id})).then((res) => {
				this.form.nama_opd = res.data[0] ? res.data[0].nama_opd : ''
			})
		},
    async loadDataInformasi(){
      let data = this.$route.params.info_id ? { exclude: this.$route.params.info_id } : {}
			return this.$http.get(this.$app.route('domain-data-informasi.get-data-master', data)).then((res) => {
				this.options.data = res.data
				// this.model.aplikasi_selected = this.opd_id ? res.data.find(val => val.opd_id === this.opd_id) : null
			})
		},
    async submit() {
      let vm = this

      if(this.$route.params.status == 'update')
      {
        let { opd_id, nama_data,radl1, radl2, radl3, probis_terkait } = vm.form
        let data =  {
          data_name: nama_data.toUpperCase(),
          radl1: radl1.kode,
          radl2: radl2.kode,
          radl3: radl3.kode,
          opd_id: opd_id,
          probis_terkait: probis_terkait
        }
        let mode = 'edit'
        let formData = this.$app.objectToFormData(data)
        if (!this.isNew) {
          formData.append('_method', 'GET')
        }
        let url = vm.$app.route(this.isNew ? `${this.routeName}.store` : `${this.routeName}.update`, { info_id: this.$route.params.info_id })
        vm.$app.confirm({
          text: vm.$t(`domain.alert_data_informasi.confirm.${mode}`),
          preConfirm: () => {
            return vm.$http.post(url, formData)
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
          if (result.isDismissed) return
          if (result.value.data.status == "success" || result.value.data.status == "info") {
            vm.$app.alert.fire({
              icon: result.value.data.status,
              title: result.value.data.status ? 'Sukses' : 'Info',
              text: result.value.data.message,
              showConfirmButton: false,
              timer: 1300
            }).then(response => {
			          this.$router.go(-1)
                vm.$root.$emit('bv::refresh::table', 'datainfotable')
            })
          }
        })
      }else{
        let { unit, opd_id, nama_data, desc_data, dest_data, comp_data, format, type_data2_other, validitas_data, jml_record, interoperabilitas, penanggung_jawab, radl1, radl2, radl3, probis_terkait, prop_data, resiko, level_data, pengambilan_data } = vm.form
        let data =  {
          opd_id: opd_id,
          unit: unit ? unit.value : null,
          data_name: nama_data.toUpperCase(),
          desc_data: desc_data,
          dest_data: dest_data,
          comp_data: comp_data,
          format: this.form.format ? this.form.format : null,
          interoperabilitas: interoperabilitas,
          jml_record: jml_record,
          type_data2_other: this.form.type_data2_other ? this.form.type_data2_other : null,
          validitas_data: validitas_data,
          penanggung_jawab: penanggung_jawab,
          radl1: radl1.kode,
          radl2: radl2.kode,
          radl3: radl3.kode,
          probis_terkait: probis_terkait ? this.form.probis_terkait : null,
          prop_data: prop_data.value,
          type_data1: this.selected.type_data1 ? this.selected.type_data1.value : null,
          format_struct: this.selected.format_struct ? this.selected.format_struct.value : null,
          format_unstruct: this.selected.format_unstruct ? this.selected.format_unstruct.value : null,
          type_data2: this.selected.type_data2 ? this.selected.type_data2.value : null,
          resiko: resiko.value,
          level_data: level_data.value,
          pengambilan_data: pengambilan_data.value,
          interoperabilitas: this.selected.interoperabilitas
        }
        // console.log(data);
        let mode = this.isNew ? 'add' : 'edit'
        let formData = this.$app.objectToFormData(data)
        if (!this.isNew) {
          formData.append('_method', 'GET')
        }
        let url = vm.$app.route(this.isNew ? `${this.routeName}.store` : `${this.routeName}.update`, { info_id: this.$route.params.info_id })
        vm.$app.confirm({
          text: vm.$t(`domain.alert_data_informasi.confirm.${mode}`),
          preConfirm: () => {
            return vm.$http.post(url, formData)
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
          if (result.isDismissed) return
          if (result.value.data.status == "success" || result.value.data.status == "info") {
            vm.$app.alert.fire({
              icon: result.value.data.status,
              title: result.value.data.status ? 'Sukses' : 'Info',
              text: result.value.data.message,
              showConfirmButton: false,
              timer: 1300
            }).then(response => {
			          this.$router.go(-1)
                vm.$root.$emit('bv::refresh::table', 'datainfotable')
            })
          }
        })
      }
    },
    getUnit(){
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain.data-perangkat-daerah.get', {opd_id: this.$route.params.opd_id}), {
          params: {
            'opd_id' : this.opd_id
          }
        })
        .then(response => {
          const unitOption = [];
          response.data.map(function (value, key) {
            unitOption.push({ value: [value.opd_id, value.nama_opd], label: value.nama_opd });
          });

          vm.options['unit'] = unitOption
        })
    },
    async getRadl1() {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-data-informasi.get_radl1'),{
          params: {
          }
        })
        .then(({ data }) => {
          vm.options['radl1'] = data
        })
    },
    async getRadl2(kode = '') {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-data-informasi.get_radl2'),{
          params: {
            kode: kode
          }
        })
        .then(({ data }) => {
          vm.options['radl2'] = data
        })
    },
    async getRadl3(kode = '') {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-data-informasi.get_radl3'),{
          params: {
            kode: kode
          }
        })
        .then(({ data }) => {
          vm.options['radl3'] = data
        })
    },
    getProbis() {
      let vm = this
      vm.groupLoading = true
      vm.$http
        .get(vm.$app.route('domain-data-informasi.get_probis_terkait'),{
          params: {
            'opd_id' : this.$route.params.opd_id
          }
        })
        .then(({ data }) => {
          vm.options['probis_terkait'] = data.data
        })
    },
    async resDataInformasi(){
			const res = await this.$http.get(this.$app.route('domain-data-informasi.data-informasi.get', {info_id: this.$route.params.info_id}))
      let result = res.data
      this.form = {...this.form, ...result}
      this.form.radl1 = {
        kode: result.rad_level_1,
        kode_nama: result.rad_level_1_nama
      }

      this.form.radl2 = {
        kode: result.rad_level_2,
        kode_nama: result.rad_level_2_nama
      }

      this.form.radl3 = {
        kode: result.rad_level_3,
        kode_nama: result.rad_level_3_nama
      }
		},
  }
}
</script>

<style lang="scss">

#tree-feature {
  margin-left: -1rem;
  margin-right: -1rem;
  font-family: "Poppins", sans-serif;

  .e-list-text {
    font-size: 13px;
  }
}
</style>
<style>
.control_wrapper {
  display: block;
  max-width: 350px;
  max-height: 350px;
  margin: auto;
  overflow: auto;
  border: 1px solid #dddddd;
  border-radius: 3px;
}

.radius_icon_password {
  border-radius: 0px 4px 4px 0px !important;
}

.custom-checkbox {
  width: 300px;
  padding-top: 7px;
  padding-bottom: 12px;
}

.custom-radio {
  padding-top: 5px;
}

.multiselect {
  width: 100% !important;
}

.multiselect__tag {
  padding: 7px 26px 7px 11px !important;
  margin: 3px 4px !important;
}

.disabled-nrk {
  background: #f3f3f3 !important;
}
</style>
