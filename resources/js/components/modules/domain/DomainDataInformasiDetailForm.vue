<template>
  <b-card class="p-3">
    <validation-observer v-slot="{ passes }" :slim="true">
      <form @submit.prevent="passes(submit)">
        <template>
          <!-- <b-form-group
            label-for="info_id"
            :label="'Info ID'" v-show="false">
            <ValidationProvider
              rules="required" v-slot="{errors }"
              :name="'Info ID'" :debounce="250">
              <b-form-input
                :id="'info_id'"
                v-model="$route.params.info_id"
                :placeholder="'Masukkan Info ID'">
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group label-for="id_opd" :label="$t('domain.form.field.opd_id.label')" v-show="false">
            <input v-model="form.id_opd" type="hidden">
            <ValidationProvider
              rules="required" v-slot="{ errors }"
              :name="$t('domain.form.field.opd_id.label')" :debounce="250">
              <b-form-input
                :id="'id_opd'"
                v-model="$route.params.opd_id"
                placeholder="ID OPD"
                :readonly="true"
                :disabled="true">
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group label-for="unit" :label="$t('domain.form.field.unit.label')" v-show="false">
            <input v-model="form.unit" type="hidden">
            <ValidationProvider
              rules="required" v-slot="{ valid, errors }"
              :name="$t('domain.form.field.unit.label')" :debounce="250">
              <m-select
                id="unit" v-model="form.unit" :options="options.unit" :multiple="false"
                :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                :placeholder="$t('domain.form.field.unit.placeholder')" label="label" track-by="value"
                :searchable="true" :state="errors[0] ? false : (valid ? true : null)"
                :disabled="true">
              </m-select>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group> -->

          <!-- <b-form-group
            label-for="nama_data"
            :label="$t('domain.form.field.data_name.label')" v-show="false">
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
          </b-form-group> -->

          <!-- <b-form-group label-for="radl1" :label="$t('domain.form.field.radl1.label')">
            <input v-model="form.radl1" type="hidden">
            <ValidationProvider
              rules="required" v-slot="{ valid, errors }"
              :name="$t('domain.form.field.radl1.label')" :debounce="250">
              <m-select
                id="radl1" v-model="form.radl1" :options="options.radl1" :multiple="false"
                :close-on-select="true" :clear-on-select="false" :preserve-search="true" :preselect-first="true"
                :placeholder="$t('domain.form.field.radl1.placeholder')" label="radl" track-by="key"
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
                :placeholder="$t('domain.form.field.radl2.placeholder')" label="radl" track-by="key"
                :searchable="true" :state="errors[0] ? false : (valid ? true : null)">
              </m-select>
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
          </b-form-group> -->

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
            <span v-if="selected.type_data1.label === 'Unstructured'">
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
              <br>
            </span>
            <span v-else>
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
              <br>
            </span>
          </div>

          <div v-if="selected.format_struct === null">
          </div>
          <div v-else>
            <span v-if="selected.format_struct.label === 'Lainnya'">
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
              <br>
            </span>
            <span v-else>
            </span>
          </div>

          <div v-if="selected.format_unstruct === null">
          </div>
          <div v-else>
            <span v-if="selected.format_unstruct.label === 'Lainnya'">
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
              <br>
            </span>
            <span v-else>
            </span>
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

          <div v-if="selected.type_data2 === null">
          </div>
          <div v-else>
            <span v-if="selected.type_data2.label === 'Data Induk Lainnya'">
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
              <br>
            </span>
            <span v-else>
            </span>
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
                  v-model="form.interoperabilitas"
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
  </b-card>
</template>

