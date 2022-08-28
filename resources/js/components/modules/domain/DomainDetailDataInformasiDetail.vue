<template>
  <b-card class="p-3">
    <b-row>
      <b-col lg="12" md="12" sm="12" class="text-right">
        <button
          type="button"
          style="margin: 10px 15px 0px;"
          class="btn btn-danger btn-sm rounded waves-effect waves-themed mb-4"
          v-b-tooltip.hover.top="$t('general.button.back')"
          @click="onBack">
          <i class="fal fa-arrow-circle-left"></i>
          {{ $t('general.button.back') }}
        </button>
      </b-col>
    </b-row>
    <validation-observer v-slot="{ passes }" :slim="true">
      <form>
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
          -->

          <b-form-group
            label-for="desc_data"
            :label="$t('domain.form.field.desc_data.label')">
            <ValidationProvider
              rules="required" v-slot="{ errors }"
              :name="$t('domain.form.field.desc_data.label')" :debounce="250">
              <b-form-textarea :disabled="true"
                :id="'desc_data'"
                v-model="form.desc_data"
                rows="3"
                max-rows="6"
                placeholder="-">
              </b-form-textarea>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="dest_data"
            :label="$t('domain.form.field.dest_data.label')">
            <ValidationProvider
              rules="required" v-slot="{ errors }"
              :name="$t('domain.form.field.dest_data.label')" :debounce="250">
              <b-form-textarea :disabled="true"
                :id="'dest_data'"
                v-model="form.dest_data"
                rows="3"
                max-rows="6"
                placeholder="-">
              </b-form-textarea>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="comp_data"
            :label="$t('domain.form.field.comp_data.label')">
            <ValidationProvider
              rules="required" v-slot="{ errors }"
              :name="$t('domain.form.field.comp_data.label')" :debounce="250">
              <b-form-textarea :disabled="true"
                :id="'comp_data'"
                v-model="form.comp_data"
                rows="3"
                max-rows="6"
                placeholder="-">
              </b-form-textarea>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group label-for="prop_data" :label="$t('domain.form.field.prop_data.label')">
            <input v-model="form.prop_data" type="hidden">
            <ValidationProvider
              rules="required" v-slot="{ valid, errors }"
              :name="$t('domain.form.field.prop_data.label')">
              <b-form-input
                :id="'prop_data'"
                v-model="form.prop_data"
                placeholder="-" :disabled="true">
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group label-for="type_data1" :label="$t('domain.form.field.type_data1.label')">
            <ValidationProvider
              rules="required" v-slot="{ valid, errors }"
              :name="$t('domain.form.field.type_data1.label')" :debounce="250">
              <b-form-input
                id="type_data1"
                v-model="form.type_data1"
                placeholder="-" :disabled="true">
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <div v-if="form.type_data1 !== null">
            <span v-if="form.type_data1 === 'Unstructured'">
              <b-form-group label-for="format_unstruct" :label="$t('domain.form.field.format_unstruct.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.format_unstruct.label')" :debounce="250">
                  <b-form-input
                    id="format_unstruct"
                    v-model="form.format_unstruct"
                    placeholder="-" :disabled="true">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>
              <br>
            </span>
            <span v-else>
              <b-form-group label-for="format_struct" :label="$t('domain.form.field.format_struct.label')">
                <ValidationProvider
                  rules="required" v-slot="{ valid, errors }"
                  :name="$t('domain.form.field.format_struct.label')" :debounce="250">
                  <b-form-input
                    id="format_struct"
                    v-model="form.format_struct"
                    placeholder="-" :disabled="true">
                  </b-form-input> 
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>
              <br>
            </span>
          </div>

          <div v-if="form.format_struct !== null">
            <span v-if="form.format_struct === 'Lainnya'">
              <b-form-group
                label-for="format"
                :label="$t('domain.form.field.format.label')">
                <ValidationProvider
                  rules="required" v-slot="{errors }"
                  :name="$t('domain.form.field.format.label')" :debounce="250">
                  <b-form-input :disabled="true"
                    :id="'format'"
                    v-model="form.format"
                    placeholder="-">
                  </b-form-input>
                  <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
                </ValidationProvider>
              </b-form-group>
              <br>
            </span>
            <span v-else>
            </span>
          </div>

          <div v-if="form.format_unstruct !== null">
            <span v-if="form.format_unstruct === 'Lainnya'">
              <b-form-group :disabled="true"
                label-for="format"
                :label="$t('domain.form.field.format.label')">
                <ValidationProvider
                  rules="required" v-slot="{errors }"
                  :name="$t('domain.form.field.format.label')" :debounce="250">
                  <b-form-input
                    :id="'format'"
                    v-model="form.format"
                    :placeholder="'-'">
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
            <ValidationProvider
              rules="required" v-slot="{ valid, errors }"
              :name="$t('domain.form.field.type_data2.label')" :debounce="250">
              <b-form-input
                id="type_data2"
                v-model="form.type_data2"
                placeholder="-" :disabled="true">
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <div v-if="form.type_data2 !== null">
            <span v-if="form.type_data2 === 'Data Induk Lainnya'">
              <b-form-group
                label-for="type_data2_other"
                :label="$t('domain.form.field.type_data2_other.label')">
                <ValidationProvider
                  rules="required" v-slot="{errors }"
                  :name="$t('domain.form.field.type_data2_other.label')" :debounce="250">
                  <b-form-input :disabled="true"
                    :id="'type_data2_other'"
                    v-model="form.type_data2_other"
                    :placeholder="'-'">
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
              <b-form-input :disabled="true"
                :id="'validitas_data'"
                v-model="form.validitas_data"
                :placeholder="'-'">
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
              <b-form-input :disabled="true"
                :id="'penanggung_jawab'"
                v-model="form.penanggung_jawab"
                :placeholder="'-'">
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group b-form-group
            label-for="interoperabilitas"
            :label="$t('domain.form.field.interoperabilitas.label')">
            <ValidationProvider
              rules="required" v-slot="{ errors }"
              :name="$t('domain.form.field.interoperabilitas.label')" :debounce="250">
              <m-select
                  id="interoperabilitas"
                  ref="interoperabilitas"
                  class="mb-2"
                  :multiple="true"
                  :options="options.data"
                  v-model="form.interoperabilitas"
                  :custom-label="labelData"
                  placeholder=""
                  track-by="info_id"
                  :disabled="true"		
              >     
              </m-select>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group label-for="resiko" :label="$t('domain.form.field.resiko.label')">
            <input v-model="form.resiko" type="hidden">
            <ValidationProvider
              rules="required" v-slot="{ valid, errors }"
              :name="$t('domain.form.field.resiko.label')" :debounce="250">
              
              <b-form-input :disabled="true"
                    :id="'resiko'"
                    v-model="form.resiko"
                    placeholder="-">
              </b-form-input>

              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group label-for="level_data" :label="$t('domain.form.field.level_data.label')">
            <input v-model="form.level_data" type="hidden">
            <ValidationProvider
              rules="required"
              :name="$t('domain.form.field.level_data.label')" :debounce="250">
              <b-form-input :disabled="true"
                    :id="'level_data'"
                    v-model="form.level_data"
                    placeholder="-">
              </b-form-input>

            </ValidationProvider>
          </b-form-group>

          <b-form-group label-for="pengambilan_data" :label="$t('domain.form.field.pengambilan_data.label')">
            <input v-model="form.pengambilan_data" type="hidden">
            <ValidationProvider
              rules="required" v-slot="{ valid, errors }"
              :name="$t('domain.form.field.pengambilan_data.label')" :debounce="250">
              <b-form-input :disabled="true"
                  :id="'pengambilan_data'"
                  v-model="form.pengambilan_data"
                  placeholder="-"
              >
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>

          <b-form-group
            label-for="jml_record"
            :label="$t('domain.form.field.jml_record.label')">
            <ValidationProvider
              rules="required" v-slot="{errors }"
              :name="$t('domain.form.field.jml_record.label')" :debounce="250">
              <b-form-input :disabled="true"
                :id="'jml_record'"
                v-model="form.jml_record"
                type="number"
                :placeholder="'-'">
              </b-form-input>
              <invalid-feedback :error="errors[0]" class="margin-0"></invalid-feedback>
            </ValidationProvider>
          </b-form-group>
        </template>
      </form>
    </validation-observer>
  </b-card>