<script>
export default {
  name: 'DomainDataInformasiDetailForm',
  props: {
    props: ['info_id', 'opd_id', 'status', 'id'],
  },
  data() {
    let resourceName = 'domain-data-informasi';
    return {
      form: {
        nama_data: null,
        info_id: null
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
        unit: null,
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
        prop_data: null,
        type_data1: null,
        format_struct: null,
        format_unstruct: null,
        type_data2: null,
        resiko: null,
        level_data: null,
        pengambilan_data: null,
      },
      options: {
        unit: [],
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
    isNew() {
      return this.$route.params.status === undefined ? true : false
    }
  },
  watch: {
	},
  created() {
    console.log(this.$route.params.id);
    // console.log(this.$route.params.opd_id);
    this.isUpdate = (this.$route.params.status == 'update')?false:true
    if(this.$route.params.status == 'detail')
    {
      this.resDetailData();
    } else {
      this.loadDataInformasi();
    }
    this.resDataInformasi();

    this.getUnit();
    if(this.$route.params.status == 'update')
    {
      this.resDetailData();
    }
  },
  methods: {
    labelData ({nama_data, akronim}) {
			return `${akronim} - ${nama_data}`
		},
    async resDetailData(){
			const res = await this.$http.get(this.$app.route('domain-data-informasi.detail-data-informasi.get', {id: this.$route.params.id}))
      let result = res.data
      let prop_data = _.find(this.options.prop_data, function(o) { return o.value == result['sifat_data'] ; })
      this.form.prop_data = prop_data
      let type_data1 = _.find(this.options.type_data1, function(o) { return o.value == result['jenis_data1'] ; })
      this.selected.type_data1 = type_data1
      let format_unstruct = _.find(this.options.format_unstruct, function(o) { return o.value == result['format_unstruct'] ; })
      this.selected.format_unstruct = format_unstruct ? format_unstruct : null
      let format_struct = _.find(this.options.format_struct, function(o) { return o.value == result['format_struct'] ; })
      this.selected.format_struct = format_struct ? format_struct : null
      let type_data2 = _.find(this.options.type_data2, function(o) { return o.value == result['jenis_data2'] ; })
      this.selected.type_data2 = type_data2
      let resiko = _.find(this.options.resiko, function(o) { return o.value == result['dampak_risiko'] ; })
      this.form.resiko = resiko
      let level_data = _.find(this.options.level_data, function(o) { return o.value == result['level_data'] ; })
      this.form.level_data = level_data
      let pengambilan_data = _.find(this.options.pengambilan_data, function(o) { return o.value == result['metode'] ; })
      this.form.pengambilan_data = pengambilan_data
      this.form.format = result['format_lain']
      this.form.type_data2_other = result['jenis_lain']
      this.form.desc_data = result['uraian_data']
      this.form.dest_data = result['tujuan_data']
      this.form.comp_data = result['komponen_data']
      this.form.validitas_data = result['komponen_data']
      this.form.penanggung_jawab = result['data_owner']
      this.form.interoperabilitas = result.interoperabilitas.map((item) => {
					return {...item, akronim: item.opd.akronim}
				})
      this.form.jml_record = result['jumlah_record']
		},
    async loadDataInformasi(){
      let data = this.$route.params.info_id ? { exclude: this.$route.params.info_id } : {}
			return this.$http.get(this.$app.route('domain-data-informasi.get-data-master', data)).then((res) => {
				this.options.data = res.data
			})
		},
    async submit() {
      let vm = this

      let { unit, nama_data, desc_data, dest_data, comp_data, validitas_data, jml_record, interoperabilitas, penanggung_jawab, prop_data, resiko, level_data, pengambilan_data } = vm.form
      let data =  {
        info_id : this.$route.params.info_id,
        unit: unit ? unit.value : null,
        data_name: nama_data.toUpperCase(),
        desc_data: desc_data,
        dest_data: dest_data,
        comp_data: comp_data,
        format: this.form.format ? this.form.format : null,
        interoperabilitas: interoperabilitas.map(item => item.info_id),
        jml_record: jml_record,
        type_data2_other: this.form.type_data2_other ? this.form.type_data2_other : null,
        validitas_data: validitas_data,
        penanggung_jawab: penanggung_jawab,
        prop_data: prop_data.value,
        type_data1: this.selected.type_data1 ? this.selected.type_data1.value : null,
        format_struct: this.selected.format_struct ? this.selected.format_struct.value : null,
        format_unstruct: this.selected.format_unstruct ? this.selected.format_unstruct.value : null,
        type_data2: this.selected.type_data2 ? this.selected.type_data2.value : null,
        resiko: resiko.value,
        level_data: level_data.value,
        pengambilan_data: pengambilan_data.value
      }
      let mode = this.isNew ? 'add' : 'edit'
      let formData = this.$app.objectToFormData(data)
      if (!this.isNew) {
        formData.append('_method', 'GET')
      }
      let url = vm.$app.route(this.isNew ? `${this.routeName}.store_detail` : `${this.routeName}.update_detail`, { id: this.$route.params.id })
      vm.$app.confirm({
        text: vm.$t(`domain.alert_detail_data_informasi.confirm.${mode}`),
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
                this.$router.push({ name: 'data-informasi-detil' })
                vm.$root.$emit('bv::refresh::table', 'datainfotable')
            })
        }
      })
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
          this.form.unit = unitOption[0];
          vm.options['unit'] = unitOption
        })
    },
    async resDataInformasi(){
			const res = await this.$http.get(this.$app.route('domain-data-informasi.data-informasi.get', {info_id: this.$route.params.info_id}))
      let result = res.data
      this.form = result
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