</template>

<script>
export default {
  name: 'DomainDetailDataInformasiDetail',
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
        nama_data: null,
        info_id: null,
        unit: null,
        selected: null,
        id_opd: null,
        prop_data: null,
        nama_data: null,
        desc_data: null,
        dest_data: null,
        comp_data: null,
        format: null,
        type_data1: null,
        type_data2: null,
        type_data2_other: null,
        validitas_data: null,
        penanggung_jawab: null,
        interoperabilitas: null,
        resiko: null,
        level_data: null,
        pengambilan_data: null,
        jml_record: null

      },
      statusOptions: [
        { id: 1, name: 'Aktif' },
        { id: 0, name: 'Tidak Aktif' },
      ],
      fieldTypePasword: 'password',
      iconPassword: 'fa-eye-slash',
      fieldTypePaswordConfirm: 'password',
      iconPasswordConfirm: 'fa-eye-slash',
      options: {
        unit: [],
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
          { value: 'Repurtasi', label: 'Repurtasi' },
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
    this.isUpdate = (this.$route.params.status == 'update')?false:true
    this.getUnit();
    if(this.$route.params.status == 'detail')
    {
      this.resDetailData();
    } else {
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
      this.form.prop_data = result['sifat_data']
      this.form.type_data1 = result['jenis_data1']
      this.form.type_data2 = result['jenis_data2']
      this.form.format_unstruct = result['format_unstruct']
      this.form.format_struct = result['format_struct']
      this.form.resiko =  result['dampak_risiko']
      this.form.level_data = result['level_data']
      this.form.pengambilan_data = result['metode']
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
    onBack() {
      this.$router.go(-1)
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
    // async resDataInformasi(){
		// 	const res = await this.$http.get(this.$app.route('domain-data-informasi.data-informasi.get', {info_id: this.$route.params.info_id}))
    //   let result = res.data
    //   this.form = result
		// },
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
